<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ramder
 * Date: 14-7-2
 * Time: 下午2:34
 * To change this template use File | Settings | File Templates.
 */
class SerInterDbtblackHelper extends SerInterDbtBlackAr{
    public $model;
    public function SerInterDbtBlackHelper(){
        $this->model=SerInterDbtBlackAr::model();
    }

    /**
     * @return array|bool
     * 获取最新的：先查录音记录表，得到大于门限的号码，再去疑似表插曲号码
     * 门限的获得亦是查表
     */
    public function get_newest_suspected_records(){
        try{
            $sidx = 'last_recordtime';
            $sord = 'desc';
            $attribute = array(
                'order' => $sidx." ".$sord, //order by book_id desc
            );
            $attribute['limit']   = 15;
            $attribute['condition']   = "num_state = 0";
            $array = ItfRecordlogHelper::getPhoneNumberArray();
            if($array === false) return false;
            foreach($array as $k=>$v){
                $array[$k] = $v["callingnumber"];
            }
            $criteria = $this->createCriteria($attribute);
            if( isset($_GET["chuFaSheFen"]) && trim($_GET["chuFaSheFen"]) != "-1" && trim($_GET["chuFaSheFen"]) != "all"){
                $province_name = trim($_GET['chuFaSheFen']);
                $area_code_array = CfgProvinceAreaHelper::get_area_code_array_by_province_name($province_name);
                foreach( $area_code_array as $k => $v){
                    $area_code_array[$k] = trim($v['area_code']);
                }
                $criteria->addInCondition('triger_area',$area_code_array);
            }
            $criteria->addInCondition('phone_number',$array);
            $records = $this->model->findAll($criteria,"");
            return $records;
        }catch(Exception $e) {
            return false;
        }
    }

    /**
     * @access public
     * @param int $num         遍历条数
     * @param int $offset      分页偏移量
     * @param boolean $flag    为真时：返回搜索信息，为假时，返回搜索数量
     * @return bool
     */
    public function get_suspected_records_by_conditions($num, $offset,$flag){
        try{
            $sidx = 'last_recordtime';
            $sord = 'desc';
            $attribute = array(
                'order' => $sidx." ".$sord, //order by book_id desc
            );
            $attribute['condition']   = $this->createCondition();
            $array = ItfRecordlogHelper::getPhoneNumberArray();
            if($array === false) return false;
            foreach($array as $k=>$v){
                $array[$k] = trim($v["callingnumber"]);
            }
            if( isset($_GET["calledNumber"]) && $_GET["calledNumber"]){
                $calledNumber =trim($_GET['calledNumber']);
                $array_1 = SerInterCalledInfoHelper::getPhoneNumberArray($calledNumber);
                if($array_1 !== false) {
                    foreach($array_1 as $k=>$v){
                        $array_1[$k] = trim($v["phone_number"]);
                    }
                    $array = array_intersect($array, $array_1);
                }else{
                    $array = array();
                }
            }
            $criteria = $this->createCriteria($attribute);
            foreach($array as $k=>$v){
                $info .= "[$k=>$v]";
            }
            $criteria->addInCondition('phone_number',$array);
            if( isset($_GET["operTimeBegin"]) && $_GET["operTimeBegin"] && isset($_GET["operTimeEnd"]) && $_GET["operTimeEnd"] ){
                $operTimeBegin =trim($_GET['operTimeBegin']);
                $operTimeEnd =trim($_GET['operTimeEnd']);
                $operTimeBegin = str_ireplace("-","",$operTimeBegin);
                $operTimeEnd = str_ireplace("-","",$operTimeEnd);
                $operTimeEnd .= '24';
                $criteria->addBetweenCondition('end_time',$operTimeBegin,$operTimeEnd);
            }
            if( isset($_GET["confirmTimeBegin"]) && $_GET["confirmTimeBegin"] && isset($_GET["confirmTimeEnd"]) && $_GET["confirmTimeEnd"] ){
                $confirmTimeBegin =trim($_GET['confirmTimeBegin']);
                $confirmTimeEnd =trim($_GET['confirmTimeEnd']);
                $confirmTimeBegin = str_ireplace("-","",$confirmTimeBegin);
                $confirmTimeEnd = str_ireplace("-","",$confirmTimeEnd);
                $confirmTimeEnd .= '24';
                $criteria->addBetweenCondition('ensure_time',$confirmTimeBegin,$confirmTimeEnd);
            }
            if( isset($_GET["chuFaSheFen"]) && trim($_GET["chuFaSheFen"]) != "-1" && trim($_GET["chuFaSheFen"]) != "all"){
                $province_name = trim($_GET['chuFaSheFen']);
                $area_code_array = CfgProvinceAreaHelper::get_area_code_array_by_province_name($province_name);
                foreach( $area_code_array as $k => $v){
                    $area_code_array[$k] = trim($v['area_code']);
                }
                $criteria->addInCondition('triger_area',$area_code_array);
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
        //$numberType
        /*<option value='fraud'>诈骗号码</option>
          <option value='normal'>正常号码</option>
          <option value='nandf'>正常+诈骗号码</option>
          <option value='yes'>已确认</option>
          <option value='not'>未确认</option>*/
        //num_state  smallint 0：待确认电话号码 1：确认为骚扰电话号码 2: 确认为正常电话号码，3：确认为“正常+诈骗电话号码”
        //illegal_reason smallint 0:未确定 1：诈骗电话 2：骚扰电话，3：正常+诈骗电话号码
        if($numberType != "all" && $numberType !="-1"){
            $condition .= ' and ';
            if($numberType == 'fraud') $condition .= 'num_state = 1 and illegal_reason = 1';
            if($numberType == 'normal') $condition .= 'num_state = 2';
            if($numberType == 'nandf') $condition .= 'num_state = 3 and illegal_reason = 3';
            if($numberType == 'yes') $condition .= 'num_state != 0';
            if($numberType == 'not') $condition .= 'num_state = 0';
        }

        //========================================================
        if( isset($_GET["strategyType"]) && $_GET["strategyType"]){
            $strategyType =trim($_GET['strategyType']);
        }else{
            $strategyType ="all";
        }
        //$strategyType 0:高频违规 1：公众举报 2：110尾号 3：公检法号码 4：特服尾号
        /* <option value='3'>公检法</option>
         * <option value='4'>特服</option>
         * <option value='2'>110尾号</option>
         * <option value='1'>公众举报</option>
         * */
        //illegal_type smallint 0:高频违规 1：公众举报 2：110尾号 3：公检法号码 4：特服尾号
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
            $condition .= 'spe_phone_desc like "%'.$notesDesc.'%"';
            $condition .= ' or susdesc like "%'.$notesDesc.'%"';
            $condition .= ' or sus_type_desc like "%'.$notesDesc.'%"';
            $condition .=')';
        }

        return $condition;
    }
}