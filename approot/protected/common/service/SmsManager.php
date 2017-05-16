<?php
Yii::import("application.common.extensions.AresRESTClient");
/**
 * SmsManager class file.
 * @author zhaoting@fangfull.com
 * @copyright Copyright &copy; zhaoting 2015
 * 接口说明：客户接口部分提供http url方式的接口，根据客户需求可以提供相应接口，接口编码方式采用统一的UTF-8
 *
*/

/**
 * 短信服务管理类
 */
class SmsManager extends CApplicationComponent 
{
    // 入口地址
    private $_point = '';
    // 不同编码接口地址
    const SMS_SERVICE_ENDPOINT_UTF = 'http://sms.chanzor.com:8001/sms.aspx'; // 对应UTF-8编码
    const SMS_SERVICE_ENDPOINT_GB = 'http://sms.chanzor.com:8001/smsGBK.aspx'; // 对应GB2312

    // 上行回调接口
    const SMS_SERVICE_CALLBACK_ENDPOINT = 'http://sms.chanzor.com:8001/callApi.aspx'; 

    // 状态报告接口
    const SMS_SERVICE_STATUS_ENDPOINT = 'http://sms.chanzor.com:8001/statusApi.aspx';

    /**
     * @var 企业id
     * 企业ID，为空不需要
     */
    private $_userid = '';

    /**
     * @var 发送用户帐号
     * 用户帐号，由系统管理员
     */
    private $_account = 'xinqishijie';

    /**
     * @var 发送帐号密码
     * 用户账号对应的密码
     */
    private $_password = '133271';

    /**
     * @var 全部被叫号码
     * 发信发送的目的号码.多个号码之间用半角逗号隔开 
     */
    private $_mobile = '';

    /**
     * @var 发送内容
     * 短信的内容，内容需要UTF-8编码
     */
    private $_content = '';

    /**
     * @var 定时发送时间
     * 为空表示立即发送，定时发送格式2010-10-24 09:08:10
     */
    private $_sendTime = '';

    /**
     * @var 发送任务命令
     * 设置为固定的:send
     */
    private $_action = 'send';

    /**
     * @var 扩展子号
     * 请先询问配置的通道是否支持扩展子号，如果不支持，请填空。子号只能为数字，且最多5位数。
     */
    private $_extnoextnoextno = '';

    /**
     * Yii RESTClient Components
     * 
     */
    private $_aresRESTClient = '';

    /**
     * 签名
     * 
     */
    private $_sign = '【新奇世界】';

    /**
     * 返回信息的格式
     * 
     */
    private $_formats = 'xml';


    /**
     * Constructor.
     * @param mobile    发信发送的目的号码.多个号码之间用半角逗号隔开 
     * @param content   短信内容 
     * @param action    操作 
     * @param sendTime  发送时间  默认立即发送 
     * @param charset   type:utf8,gb2312
     */
    public function __construct($charset = null)
    {
        $this->_aresRESTClient = new AresRESTClient();

        // 根据编码访问不同接口
        if (!empty($charset)) {
            if ($charset == 'utf8') {
                $this->_point = self::SMS_SERVICE_ENDPOINT_UTF;
            } elseif($charset == 'gb2312') {
                $this->_point = self::SMS_SERVICE_ENDPOINT_GB;
            }
        } else {
            $this->_point = self::SMS_SERVICE_ENDPOINT_UTF;
        }

    }

    /**
     * 发送接口
     * @param array($mobile,$content,$sendTime= null)
     * @return  
     *  returnstatus  成功返回Success 失败返回：Faild
     *  message       提示信息
     *  remainpoint   返回余额
     *  taskID        返回本次任务的序列ID
     *  successCounts 成功短信数：当成功后返回提交成功短信数
     */
    public function send($mobile,$content,$sendTime = null)
    {
        // 判断手机号是否为空
        if (empty($mobile)) {
            $message = '无效的手机号';
        }
        // 判断短信内容是否为空
        if (empty($content)) {
            $message = '无效信息内容';
        }

        // 发送时间
        if (!empty($sendTime)) {
            $this->_sendTime = $sendTime;
        }
        if (empty($message)) {
            // 参数
            $params = array (
                        'action' => 'send',
                        'account' => $this->_account,
                        'password' => $this->_password,
                        'userid' => $this->_userid,
                        'mobile' => $mobile,
                        'content' => $content.$this->_sign, 
                        'sendTime' => $this->_sendTime,
                );

            // 检测发送内容是否合法
            $checkResult = self::checkkeyword($content);
            if (empty($checkResult)) {
                $result = $this->_aresRESTClient->doPost($this->_point,$params,$this->_formats);
                // 判断错误信息
                if ($result['returnstatus'] == 'Success') {
                    return $result;
                } else {
                    return array('returnstatus'=>'Fail','message'=>$result['message']);
                }
            } else {
                return array('returnstatus'=>'Fail','message'=>$checkResult['message']);
            }
        } else {
            return array('returnstatus'=>'Fail','message'=>$message);
        }
    }

