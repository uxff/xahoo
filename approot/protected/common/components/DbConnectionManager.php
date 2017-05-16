<?php
/**
 * DbConnectionMan(Database Connection Manager) class is a manager of database connections.
 * for the purpose of database read/write splitting.
 * It override the createCommand method,
 * detect the sql statement to decide which connection will be used.
 * Default it use the master connection.
 *
 * 主数据库写，从数据库（可多个）读
 * 实现主从数据库读写分离：
 * 1. 主服务器无法连接 从服务器可切换写功能
 * 2. 从服务器无法连接 主服务器可切换读功
 * 
 * @author liutao@fangfull.com
 * 
 */
class DbConnectionManager extends CDbConnection {

    const LOG_KEY = '[ares][db_manager]';

    public $timeout = 10; //连接超时时间，set default 10 seconds connection timeout

    public $markDeadSeconds = 600; //如果从数据库连接失败 600秒内不再连接
    //if connect a slave db cause error,then mark this slave as dead for 10 minutes.
    //after 10 minutes,mark dead cache will automatically expire.


    //use cache as global flags storage
    public $cacheID = 'cache'; //用 cache 作为缓存全局标记

    /**
    * @var array $slaves.Slave database connection(Read) config array.
    * The array value's format is the same as CDbConnection.
    * 
    * 配置从服务器CDbConnection
    * 
    * @example
    * 'components'=>array(
    * 		'db'=>array(
    * 			'connectionString'=>'mysql://<master>',
    * 			'slaves'=>array(
    * 				array('connectionString'=>'mysql://<slave01>'),
    * 				array('connectionString'=>'mysql://<slave02>'),
    * 			)
    * 		)
    * )
    */
    public $slaves = array();



    /**
    * Whether enable the slave database connection.
    * Defaut is true.Set this property to false for the purpose of only use the master database.
    *
    * @var bool $enableSlave  从数据库状态 false 则只用主数据库
    */
    public $enableSlave = true;

    /**
     * @var slavesWrite 紧急情况主数据库无法连接 切换从服务器（读写）.
     */
    public $slavesWrite = false;
 
    /**
     * @var masterRead 紧急情况从主数据库无法连接 切换从服务器（读写）.
     */
    public $masterRead = false;


    /**
     * @var _slave
     */
    private $_slave;

    /**
     * Emergency use when master server is unavailable switch to readonly slave server.
     *
     * @var _disableWrite 从服务器（只读）
     */
    private $_disableWrite = false;


    /**
    * Creates a CDbCommand object for excuting sql statement.
    * It will detect the sql statement's behavior.
    * While the sql is a simple read operation.
    * It will use a slave database connection to contruct a CDbCommand object.
    * Default it use current connection(master database).
    *
    * 重写 createCommand 方法，切换从库条件为：1.开启从库 2.存在从库 3.当前不处于一个事务中 4.从库读数据
    * 
    * @override
    * @param string $sql
    * @return CDbCommand
    */
    public function createCommand($sql = null) {
        if ($this->enableSlave
                && !empty($this->slaves)
                && is_string($sql)
                && !$this->getCurrentTransaction()
                && self::isReadOperation($sql)
                && ($slave = $this->getSlave())
        ) {
            Yii::log("Slave database connection SUCCESS!\n\tConnection string:{$slave->connectionString}",'info');
            return $slave->createCommand($sql);
        } else {
            if ($this->_disableWrite && !self::isReadOperation($sql)) {
                throw new CDbException("Master db server is not available now!Disallow write operation on slave server!");
            }
            Yii::log("Master database connection SUCCESS!",'info');
            return parent::createCommand($sql);
        }
    }


