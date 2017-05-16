<?php
class WkHtmlToPdf {
    /*
    * @param string $html html file of input
    * @param string $pdf  pdf file of output
    */
    static public function save($html, $pdf) {
        if (in_array(PHP_OS, array('WINNT', 'WIN32', 'Windows'))) {
            $ret = copy($html, $pdf);
            return 'copyed directly! '.$ret;
        }
        if (!function_exists('wkhtmltox_convert')) {
            $msg = 'function wkhtmltox_convert not exist.';
            //Yii::error(__METHOD__ .' : function wkhtmltox_convert not exist.');
            return $msg;
        }
        
        $ret = wkhtmltox_convert('pdf', 
            array('out' => $pdf, 'imageQuality' => '95'), // global settings
            array(
                array('page' => $html),
                //array('page' => 'http://www.google.com/')
            )
        );
        return 'wkhtmltox_convert:'.$ret;
    }
}