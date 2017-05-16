<?php
/**
* APP端上传图片处理类
*
* PHP默认只识别application/x-www.form-urlencoded标准的数据类型。
* 因此，对型如text/xml 或者 soap 或者 application/octet-stream 之类的内容无法解析，如果用$_POST数组来接收就会失败！
* 故保留原型，交给$GLOBALS['HTTP_RAW_POST_DATA'] 来接收。
* 另外还有一项 php://input 也可以实现此这个功能
* php://input 允许读取 POST 的原始数据。和 $HTTP_RAW_POST_DATA 比起来，它给内存带来的压力较小，并且不需要任何特殊的 php.ini 设置。php://input和 $HTTP_RAW_POST_DATA 不能用于 enctype="multipart/form-data"。
*
* TODO
*/
class ApiImageUpload {


	//图片保存名称
	public $save_name;
	//图片保存目录
	public $save_dir;
	//文档目录+图片保存目录
	public $save_path;
	//图片保存类型
	public $save_type;

	/**
	 * 构造函数
	 * @param String $save_name 保存图片名称
	 * @param String $save_dir 保存路径名称
	 */
	public function __construct($save_name='', $save_dir='', $save_type='') {
		//图片保存类型
		$this->save_type = $save_type ? $save_type : Yii::app()->params['uploadPic']['appUserPhotoType'];
		//设置保存图片名称，若未设置，则随机产生一个唯一文件名
		$this->save_name = $save_name ? $save_name : $this->getFileName($this->save_type);
		//设置保存图片路径，若未设置，则使用年月日格式进行目录存储
		$this->save_dir = Yii::app()->params['uploadPic']['basePath'];
		$this->save_dir .=  $save_dir ? $save_dir : date('Ymd');


		//创建文件夹
		@$this->create_dir ( $this->save_dir );
		//设置目录+图片完整路径
		$this->save_path = $this->getSavePath();

		//
		$this->allowed_file_types = array('.gif', '.png', '.jpg', '.jpeg', '.bmp');
		$this->allowed_max_size = 8 * 1024 * 1024; // 1M
	}

	/**
	 * 表单方式提交图片数据
	 * 
	 * @param  string $filename [description]
	 * @return [type]           [description]
	 */
	public function formUpload($filename='photo'){
		// 获取FILES数组
		$arrFile = $_FILES[$filename];

		// 格式验证
		$file_type = strtolower(strrchr($arrFile['name'], '.'));
		if (!in_array($file_type, $this->allowed_file_types)) {
			return array('status'=>false, 'code'=> '11', 'info' => '图片格式不允许');
		}
		
		// 大小验证
		if ($arrFile['size'] > $this->allowed_max_size) {
			return array('status'=>false, 'code'=> '12', 'info' => '图片大小不允许');
		}

		// 保存图片
		if (!file_exists($this->save_path)) {
			mkdir($this->save_path, 0777);
		}
		move_uploaded_file($arrFile['tmp_name'], $this->save_path.'/'.$this->save_name);

		// 重新resize图片
		

		// 添加水印
		 
		return array('status'=>true, 'code'=> '0', 'url' => $this->save_dir.'/'.$this->save_name);
	}