    /**
     * Construct a slave connection CDbConnection for read operation.
     *
     * 获得从服务器连接资源
     * 
     * @return CDbConnection
     */
    public function getSlave() {
        if (!isset($this->_slave)) {
            shuffle($this->slaves);
            foreach ($this->slaves as $slaveConfig) {
                // 无法连接
                if ($this->_isDeadServer($slaveConfig['connectionString'])) {
                    continue;
                }
                // 未设置class，使用默认数据库连接类
                if (!isset($slaveConfig['class'])) {
                    $slaveConfig['class'] = 'CDbConnection';
                }

                // 从库连接超时自动重新连接
                $slaveConfig['autoConnect'] = false;
                try {
                    // 创建从库连接
                    if ($slave = Yii::createComponent($slaveConfig)) {
                        Yii::app()->setComponent('dbslave', $slave);
                        $slave->setAttribute(PDO::ATTR_TIMEOUT, $this->timeout);
                        $slave->setActive(true);
                        $this->_slave = $slave;
                        break;
                    }
                } catch (Exception $e) {
                    $this->_markDeadServer($slaveConfig['connectionString']);
                    Yii::log("Slave database connection failed!\n\tConnection string:{$slaveConfig['connectionString']}",'warning');

                    continue;
                }
            }

            // 从库都连接不上
            if (!isset($this->_slave)) {
                $this->_slave = null;
                $this->enableSlave = false;
            }
        }

        return $this->_slave;
    }

    /**
     * 重写父类方法
     * 
     * @param boolean  $value 是否启用
     */
    public function setActive($value) {
        if($value != $this->getActive()) {
            //启用
            if($value) {
                try {
                    if ($this->_isDeadServer($this->connectionString)) {
                        throw new CDbException('Master db server is already dead!');
                    }
                    try {
                        //PDO::ATTR_TIMEOUT must set before pdo instance create
                        $this->setAttribute(PDO::ATTR_TIMEOUT, $this->timeout);
                        $this->open();
                    } catch(Exception $e) {
                        $this->_markDeadServer($this->connectionString);
                        throw $e;
                    }
                } catch (Exception $e) {
                    $slave = $this->getSlave();
                    Yii::log($e->getMessage(), CLogger::LEVEL_ERROR, 'exception.CDbException');
                    
                    // 当前连接失效时，重新建立连接
                    if ($slave) { //从库available时切换到从库，根据配置设置是否从库可写
                        $this->connectionString = $slave->connectionString;
                        $this->username = $slave->username;
                        $this->password = $slave->password;
                        if ($this->slavesWrite) { //不允许从库写
                            $this->_disableWrite = false;
                        }
                        $this->open();
                    } else { //从库unavailable且允许读时，切换到主库，
                        if ($this->masterRead) { //允许主库读
                            $this->connectionString = $this->connectionString;
                            $this->username = $this->username;
                            $this->password = $this->password;
                            $this->open();
                        } else {
                            throw new CDbException(Yii::t('yii','CDbConnection failed to open the DB connection.'),(int)$e->getCode(),$e->errorInfo);
                        }
                    }
                }
            } else {
                $this->close();
            }
        }
    }

    /**
     * Detect whether the sql statement is just a simple read operation.
     * Read Operation means this sql will not change any thing ang aspect of the database.
     * Such as SELECT,DECRIBE,SHOW etc.
     * On the other hand:UPDATE,INSERT,DELETE is write operation.
     *
     * 检测读操作 sql 语句
     * 读关键字:  SELECT,DECRIBE,SHOW ...
     * 写关键字:  UPDATE,INSERT,DELETE ...
     */
    public static function isReadOperation($sql) {
        $sql = substr(ltrim($sql),0,10);
        $sql = str_ireplace(array('SELECT','SHOW','DESCRIBE','PRAGMA'), '^O^', $sql);//^O^,magic smile
        return strpos($sql, '^O^') === 0;
    }

    /**
     * Detect is this slave config already marked as dead for a period time in cache.
     * 检测从服务器是否被标记为 失败
     */
    private function _isDeadServer($c) {
        $cache = Yii::app()->{$this->cacheID};
        if ($cache && $cache->get('DeadServer::'.$c) == 1) {
            return true;
        }
        return false;
    }

    /**
     * Mark this slave config as dead.
     * 标记失败的slaves
     */
    private function _markDeadServer($c) {
        $cache = Yii::app()->{$this->cacheID};
        if ($cache) {
            $cache->set('DeadServer::'.$c, 1, $this->markDeadSeconds);
        }
    }

}