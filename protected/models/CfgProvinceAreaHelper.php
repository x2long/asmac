<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ramder
 * Date: 14-7-5
 * Time: 上午10:17
 * To change this template use File | Settings | File Templates.
 */
class CfgProvinceAreaHelper extends CfgProvinceAreaAr{
    public $model;

    public function CfgProvinceAreaHelper(){
        $this->model = CfgProvinceAreaAr::model();
    }

    public static function getProvinceNameArray(){
        try{
            $db = yii::app()->db;
            $mysql="SELECT DISTINCT province_name from cfg_province_area";
            $command = $db->createCommand($mysql);
            $ret = $command->queryAll();
            $environment = Yii::app()->params['environment'];
            if($environment != "develop"){
                $encode = mb_detect_encoding($ret, array('GB2312','GBK','UTF-8'));
                $ret = AsmacConstants::iconv_array_2_utf8($encode,$ret,'province_name');
            }
            return $ret;
        }catch(Exception $e) {
            return "未知";
        }
    }

    public static function get_province_name_by_area_code($area_code){
        $query_record = parent::model()->find('area_code = "'.$area_code.'"');
        if( empty( $query_record) )
            return "未知";
        return $query_record->province_name;
    }

    public static function get_area_code_array_by_province_name($province_name){
        try{
            $db = yii::app()->db;
            $mysql="SELECT DISTINCT area_code from cfg_province_area where province_name = '$province_name'";
            $command = $db->createCommand($mysql);
            $ret = $command->queryAll();
            return $ret;
        }catch(Exception $e) {
            return array();
        }
    }
}