<?php
class HtmlToPdf {
    static public function save($html, $pdf) {
        $class = new WkHtmlToPdf();
        return $class->save($html, $pdf);
    }
}