    /**
     * 查询余额
     * @param array()
     * @return  
     *  returnstatus 成功返回Success 失败返回：Faild
     *  message      提示信息
     *  payinfo      支付方式  后付费，预付费
     *  overage      余额
     *  sendTotal    返回总点数  当支付方式为预付费是返回总充值点数
     */
    public function overage()
    {
        // 参数
        $params = array (
                    'action' => 'overage',
                    'account' => $this->_account,
                    'password' => $this->_password,
                    'userid' => $this->_userid,
            );

        $result = $this->_aresRESTClient->doPost($this->_point,$params,$this->_formats);
        // 判断错误信息
        if ($result['returnstatus'] == 'Sucess') {
            $result['returnstatus'] == 'Success';
            return $result;
        } else {
            return array('returnstatus'=>'Fail','message'=>$result['message']);
        }
    }

    /**
     * 非法关键词查询
     * @param array($action = checkkeyword,$content)
     * @return  
     *  message      提示信息
     */
    public function checkkeyword($content)
    {
        // 参数
        $params = array (
                    'action' => 'checkkeyword',
                    'account' => $this->_account,
                    'password' => $this->_password,
                    'userid' => $this->_userid,
                    'content' => $content,
            );
        // 判断短信内容是否为空
        if (empty($params['content'])) {
            return array('returnstatus'=>'Fail','message'=>'无效信息内容');
        }
        $result = $this->_aresRESTClient->doPost($this->_point,$params,$this->_formats);
        // 判断错误信息
        if (empty($result)) {
            return $result;
        } else {
            return array('returnstatus'=>'Fail','message'=>$result['message']);
        }
    }

    /**
     * 状态报告接口query
     * @param array($action = query)
     * @return  
     *  mobile        对应的手机号码
     *  taskid        同一批任务ID
     *  status        状态报告----10：发送成功，20：发送失败
     *  receivetime   接收时间 (例：2011-12-02 22:12:11)
     *  errorcode     上级网关返回值，不同网关返回值不同
     *
     *
     *错误返回值——状态报告请求错误返回格式及对应值
     *error 1-------------错误码
     *remark 用户名或密码不能为空-------------错误描述
     *
     *1：用户名或密码不能为空
     *2：用户名或密码错误
     *3：该用户不允许查看状态报告
     *4：参数不正确
     */
    public function query()
    {
        // 参数
        $params = array (
                    'action' => 'query',
                    'account' => $this->_account,
                    'password' => $this->_password,
                    'userid' => $this->_userid,
            );

        $result = $this->_aresRESTClient->doPost(self::SMS_SERVICE_STATUS_ENDPOINT,$params,$this->_formats);
        // 判断错误信息
        if (empty($result['error'])) {
            return $result;
        } else {
            return array('returnstatus'=>'Fail','message'=>$result['remark']);
        }
    }

    /**
     * 上行接口callBack
     * @param array($action = query)
     * @return  
     *  mobile        对应的手机号码
     *  taskid        同一批任务ID
     *  content       上行内容
     *  receivetime   接收时间 (例：2011-12-02 22:12:11)
     *  extno         显示号码=原号码+自定义扩展号(管理端设置)+扩展子号(发送接口参数extno)
     *
     *
     *错误返回值——状态报告请求错误返回格式及对应值
     *error 1-------------错误码
     *remark 用户名或密码不能为空-------------错误描述
     *
     *1：用户名或密码不能为空
     *2：用户名或密码错误
     *3：该用户不允许查看状态报告
     *4：参数不正确
     */
    public function callBack()
    {
        // 参数
        $params = array (
                    'action' => 'query',
                    'account' => $this->_account,
                    'password' => $this->_password,
                    'userid' => $this->_userid,
            );

        $result = $this->_aresRESTClient->doPost(self::SMS_SERVICE_CALLBACK_ENDPOINT,$params,$this->_formats);
        // 判断错误信息
        if (empty($result['error'])) {
            return $result;
        } else {
            return array('returnstatus'=>'Fail','message'=>$result['remark']);
        }
        
    }
}
?>