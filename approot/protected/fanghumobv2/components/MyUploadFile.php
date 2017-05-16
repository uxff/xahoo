<?php
/**
 * Created by xdr.
 * Author: xuduorui@qq.com
 * Date: 16-3-8
 * Time: 11:04
 */
class MyUploadFile {
    private $news_name = '';
    public $inputname = 'upfile';
    public $savepath = '';
    public $urlpath = '';
	
	private $extArr = array(
					1 => 'GIF',
					2 => 'JPG',
					3 => 'PNG',
					4 => 'SWF',
					5 => 'PSD',
					6 => 'BMP',
					7 => 'TIFF',
					8 => 'TIFF',
					9 => 'JPC',
					10 => 'JP2',
					11 => 'JPX',
					12 => 'JB2',
					13 => 'SWC',
					14 => 'IFF',
					15 => 'WBMP',
					16 => 'XBM'
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
        $namePrefix = $params['namePrefix'];
        $nameSuffix = $params['nameSuffix'];
        $Up = new MyUploadFile();
        $Up->inputname = $inputname ? $inputname : $Up->inputname;
        return $Up->UploadFile($dirPath, $namePrefix, $nameSuffix);
    }

    /**
     * 文件上传
     *
     * @return bool
     */
    public function UploadFile($dirPath, $namePrefix='', $nameSuffix='') {
        $up_dir = $this->upload_dir($dirPath);
        $upfile = CUploadedFile::getInstanceByName($this->inputname);
        $this->news_name = $this->getFileName($upfile);
        $this->news_name = $namePrefix ? $namePrefix.$this->news_name : $this->news_name;
        $this->news_name = $nameSuffix ? $this->news_name.$nameSuffix : $this->news_name;
        $this->savepath = $up_dir['ori'].$this->news_name;
        $ret = $upfile->saveAs($up_dir['ori'].$this->news_name);
        //echo 'ret=';print_r($ret);exit;
        //$urlPath = str_replace('\\', '/', $up_dir['url']) . $news_name;
        if ($ret) {
            $this->urlpath = str_replace('\\', '/', $up_dir['url']) . $this->news_name;
        }
        $arr = array(
            'state' => ($ret ? 'SUCCESS' : 'FAILED'),
            'urlpath' => $this->urlpath,
            'savepath' => $this->savepath,
            'file_ext' => $upfile->extensionName,
        );
        return $arr;
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
	*二进制图片上传
	*/
	static public function UploadBinaryFiles($params) {
        $dirPath = $params['savepath'];
		$namePrefix = $params['namePrefix'];
        $Up = new MyUploadFile();
		
        return $Up->UploadBinaryFile($dirPath,$namePrefix);
    }
	
    /**
     * 二进制文件上传
     *
     * @return bool
     */
    public function UploadBinaryFile($dirPath,$namePrefix) {
		$binaryFile 	= $GLOBALS[HTTP_RAW_POST_DATA];
		if (empty($binaryFile)) $binaryFile = file_get_contents('php://input');//得到post过来的二进制原始数据
		
		//创建临时文件
		$updir 		= $this->upload_dir($dirPath);
		$up_dir 	=  $updir['ori'];
		$news_name  = $namePrefix.date("YmdHis").rand(1,999);
		$file 		= fopen($up_dir . $news_name, "w");//打开文件准备写入
		$result		= fwrite($file, $binaryFile);//写入
		fclose($file);//关闭
		
		//创建图片文件
		$temfile = $up_dir . $news_name;
		$r 		= getimagesize($temfile);
		$ext 	= strtolower($this->extArr[$r[2]]);
		$image 	= file_get_contents($temfile);//获取临时文件
		$imageFile 	= fopen($temfile.'.'.$ext, "w");//打开文件准备写入
		$result	= fwrite($imageFile, $image);
		fclose($file);//关闭
		
		//删除临时文件
		unlink($temfile);
		
		if ($result) {
			$urlpath 	= str_replace('\\', '/', $updir['url']) . $news_name.'.'.$ext;
		}
		
		$arr = array(
			'state' 	=> ($result ? 'SUCCESS' : 'FAILED'),
			'urlpath' 	=> $urlpath,
			//'savepath' 	=> $this->savepath,
			//'file_ext' 	=> $_FILES["file"]["type"],
			//'size' 	    => $_FILES["file"]["size"],
		);
		return $arr;
        
    }

}