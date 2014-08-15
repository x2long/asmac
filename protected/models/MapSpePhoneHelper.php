<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ramder
 * Date: 14-7-2
 * Time: 下午2:34
 * To change this template use File | Settings | File Templates.
 */
class MapSpePhoneHelper extends MapSpePhoneAr{
    public $model;
    public function MapSpePhoneHelper(){
        $this->model=MapSpePhoneAr::model();
    }

    /**
     * @access public
     * @param int $num         遍历条数
     * @param int $offset      分页偏移量
     * @param boolean $flag    为真时：返回搜索信息，为假时，返回搜索数量
     * @return bool
     */
    public function get_records_by_conditions($num, $offset,$flag){
        try{
            $attribute = array();
            $attribute['condition']   = $this->createCondition();
            $criteria = $this->createCriteria($attribute);            
            //Yii::log($criteria->select, 'info');
            if($flag){
                $criteria->limit = $num;
                $criteria->offset = $offset;
                //index 的使用,暂时不需要
                //$criteria->index ="index";
                //Yii::beginProfile('================> sql block...',"system.db.*");
                $records = $this->model->findAll($criteria,"");
                //Yii::endProfile('<================= sql block','system.db.*');
            }else{
                $records = $this->model->count($criteria,"");
            }
            return $records;
        }catch(Exception $e) {
            return false;
        }
    }

    //numberType=-1&callingNumber=&calledNumber=&notesDesc=
    //&strategyType=-1&operTimeBegin=&operTimeEnd=
    public function createCondition(){
        $condition = '1=1';

        //==================================================
        if( isset($_GET["phoneType"]) && $_GET["phoneType"]){
            $phone_type =trim($_GET['phoneType']);
        }else{
            $phone_type ="all";
        }
        //$numberType  suspected=>骚扰 ;fraud=>诈骗;normal=>正常;not=>未确认
        //num_state  smallint 0：待确认电话号码 1：确认为骚扰电话号码 2: 确认为正常电话号码
        //illegal_reason smallint 0:未确定 1：诈骗电话 2：骚扰电话
        if($phone_type != "all" && $phone_type !="-1"){
            $condition .= ' and phone_type='.$phone_type;
        }
        return $condition;
    }
}