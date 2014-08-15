<?php
/**
 * Created by JetBrains PhpStorm.
 * User: xuxiaolong
 * Date: 13-7-28
 * Time: 上午10:06
 * To change this template use File | Settings | File Templates.
 */
error_reporting(E_ALL ^ E_NOTICE);
require_once(dirname(__FILE__).'/../thirdparty/phpExcel/excel_reader2.php');

class CPhpExcelFactory{
    public function __construct(){}
    public function init(){}
    public function getReader(){
        $reader =new Spreadsheet_Excel_Reader();
        $reader->setOutputEncoding('UTF-8');
        return $reader;
    }
}