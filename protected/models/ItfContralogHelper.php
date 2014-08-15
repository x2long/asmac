<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ramder
 * Date: 14-7-2
 * Time: 下午2:34
 * To change this template use File | Settings | File Templates.
 */
class ItfContralogHelper extends ItfContralogAr{
    public $model;
    public function ItfContralogHelper(){
        $this->model=ItfContralogAr::model();
    }

    /**
     * @access public
     * @param int $num         遍历条数
     * @param int $offset      分页偏移量
     * @param boolean $flag    为真时：返回搜索信息，为假时，返回搜索数量
     * @return bool
     */
    public function get_contralog_records_by_conditions($num, $offset,$flag){
        try{
            $sidx = 'callbegintime';
            $sord = 'desc';
            $attribute = array(
                'order' => $sidx." ".$sord, //order by book_id desc
            );
            $attribute['condition']   = $this->createCondition();

            $criteria = $this->createCriteria($attribute);
            if( isset($_GET["CallBeginTimeB"]) && $_GET["CallBeginTimeB"] && isset($_GET["CallBeginTimeE"]) && $_GET["CallBeginTimeE"] ){
                $operTimeBegin =trim($_GET['CallBeginTimeB']);
                $operTimeEnd =trim($_GET['CallBeginTimeE']);
                $operTimeBegin = str_ireplace("-","",$operTimeBegin);
                $operTimeEnd = str_ireplace("-","",$operTimeEnd);
                $operTimeEnd .= '24';
                $criteria->addBetweenCondition('callbegintime',$operTimeBegin,$operTimeEnd);
            }
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
        if( isset($_GET["numberType"]) && $_GET["numberType"]){
            $numberType =trim($_GET['numberType']);
        }else{
            $numberType ="all";
        }
        //$numberType  suspected=>骚扰 ;fraud=>诈骗;normal=>正常;not=>未确认
        //num_state  smallint 0：待确认电话号码 1：确认为骚扰电话号码 2: 确认为正常电话号码
        //illegal_reason smallint 0:未确定 1：诈骗电话 2：骚扰电话
        if($numberType != "all" && $numberType !="-1"){
            $condition .= ' and ';
            if($numberType == 'suspected') $condition .= 'num_state = 1 and illegal_reason = 2';
            if($numberType == 'fraud') $condition .= 'num_state = 1 and illegal_reason = 1';
            if($numberType == 'normal') $condition .= 'num_state = 2';
            if($numberType == 'yes') $condition .= 'num_state != 0';
            if($numberType == 'not') $condition .= 'num_state = 0 and illegal_reason = 0';
        }

        //========================================================
        if( isset($_GET["strategyType"]) && $_GET["strategyType"]){
            $strategyType =trim($_GET['strategyType']);
        }else{
            $strategyType ="all";
        }
        //$strategyType 0:高频违规 1：公众举报 2：110尾号 3：公检法号码 4：特服尾号
        //illegal_type smallint 0:高频违规 1：公众举报 2：110尾号 3：公检法号码 4：特服尾号
        if($strategyType!='all' && $strategyType != "-1"){
            $condition .= ' and illegal_type ='.$strategyType;
        }

        //====================================================
        //phone_number varchar
        if( isset($_GET["callingNumber"]) && $_GET["callingNumber"]){
            $callingNumber =trim($_GET['callingNumber']);
            $condition .= ' and callingnumber = "'.$callingNumber.' "';
        }

        //================================not yet===============
        if( isset($_GET["calledNumber"]) && $_GET["calledNumber"]){
            $calledNumber =trim($_GET['calledNumber']);
            $condition .= ' and callednumber = "'.$calledNumber.' "';
        }

        //=================================================
        if( isset($_GET["notesDesc"]) && $_GET["notesDesc"]){
            $notesDesc =trim($_GET['notesDesc']);
            $condition .= ' and (';
            $condition .= 'spe_phone_desc like "%'.$notesDesc.'%"';
            $condition .= ' or susdesc like "%'.$notesDesc.'%"';
            $condition .= ' or sus_type_desc like "%'.$notesDesc.'%"';
            $condition .=')';
        }

        return $condition;
    }
}