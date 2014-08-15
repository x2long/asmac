<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ramder
 * Date: 14-7-5
 * Time: 上午10:17
 * To change this template use File | Settings | File Templates.
 */
class SerInterCalledInfoHelper extends SerInterCalledInfoAr{
    public $model;

    public function SerInterCalledInfoHelper(){
        $this->model = SerInterCalledInfoAr::model();
    }

    public static function getPhoneNumberArray($calledNumber){
        try{
            $db = yii::app()->db;
            $mysql="SELECT phone_number
				FROM ser_inter_called_info
				WHERE called_number = ".$calledNumber;
            $command = $db->createCommand($mysql);
            $ret = $command->queryAll();
            return $ret;
        }catch(Exception $e) {
            return false;
        }
    }
}