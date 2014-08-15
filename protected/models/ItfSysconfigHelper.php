<?php
/**
 * Created by JetBrains PhpStorm.
 * User: xuxiaolong
 * Date: 13-7-17
 * Time: 上午9:36
 * To change this template use File | Settings | File Templates.
 */
class ItfSysconfigHelper extends ItfSysconfigAr{
    public $model;
    public function ItfSysconfigHelper(){
        $this->model=ItfSysconfigAr::model();
    }

    /**
     * static get days
     * @static
     * @param $phone_type
     * @return mixed
     */
    public static function get_valid_days($phone_type){

       /* $item_days = array(10,21,7,21);
        * $ret = $item_days[$phone_type];
        *type    1：网间国际;2：网间非国际;3：A口国际;4:SCP
        *config  1=>10录音次数,102,2=>7天，网间非国际；101,103,3=>21天，网间国际
        */
        $type_2_config=array(7,3,2,3,2,2);
        $config_record = ItfSysconfigAr::model()->find('servKey = '.$type_2_config[$phone_type]);
        return $config_record->recordcount;
    }

    public static function getRecordTimesThreshold(){
        $config_record = ItfSysconfigAr::model()->find('servKey = 1');
        return $config_record->recordcount;
    }
}