<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ramder
 * Date: 14-7-2
 * Time: 下午2:34
 * To change this template use File | Settings | File Templates.
 */
class SerInterBlackHelper extends SerInterBlackAr{
    public $model;
    public function SerInterBlackHelper(){
        $this->model=SerInterBlackAr::model();
    }

    /**
     * @access public
     * @param int $num         遍历条数
     * @param int $offset      分页偏移量
     * @param boolean $flag    为真时：返回搜索信息，为假时，返回搜索数量
     * @return bool
     */
    public function get_confirmed_records_by_conditions($num, $offset,$flag){
        try{
            $sidx = 'intercept_times';
            $sord = 'desc';
            $attribute = array(
                'order' => $sidx." ".$sord, //order by book_id desc
            );
            $attribute['condition']   = $this->createCondition();
            //$array = ItfRecordlogHelper::getPhoneNumberArray();
            //if($array === false) return false;
            $criteria = $this->createCriteria($attribute);
            //$criteria->addInCondition('phone_number',$array);
            if( isset($_GET["operTimeBegin"]) && $_GET["operTimeBegin"] && isset($_GET["operTimeEnd"]) && $_GET["operTimeEnd"] ){
                $operTimeBegin =trim($_GET['operTimeBegin']);
                $operTimeEnd =trim($_GET['operTimeEnd']);
                $operTimeBegin = str_ireplace("-","",$operTimeBegin);
                $operTimeEnd = str_ireplace("-","",$operTimeEnd);
                $operTimeEnd .= '24';
                $criteria->addBetweenCondition('commit_time',$operTimeBegin,$operTimeEnd);
            }
            if($flag){
                $criteria->limit = $num;
                $criteria->offset = $offset;
                //index 的使用,暂时不需要
                //$criteria->index ="index";
                $records = $this->model->findAll($criteria,"");
            }else{
                $records = $this->model->count($criteria,"");
            }
            return $records;
        }catch(Exception $e) {
            return false;
        }
    }

    public function createCondition(){
        $condition = '1=1';

        //==================================================
        if( isset($_GET["numberType"]) && $_GET["numberType"]){
            $numberType =trim($_GET['numberType']);
        }else{
            $numberType ="all";
        }
        //$numberType  suspected=>骚扰 ;fraud=>诈骗
        //illegal_reason smallint 1：诈骗电话 2：骚扰电话
        if($numberType != "all"&& $numberType!="-1"){
            $condition .= ' and ';
            if($numberType == 'suspected') $condition .= 'illegal_reason = 2';
            if($numberType == 'fraud') $condition .= 'illegal_reason = 1';
        }

        //========================================================
        if( isset($_GET["strategyType"]) && $_GET["strategyType"]){
            $strategyType =trim($_GET['strategyType']);
        }else{
            $strategyType ="all";
        }
        //$strategyType 1：公众举报 2：110尾号 3：公检法号码 4：特服尾号
        //illegal_type smallint 1：公众举报 2：110尾号 3：公检法号码 4：特服尾号
        if($strategyType!='all' && $strategyType != "-1"){
            $condition .= ' and illegal_type ='.$strategyType;
        }

        //====================================================
        //phone_number varchar
        if( isset($_GET["callingNumber"]) && $_GET["callingNumber"]){
            $callingNumber =trim($_GET['callingNumber']);
            $condition .= ' and phone_number = "'.$callingNumber.' "';
        }

        //================================not yet===============
        if( isset($_GET["calledNumber"]) && $_GET["calledNumber"]){
            $calledNumber =trim($_GET['calledNumber']);
        }

        //=================================================
        if( isset($_GET["notesDesc"]) && $_GET["notesDesc"]){
            $notesDesc =trim($_GET['notesDesc']);
            $condition .= ' and (';
            $condition .= 'reason_desc like "%'.$notesDesc.'%"';
            $condition .= ' or seg_flag like "%'.$notesDesc.'%"';
            $condition .=')';
        }

        return $condition;
    }

    public static function get_illegal_type($illegal_type){
        $types = array("","公众举报","110尾号","公检法号码","特服尾号");
        return $types[$illegal_type];
    }

    public static function get_illegal_reason($illegal_reason){
        $reasons = array("","诈骗","骚扰");
        return $reasons[$illegal_reason];
    }
}