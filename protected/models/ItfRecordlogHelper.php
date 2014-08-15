<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ramder
 * Date: 14-7-5
 * Time: 上午10:17
 * To change this template use File | Settings | File Templates.
 */
class ItfRecordlogHelper extends ItfRecordlogAr{
    public $model;

    public function ItfRecordlogHelper(){
        $this->model = ItfRecordlogAr::model();
    }

    public static function getPhoneNumberArray(){
        try{
            $recordTimesThreshold = ItfSysconfigHelper::getRecordTimesThreshold();
            $db = yii::app()->db;
            $mysql="SELECT callingnumber
				FROM itf_recordlog
				WHERE recordtimes >= ".$recordTimesThreshold;
            $command = $db->createCommand($mysql);
            $ret = $command->queryAll();
            return $ret;
        }catch(Exception $e) {
            return false;
        }
    }
}