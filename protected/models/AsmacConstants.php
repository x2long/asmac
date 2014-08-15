<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ramder
 * Date: 14-7-2
 * Time: 下午2:57
 * To change this template use File | Settings | File Templates.
 */
class AsmacConstants{
    public static function get_phoNum_status($num_state,$ensure_time=''){
        $ensure_time = date("Y-m-d H:i:s",strtotime($ensure_time));
        return $num_state==0 ? "未审核":$ensure_time."审核";
    }

    public static function get_phoNum_audit_result($num_state,$illegal_reason){
        $result = array("【——】","诈骗号码","正常号码","正常+诈骗号码");
        return $result[$num_state];
    }

    public static function encode2utf8($encode,$string){
        return iconv($encode,'UTF-8',$string);
    }

    /**
     *将提交的数据转码
     *@param array 要转码的字符数组
     *@return array() 转码后的字符数组
     */
    public static function iconv_array($array) {
        foreach($array as $k=>&$value) {
            $temp = $value;
            try {
                $value = iconv('UTF-8','GBK//ignore',$value);
            } catch(Exception $e) {
                $value = $temp;
            }
        }
        return $array;
    }

    public static function getMillisecond() {
        list($t1, $t2) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
    }

    public static function getRecordsByPhoneNumber($phoneNumber){
        $recordFilesBaseDir = Yii::app()->params['recordFilesBaseDir'];
        $allNames = AsmacConstants::getAllFilesWithoutSub($recordFilesBaseDir);
        //remove not need
        foreach($allNames as $k=>$v){
            if(stripos($v,trim($phoneNumber)) === false) //务必使用!==，防止“0”情况
                unset($allNames[$k]);
        }
        return $allNames;
    }

    public static function getAllFilesWithoutSub($dir){
        $handler = opendir($dir);
        $files = null;
        while (($filename = readdir($handler)) !== false) {//务必使用!==，防止目录下出现类似文件名“0”等情况
            if ($filename != "." && $filename != "..") {
                $files[] = $filename ;
            }
        }
        closedir($handler);
        return $files;
    }

    /**
     * @static
     * @param $dir
     * @param $files
     * note that files need change to its name only
     */
    public static function getAllFilesWithSub($dir,&$files){
        if(is_dir($dir)){
            $dp = dir($dir);
            while ($file = $dp ->read()){
                if($file !="." && $file !=".."){
                    AsmacConstants::getAllFilesWithSub($dir."/".$file, $files);
                }
            }
            $dp ->close();
        }
        if(is_file($dir)){
            $files[] =  $dir;
        }
    }

    /**
     * @access public
     * @param int $num         遍历条数
     * @param int $offset      分页偏移量
     * @param boolean $flag    为真时：返回搜索信息，为假时，返回搜索数量
     * @return bool
     * 处理表格数据，参数可能需要调整
     */
    public static function get_grids_data_by_conditions($num, $offset,$flag){
        try{
            //3 确认的，其他都是疑似
            if(trim($_GET['tabNum'])==3){
                $model= new SerInterBlackAr();
                $sidx = 'intercept_times';
            }else{
                $model= new SerInterDbtBlackAr();
                $sidx = 'call_times';
            }
            $sord = 'desc';
            $attribute = array(
                'order' => $sidx." ".$sord, //order by book_id desc
            );
            $attribute['condition']   = AsmacConstants::createGridsDataCondition();
            $criteria = $model->createCriteria($attribute);
            if( isset($_GET["operTimeBegin"]) && $_GET["operTimeBegin"] && isset($_GET["operTimeEnd"]) && $_GET["operTimeEnd"] ){
                $operTimeBegin =trim($_GET['operTimeBegin']);
                $operTimeEnd =trim($_GET['operTimeEnd']);
                //time need to confirm
                if($operTimeBegin !='null'){
                    $operTimeBegin = str_ireplace("-","",$operTimeBegin);
                    $operTimeEnd = str_ireplace("-","",$operTimeEnd);
                    $operTimeEnd .= '24';
                    $criteria->addBetweenCondition('commit_time',$operTimeBegin,$operTimeEnd);
                }
            }
            if($flag){
                $criteria->limit = $num;
                $criteria->offset = $offset;
                //index 的使用,暂时不需要
                //$criteria->index ="index";
                $records = $model->findAll($criteria,"");
            }else{
                $records = $model->count($criteria,"");
            }
            return $records;
        }catch(Exception $e) {
            return false;
        }
    }

