<?php
/**
 * 图片切分处理逻辑类
 */
class ImageController extends BaseController {

	/**
	 * [actionResize description]
	 * @return [type] [description]
	 */
	public function actionResize() {
		// preprocess parameters
		$width = intval($_GET['width']);
		$height = intval($_GET['height']);
		$path = trim($_GET['path']);
		$name = trim($_GET['name']);
		
		// 原始图片路径
		$original_image_path = dirname(Yii::app()->basePath).'/upload/'. $path . '/o/' . $name;
		//$watermark_path = dirname(Yii::app()->basePath).'/upload/watermark/xqsj_logo.png';
		$watermark_path = dirname(Yii::app()->basePath).'/upload/watermark/xqsj_watermark.png';

		// 原图不存在
		if (!file_exists($original_image_path)) {
			//没有图片  
			header( 'HTTP/1.1 404 Not Found' );
			exit;
		}

		// 生成缩略图
		$imageSavePath = Yii::app()->easyImage->generateThumb($original_image_path,
			array(
				//'resize' => array('width' => $width, 'height' => $height),
				'resize' => array('width' => $width, 'height' => $height, 'padding' => true),
				//'rotate' => array('degrees' => 90),
				//'sharpen' => 95,
				'background' => '#ffffff',
				'type' => 'jpg',
				//'quality' => 75,
				'watermark' => array('watermark' => $watermark_path, 'offset_x' => true, 'offset_y' => true, 'opacity' => 50, 'duplicate' => true),
			),
			array(
				'resolution' => $width .'x'. $height,
				'path' => $path,
				'name' => $name,
			)
		);

		// 返回数据
		if (!empty($imageSavePath)) {
			header( 'Content-Type: image/jpeg' );
			header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
			echo file_get_contents( $imageSavePath );
		} else {
			//没有图片  
			header( 'HTTP/1.1 404 Not Found' );
			exit;  
		}
	}


}