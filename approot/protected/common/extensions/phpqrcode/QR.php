<?php

include "qrlib.php";

/**
 * QR::setConfig();
 * QR::generatePng()
 */
class QR {

        private $config;

        public function __construct() {
                //设置物理目录
                $PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;
                $PNG_TEMP_DIR = Yii::app()->basePath . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "upload" . DIRECTORY_SEPARATOR . 'qrcode' . DIRECTORY_SEPARATOR;
                //设置网站目录 upload/
                $PNG_WEB_DIR = 'upload/qrcode/';
                if (!file_exists($PNG_TEMP_DIR))
                        mkdir($PNG_TEMP_DIR);
                $data = 'http://devhifang.fangfull.com';
                $errorCorrectionLevel = 'H';
                $matrixPointSize = 4;
                $this->config = array(
                    'pngWebDir' => $PNG_WEB_DIR,
                    'logo' => dirname(__FILE__) . DIRECTORY_SEPARATOR . 'icon80.png',
                    'data' => $data,
                    'errorCorrectionLevel' => $errorCorrectionLevel,
                    'matrixPointSize' => $matrixPointSize,
                    'filename' => $PNG_TEMP_DIR . 't' . md5(date("Y-m-d H:i:s") . "|" . $data . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png',
                );
        }

        public function __set($name, $value) {

                if ($name == 'config') {
                        if (is_array($value)) {
                                foreach ($value as $k => $v) {
                                        $this->config[$k] = $v; //为啥this->$name不行
                                }
                        }
                }
        }

        public function generatePng() {
                QRcode::png($this->config['data'], $this->config['filename'], $this->config['errorCorrectionLevel'], $this->config['matrixPointSize'], 2);

                if ($this->config['logo'] !== FALSE) {
                        $QR = imagecreatefromstring(file_get_contents($this->config['filename']));
                        $logo = imagecreatefromstring(file_get_contents($this->config['logo']));
                        $QR_width = imagesx($QR); //二维码图片宽度   
                        $QR_height = imagesy($QR); //二维码图片高度   
                        $logo_width = imagesx($logo); //logo图片宽度   
                        $logo_height = imagesy($logo); //logo图片高度   
                        $logo_qr_width = $QR_width / 4;
                        $scale = $logo_width / $logo_qr_width;
                        $logo_qr_height = $logo_height / $scale;
                        $from_width = ($QR_width - $logo_qr_width) / 2;
                        //重新组合图片并调整大小   
                        imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
                }
//输出图片   
                imagepng($QR, $this->config['filename']);
                return $this->config['pngWebDir'] . basename($this->config['filename']);
        }

}

/**
exit();
$filename = $PNG_TEMP_DIR . 'test.png';

//processing form input
//remember to sanitize user input in real-life solution !!!
$errorCorrectionLevel = 'L';
if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L', 'M', 'Q', 'H')))
        $errorCorrectionLevel = $_REQUEST['level'];

$matrixPointSize = 4;
if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int) $_REQUEST['size'], 1), 10);


if (isset($_REQUEST['data'])) {

        //it's very important!
        if (trim($_REQUEST['data']) == '')
                die('data cannot be empty! <a href="?">back</a>');

        // user data
        $filename = $PNG_TEMP_DIR . 'test' . md5($_REQUEST['data'] . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';
        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);
} else {

        //default data
        echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>';
        QRcode::png('http://www.baidu.com', $filename, $errorCorrectionLevel, $matrixPointSize, 2);
}
$logo = 'icon80.png';
if ($logo !== FALSE) {
        $QR = imagecreatefromstring(file_get_contents($filename));
        $logo = imagecreatefromstring(file_get_contents($logo));
        $QR_width = imagesx($QR); //二维码图片宽度   
        $QR_height = imagesy($QR); //二维码图片高度   
        $logo_width = imagesx($logo); //logo图片宽度   
        $logo_height = imagesy($logo); //logo图片高度   
        $logo_qr_width = $QR_width / 3;
        $scale = $logo_width / $logo_qr_width;
        $logo_qr_height = $logo_height / $scale;
        $from_width = ($QR_width - $logo_qr_width) / 2;
        //重新组合图片并调整大小   
        imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
}
//输出图片   
imagepng($QR, $filename);
//display generated file
echo '<img src="' . $PNG_WEB_DIR . basename($filename) . '" /><hr/>';

//config form
echo '<form action="index.php" method="post">
	Data:&nbsp;<input name="data" value="' . (isset($_REQUEST['data']) ? htmlspecialchars($_REQUEST['data']) : 'PHP QR Code :)') . '" />&nbsp;
	ECC:&nbsp;<select name="level">
		<option value="L"' . (($errorCorrectionLevel == 'L') ? ' selected' : '') . '>L - smallest</option>
		<option value="M"' . (($errorCorrectionLevel == 'M') ? ' selected' : '') . '>M</option>
		<option value="Q"' . (($errorCorrectionLevel == 'Q') ? ' selected' : '') . '>Q</option>
		<option value="H"' . (($errorCorrectionLevel == 'H') ? ' selected' : '') . '>H - best</option>
	</select>&nbsp;
	Size:&nbsp;<select name="size">';

for ($i = 1; $i <= 10; $i++)
        echo '<option value="' . $i . '"' . (($matrixPointSize == $i) ? ' selected' : '') . '>' . $i . '</option>';

echo '</select>&nbsp;
	<input type="submit" value="GENERATE"></form><hr/>';

// benchmark
//QRtools::timeBenchmark();    
**/