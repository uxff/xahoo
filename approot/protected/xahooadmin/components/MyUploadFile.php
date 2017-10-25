<?php
/**
 * Created by xdr.
 * Author: coderxx@qq.com
 * Date: 16-3-8
 * Time: 11:04
 */
class MyUploadFile {
    private $news_name = '';
    public $inputname = 'upfile';
    public $savepath = '';
    public $urlpath = '';
	
	protected $_picSize = 2097152;  //小于2M
	protected $_messages = array();
	protected $_picType = array(
			'gif',
			'jpeg',
			'jpg',
			'bmp',
			'pjpeg',
			'png',
	);
	
    /*
        公共调用
        @param $params['savepath']  保存路径
        @param $params['inputname']  表单中的 input type=file 标签的name
        
        @return array(
            'state'     : 'success',//success表示成功
            'urlpath'   : '/xxx/xxx.jpg',   //保存成功后的对外访问路径
            'savepath'  : '/var/www/html/xxx/xxx.../xxx.jpg', // 保存成功后的服务器内部路径
            'file_ext'  : 'jpg',//后缀名
        )
    */
    static public function UploadFiles($params) {
		
        $dirPath = $params['savepath'];
        $inputname = $params['inputname'];
        $Up = new MyUploadFile();
        $Up->inputname = $inputname ? $inputname : $Up->inputname;
        return $Up->UploadFile($dirPath);
    }

    /**
     * 文件上传
     *
     * @return bool
     */
    public function UploadFile($dirPath) {
        $up_dir = $this->upload_dir($dirPath);
        $upfile = CUploadedFile::getInstanceByName($this->inputname);
		
		//校验上传文件的错误类型
		$filename	= $upfile->getName();
		$isOk 		= self::checkPicError($filename, $upfile->getError());//检测上传图片的错误类型
		
		if ($isOk) {
			$sizeOk = self::checkPicSize($filename, $upfile->getSize()); //检测上传的图片大小
			$typeOk = self::checkPicType($filename, $upfile->getExtensionName());//检测上传图片的类型
			
			if ($sizeOk && $typeOk) {
				$this->news_name 	= $this->getFileName($upfile);
				$this->savepath 	= $up_dir['ori'].$this->news_name;
				$ret 				= $upfile->saveAs($up_dir['ori'].$this->news_name);
				
				if ($ret) {
					$this->urlpath = str_replace('\\', '/', $up_dir['url']) . $this->news_name;
				}
				$arr = array(
					'state' 	=> ($ret ? 'SUCCESS' : 'FAILED'),
					'urlpath' 	=> $this->urlpath,
					'savepath' 	=> $this->savepath,
					'file_ext' 	=> $upfile->extensionName,
					'size' 	    => $upfile->getSize(),
				);
				return $arr;
			} else {
				return array("state" => "FAILED","msg" => $this->_messages[0]);
			}
			
		} else {
			return array("state" => "FAILED","msg" => $this->_messages[0]);
		}
        
    }

    /**
     * 给文件重新命名
     *
     * @param $cUpfile
     * @return string
     */
    private function getFileName($cUpfile) {
        $news_name1 = date("YmdHis") . rand(100, 999);
        $news_name = $news_name1 . "." . $cUpfile->extensionName;
        return $news_name;
    }

    /**
     * 生成上传目录
     */
    private function upload_dir($dirPath) {
        $root_folder = yii::app()->params['uploadPic']['basePath'];
        //创建upload根目录
        if (!file_exists($root_folder)) {
            mkdir($root_folder);
        }
        $uppath = $root_folder . DIRECTORY_SEPARATOR . date("Ym") . DIRECTORY_SEPARATOR;
        //创建月份目录
        if (!file_exists($uppath)) {
            mkdir($uppath, 0777);
        }

        $rtpath = $paths = array();
        //创建各尺寸目录
        $rtpath['ori'] = $paths[] = $root_folder . DIRECTORY_SEPARATOR . date("Ym") . DIRECTORY_SEPARATOR . $dirPath . DIRECTORY_SEPARATOR;
        foreach ($paths as $value) {
            if (!file_exists($value)) {
                mkdir($value, 0777);
            }
        }
        //
        $rtpath['url'] = Yii::app()->params['uploadPic']['webPath'] . date("Ym") . DIRECTORY_SEPARATOR . $dirPath . DIRECTORY_SEPARATOR;
        return $rtpath;
    }
    public function setInputname($inputname) {
        $this->inputname = $inputname;
    }
	
	/**
	 *  检测上传的图片大小
	 *  @param mix $string
	 *  @param int $size
	 */
	public function checkPicSize($filename, $size){
		
		if ($size == 0){
			return false;
		}else if ($size > $this->_picSize){
			$this->_messages[] = "文件超出上传限制2M大小";
			return false;
		}else {
			return true;
		}
	}
	
	
	/**
	 *  检测上传图片的类型
	 *  @param mix $filename
	 *  @param mix $type
	 */
	public  function checkPicType($filename, $type){
		if (!in_array(strtolower($type), $this->_picType)){
			$this->_messages[] = "该文件类型是不被允许的上传类型";
			return false;
		}else {
			return true;
		}
	}
	
	/**
	 * 检测上传图片的类型错误
	 * @param mix $filename
	 * @param int $error
	 *
	 */
	public function checkPicError($filename, $error){
		switch ($error){
			case 0 : return true;
			case 1 :
			case 2 : $this->_messages[] = "文件过大！"; return true;
			case 3 : $this->_messages[] = "错误上传文件！";return false;
			case 4 : $this->_messages[] = "没有选择文件!"; return false;
			default : $this->_messages[] = "系统错误!"; return false;
		}
	}
}