    public static function createGridsDataCondition(){
        $condition = '1=1';
        switch(trim($_GET['tabNum'])){
            case 1:
                if( isset($_GET["kindsType"]) && $_GET["kindsType"]&& $_GET["kindsType"]!='null'){
                    $kindsType =trim($_GET['kindsType']);
                }else{
                    $kindsType ="all";
                }
                if($kindsType!='all' && $kindsType != "-1"){
                    $condition .= ' and phone_type = '.$kindsType;
                }
                //partName=>illegal_type
                $convertArray = array("高频违规"=>0,"公众举报"=>1,"110尾号"=>2,"公检法号码"=>3,"特服尾号"=>4);
                if( isset($_GET["partName"]) && $_GET["partName"] && array_key_exists($_GET["partName"],$convertArray)){
                    $condition .= ' and illegal_type = '.$convertArray[$_GET["partName"]];
                }
                break;
            case 2:
                //include A口国际 $condition .=" and phone_type != 2";
                $condition .=" and phone_type = 1";
                if( isset($_GET["kindsType"]) && $_GET["kindsType"]&& $_GET["kindsType"]!='null'){
                    $kindsType =trim($_GET['kindsType']);
                }else{
                    $kindsType ="all";
                }
                if($kindsType!='all' && $kindsType != "-1"){
                    $condition .= ' and ';
                    if($kindsType == 'suspected') $condition .= 'num_state = 1 and illegal_reason = 2';
                    if($kindsType == 'fraud') $condition .= 'num_state = 1 and illegal_reason = 1';
                    if($kindsType == 'normal') $condition .= 'num_state = 2';
                    if($kindsType == 'not') $condition .= 'num_state = 0 and illegal_reason = 0';
                }
                //partName=>illegal_type
                //partName              0:高频违规 1：公众举报 2：110尾号 3：公检法号码 4：特服尾号
                //illegal_type smallint 0:高频违规 1：公众举报 2：110尾号 3：公检法号码 4：特服尾号
                $convertArray = array("高频违规"=>0,"公众举报"=>1,"110尾号"=>2,"公检法号码"=>3,"特服尾号"=>4);
                if( isset($_GET["partName"]) && $_GET["partName"] && array_key_exists($_GET["partName"],$convertArray)){
                    $condition .= ' and illegal_type = '.$convertArray[$_GET["partName"]];
                }
                break;
            default:
                if( isset($_GET["kindsType"]) && $_GET["kindsType"]!='null'){
                    $kindsType =trim($_GET['kindsType']);
                }else{
                    $kindsType ="all";
                }
                if($kindsType!='all' && $kindsType != "-1"){
                    $condition .= ' and illegal_type = '.$kindsType;
                }
                //partName=>phone_type
                //partName              0:null 1：网间国际 2：网间非国际 3：A口国际
                //phone_type smallint   0:null 1：网间国际 2：网间非国际 3：A口国际
                $convertArray = array("any"=>0,"网间国际"=>1,"网间非国际"=>2,"A口国际"=>3,"SCP"=>4);
                if( isset($_GET["partName"]) && $_GET["partName"] && array_key_exists($_GET["partName"],$convertArray)){
                    $condition .= ' and phone_type = '.$convertArray[$_GET["partName"]];
                }
        }
        return $condition;
    }
}