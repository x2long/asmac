<?php
/**
 * Created by PhpStorm.
 * User: xlxu
 * Date: 14-9-21
 * Time: 上午12:30
 */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
require_once(dirname(__FILE__).'/../thirdparty/phpExcel/PHPExcel.php');

class PhpExlWrite{
    public function __construct(){}
    public function init(){}
    public function getExcelObj(){
        $objPHPExcel = new PHPExcel();
        return $objPHPExcel;
    }
    public function getWriter($objPHPExcel, $type = 'Excel2007'){
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,$type);
        return $objWriter;
    }
}