	/**
	 * 二进制方式提交图片数据
	 * 
	 * @return [type] [description]
	 */
	public function stream2Image() {
		//本地文件测试用数据流  暂时存放
		/*$img_file = $_SERVER['DOCUMENT_ROOT'].'/1111.png'; 
		$fp = fopen($img_file, 'rb');
		$content = fread($fp, filesize($img_file)); //二进制数据 
		fclose($fp); 
		*/
		//$data = file_get_contents ( 'php://input' ) ? file_get_contents ( 'php://input' ) : gzuncompress ( $GLOBALS ['HTTP_RAW_POST_DATA'] );
		
		//二进制数据流
		$binaryImageData = file_get_contents( 'php://input' );

		file_put_contents('/tmp/api_debug.log', var_export(array('php_input_img_binary'=>$binaryImageData, '_FILES'=>$_FILES), true), FILE_APPEND);

		//数据流不为空，则进行保存操作
		if (! empty ( $binaryImageData )) {
			header('Content:image/png');
			//创建并写入数据流，然后保存文件
			if (@$fp = fopen ( $this->save_fullpath, 'w+' )) {
				fwrite ( $fp, $binaryImageData );
				fclose ( $fp );

				if ( file_exists($this->save_fullpath) ) {
					//生成相应尺寸的缩略图
					$wid = yii::app()->params['uploadPic']['appUserPhotoWidth'];//宽
					$wei = yii::app()->params['uploadPic']['appUserPhotoHeight'];//高
					//原文件名称
					$oldname = explode('.',$this->save_name);
					//缩略图名称
					$pathnew =  $this->save_dir . '/' .$oldname[0].$wid . "-" . $wei . "." . $this->save_type;
					
				    if ($this->save_type == 'gif') {
                            $im = imagecreatefromgif($this->save_fullpath);
                    } else if ($this->save_type == 'jpg') {
                            $im = imagecreatefromjpeg($this->save_fullpath);
                    } else if ($this->save_type == 'png') {
                            $im = imagecreatefrompng($this->save_fullpath);
                    } else if ($this->save_type == 'bmp') {
                            $im = imagecreatefromwbmp($this->save_fullpath);
                    }

					CThumb::resizeImage($im, $wid, $wei, $pathnew, '');
					//不管缩略图生成  成功,失败   都删除原图
					unlink($this->save_fullpath);
					
					if(file_exists($pathnew)){
					  	    $upload_dir_name = substr(yii::app()->params['uploadPic']['basePath'],strrpos(yii::app()->params['uploadPic']['basePath'],DIRECTORY_SEPARATOR)+1);
                            $url =  str_replace(yii::app()->params['uploadPic']['basePath'], '/'.$upload_dir_name, $pathnew);
                            return array('status'=>'success','url'=>$url);
					}
					
				} else {
					return array('status'=>'1001015');
				}
			} else {
                    return array('status'=>'1001015');
			}
		} else {
			//没有接收到数据流
			return array('status'=>'1001014');
		}
	}


    /**
     * 图片的resize函数，对于超宽的图片将其压缩到指定的宽度
     * 
     * @author 
     */
    public function resize($imgSrc, $size) {
        if (intval($size) == 0) {
            return array('result' => false);
        }


        $srcInfo = getimagesize($imgSrc);
        $srcImg_w = $srcInfo[0];
        $srcImg_h = $srcInfo[1];

        $current_type = strtolower(strrchr($imgSrc, '.'));
        
        // 如果上传的图片就是jpeg格式，需要备份原图
        if ($current_type == '.jpeg') {
            copy($imgSrc, $imgSrc . ".original");
        }
        switch ($srcInfo[2]) {
            case 1:
                    $srcim = imagecreatefromgif($imgSrc);
                    break;
            case 2:
                    $srcim = imagecreatefromjpeg($imgSrc);
                    break;
            case 3:
                    $srcim = imagecreatefrompng($imgSrc);
                    break;
            case 6:
                    $srcim = self::imagecreatefrombmp($imgSrc);
                    break;
            default:
                    return array("result" => false, "msg" => "不支持的图片文件类型");
        }

        // Set a maximum height and width
        if ($srcImg_w <= intval($size)) {
            // 宽度小于指定值的原来宽度输出
            $size = $srcImg_w;
            //return true;
        }
        $width = intval($size);
        $height = ($width / $srcImg_w) * $srcImg_h;

        // Resample
        $image_p = imagecreatetruecolor($width, $height);
        imagecopyresampled($image_p, $srcim, 0, 0, 0, 0, $width, $height, $srcImg_w, $srcImg_h);

        $result = array('result' => true);

        // Output
        $tmpimgSrc = str_replace($current_type, '.jpeg', $imgSrc);
        // 统一输出成jpeg格式
        imagejpeg($image_p, $tmpimgSrc, 90);
        $result['picname'] = $tmpimgSrc;
        imagedestroy($image_p);
        imagedestroy($srcim);

        return $result;
    }

	/**
	 * 创建文件夹
	 * @param String $dirName 文件夹路径名
	 */
	public function create_dir($dirName, $recursive = 1,$mode=0777) {
		! is_dir ( $dirName ) && mkdir ( $dirName,$mode,$recursive );
	}

	/**
     * 获取文件完整路径
     * @return string
     */
    private function getSavePath() {
        $saveDir = $this->save_dir;
        $rootPath = $_SERVER['DOCUMENT_ROOT'];

        if (substr($saveDir, 0, 1) != '/') {
            $saveDir = '/' . $saveDir;
        }

        return $rootPath . $saveDir;
    }


	/**
	 * 获取图片的扩展名，组成新的名称
	 * @param 
	 */
	public function getFileName($extensionName) {
        $news_name1 = date("YmdHis") . time() . rand(100, 999);
        $news_name = $news_name1 . "." . $extensionName;
        return $news_name;
    }

}