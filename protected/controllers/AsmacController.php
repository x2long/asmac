<?php
/**
 * Created by JetBrains PhpStorm.
 * User: xuxiaolong
 * Date: 13-7-9
 * Time: 上午11:45
 * To change this template use File | Settings | File Templates.
 */
class AsmacController extends EbuptController{
    public $model;
    public $layout = '';
    public function filters() {
        return array('accessControl');
    }

    public function accessRules(){
        return array(
            array('deny',
                'actions'=>array('create',),
                'users'=>array('Guest','test','guest'),
            ),
        );
    }

    public function actionIndex(){
        $nextUrl=$nextUrl = Yii::app()->user->defaultUrl;
        $this->redirect($nextUrl);
        /*$model= new AsmacLoginForm();
        $model->username=Yii::app()->user->name;
        $this->renderSmarty('asmac/index.html',array('model'=>$model,'title'=>"选择系统"));*/
    }

    public function actionOthers(){
        $model = new AsmacLoginForm();
        $model->username = Yii::app()->user->name;
        $this->renderSmarty('asmac/others.html',array('model'=>$model));
    }

    public function actionCreate(){
        if(isset($_POST['strategy'])){
            $strategy = trim($_POST['strategy']);
            $environment = Yii::app()->params['environment'];
            if($environment != "develop"){
                $desc = iconv('UTF-8','GBK//ignore',trim($_POST['desc']));
            }
            $value = trim($_POST['value']);
            $stratety_records = CfgItrStrategyAr::model()->find('strategy ='.$strategy);
            $stratety_records->value = $value;
            if(!empty($desc))  $stratety_records->desc = $desc;
            $stratety_records->save();
            //change conf_act_strategy where stream_number = $stratety_records->strage_stream
            $attribute = array(
                'condition' => "fe_id in( 211,212,213,214) and data_id=1 and act_task_id= ".$strategy,
            );
            $criteria = CfgTaskStrategyAr::createCriteria($attribute);
            $taskStrategyRecords = CfgTaskStrategyAr::model()->updateAll(array('value'=>$value),$criteria);
            if($taskStrategyRecords) {
                echo "<script>alert('修改成功！');</script>";
            }else{
                echo "<script>alert('修改失败！');</script>";
            }
        }
        $model = new AsmacLoginForm();
        $covertArray = array("高频违规","公众举报","110尾号","公检法号码","特服尾号");
        $model->username=Yii::app()->user->name;
        $stratety_records = CfgItrStrategyAr::model()->findAll();
        $environment = Yii::app()->params['environment'];
        if($environment != "develop"){
            $encode = mb_detect_encoding($stratety_records, array('GB2312','GBK','UTF-8'));
        }
        foreach($stratety_records as $item){
            if($environment != "develop"){
                $desc = ''.$item->desc;
                $item->desc = AsmacConstants::encode2utf8($encode,$desc);
            }
        }
        $this->renderSmarty('asmac/create.html',array('model'=>$model,"stratety_records"=>$stratety_records,'array'=>$covertArray));
    }

    //single add
    public function actionAddSingle($value=''){
        $phone= $_GET["phone"];
        $phone_type= $_GET["phone_type"];
        $name = $_GET["name"];
        $province = $_GET["province"];
        $city = $_GET["city"];
        $result = $this->addSingle($phone,$phone_type,$name,$province,$city);
        if($result==='true'){
            $message = "该[$phone]已存在,请您知晓！";
        }else{
            $message = $result ? "添加成功！" : "网络异常，请稍后!";
        }
        return $this->renderJson($message);
    }

    private function addSingle($phone,$phone_type,$name,$province,$city){
        $temp = MapSpePhoneAr::model()->find('phone = "'.$phone.'"');
        if($temp) return "true";
        $strategy_record = new MapSpePhoneAr();
        $strategy_record->phone=$phone;
        $strategy_record->phone_type=intval($phone_type);

        $environment = Yii::app()->params['environment'];
        if($environment != "develop"){
            $strategy_record->name=iconv("UTF-8","GBK",$name);
            $strategy_record->province=iconv("UTF-8","GBK",$province);
            $strategy_record->city=iconv("UTF-8","GBK",$city);
        }else{
            $strategy_record->name=$name;
            $strategy_record->province=$province;
            $strategy_record->city=$city;
        }

        //match_type need confirm
        $strategy_record->match_type = $strategy_record->phone_type ===1 ? 0 : -1 ;//need change
        $strategy_record->status=1;
        $result = $strategy_record->save();
        return $result;
    }

    //bat add ,here parse excel doc test only
    public function actionAddBatchTest(){
        $result ="";
        if(($_FILES["importFile"]["size"] < 20000000)) {
            if ($_FILES["importFile"]["error"] > 0) {
                $result .= "Return Code: " . $_FILES["importFile"]["error"] . "<br />";
            }
            else {
                $result .= "Upload: " . $_FILES["importFile"]["name"] . "<br />";
                $result .=  "Type: " . $_FILES["importFile"]["type"] . "<br />";
                $result .=  "Size: " . ($_FILES["importFile"]["size"] / 1024) . " Kb<br />";
                $result .=  "Temp file: " . $_FILES["importFile"]["tmp_name"] . "<br />";
                if (file_exists("upload/" . $_FILES["importFile"]["name"])) {
                    $result .=  $_FILES["importFile"]["name"] . " already exists. ";
                } else  {
                    move_uploaded_file($_FILES["importFile"]["tmp_name"], "public/uploads/".date("YmdHis_"). $_FILES["importFile"]["name"]);
                    $result .=  "Stored in: " . "uploadF/" . $_FILES["importFile"]["name"];
                }
            }
        } else{
            $result .= "Invalid file";
        }
        return $this->renderJson($result);
    }

    public function actionAddBatch(){
        $result = "";
        if ($_FILES["importFile"]["error"] > 0) {
            $result .= "error";
        }else{
            if (file_exists("public/uploads/" . $_FILES["importFile"]["name"])) {
                $result =  "error";
            }else{
                $excelFile = "public/uploads/".date("YmdHis_"). $_FILES["importFile"]["name"];
                move_uploaded_file($_FILES["importFile"]["tmp_name"], $excelFile);
                $result =  $this->doParseExcel2DB($excelFile);
            }
        }
        //return $this->renderJson($result);//difference
        echo $result;
    }

    //delete
    public function actionDelete($stream_number){
    	$result = null;
        $result += MapSpePhoneAr::model()->deleteAll('stream_number = '.$stream_number);
        return $this->renderJson($result);
    }

    //list
    public function actionList(){
    	if( isset($_GET["countPerPage"]) && $_GET["countPerPage"]){
            $countPerPage =trim($_GET['countPerPage']);
        }else{
            $countPerPage =10;
        }
        if( isset($_GET["currentPage"]) && $_GET["currentPage"]){
            $currentPage =trim($_GET['currentPage']);
        }else{
            $currentPage =0;
        }
        $helper = new MapSpePhoneHelper();
        //$suspect_records =$helper->get_newest_suspected_records();
        $model = new AsmacLoginForm();
        $params =$_GET;
        $model->totalNum =$helper->get_records_by_conditions(0,0,false);
        if($model->totalNum === false) $model->totalNum = 0;
        $model->currentPage = $currentPage;
        $model->countPerPage = $countPerPage;
        $offset = ($countPerPage)*$currentPage;
        if($offset<0) $offset = 0;
        $strategy_records =$helper->get_records_by_conditions($countPerPage,$offset,true);
        if($strategy_records != false){
            $environment = Yii::app()->params['environment'];
            if($environment != "develop"){
                $encode = mb_detect_encoding($strategy_records, array('GB2312','GBK','UTF-8'));
            }
            foreach($strategy_records as $item){
                if($environment != "develop"){
                    $name = $item->name;
                    $item->name = AsmacConstants::encode2utf8($encode,$name);
                    $province = $item->province;
                    $item->province = AsmacConstants::encode2utf8($encode,$province);
                    $city = $item->city;
                    $item->city= AsmacConstants::encode2utf8($encode,$city);
                }
                $type_array=array("高频违规","公众举报","110尾号","公检法号码","特服尾号");
                $item->phone_type = $type_array[$item->phone_type ];
            }
        }
        //=============================
        $model->username=Yii::app()->user->name;
        $this->renderSmarty('asmac/list.html',array('model'=>$model,'strategy_records'=>$strategy_records,'params'=>$params));
    }

    private function doParseExcel2DB($excelFile){
        $factory = Yii::app()->phpExcelFactory;
        $objReader  = $factory->getReader();
        $objPHPExcel = $objReader->read($excelFile);
        //取得excel的总行数
        $highestRow = $objReader->sheets[0]['numRows'];
        //取得excel的总列数
        $highestColumn = $objReader->sheets[0]['numCols'];
        $sucessNum=0;
        $doubleNum=0;
        $totalNum=$highestRow-1;
        try{
            for($row = 2; $row <= $highestRow; $row++){
                $excelData = array ();
                $mapSpePhone = new MapSpePhoneAr();
                for($col = 1; $col <=$highestColumn; $col++) {
                    if($col==2 ||$col==6 ||$col==7){
                        $excelData[] = mb_substr($objReader->sheets[0]['cells'][$row][$col],0,1,'utf-8');
                    }else{
                        $excelData[] = $objReader->sheets[0]['cells'][$row][$col];
                    }
                }
                $phone= $excelData[0];
                $phone_type= $excelData[1];
                $name = $excelData[2];
                $province = $excelData[3];
                $city = $excelData[4];
                $result = $this->addSingle($phone,$phone_type,$name,$province,$city);
                if($result===true) $sucessNum++;
                if($result==="true") $doubleNum++;
            }
            $message = "共有[$totalNum]条，成功[$sucessNum]条,有[$doubleNum]条重复未收录，有[".($totalNum-$sucessNum-$doubleNum)."]条异常！";
            return $message;
        }catch(Exception $e) {
            $message = "共有[$totalNum]条，成功[$sucessNum]条,有[$doubleNum]条重复未收录，有[".($totalNum-$sucessNum-$doubleNum)."]条异常！";
            return $message;
        }
    }
    public function actionTest(){
        //http://www.jb51.net/article/32482.htm
        $excelFile="public/uploads/test.xls";
        $factory = Yii::app()->phpExcelFactory;
        $objReader  = $factory->getReader();
        $objPHPExcel = $objReader->read($excelFile);
        //取得excel的总行数
        $highestRow = $objReader->sheets[0]['numRows'];
        //取得excel的总列数
        $highestColumn = $objReader->sheets[0]['numCols'];
        try{
            for($row = 2; $row <= $highestRow; $row++){
                $excelData = array ();
                $mapSpePhone = new MapSpePhoneAr();
                for($col = 1; $col <=$highestColumn; $col++) {
                    if($col==2 ||$col==6 ||$col==7){
                        $excelData[] = mb_substr($objReader->sheets[0]['cells'][$row][$col],0,1,'utf-8');
                    }else{
                        $excelData[] = $objReader->sheets[0]['cells'][$row][$col];
                    }
                }
                $environment = Yii::app()->params['environment'];
                if($environment != "develop"){
                    $mapSpePhone->city=iconv("UTF-8","GBK",$excelData[4]);
                    $mapSpePhone->name=iconv("UTF-8","GBK",$excelData[2]);
                    $mapSpePhone->province=iconv("UTF-8","GBK",$excelData[3]);
                }else{
                    $mapSpePhone->city=$excelData[4];
                    $mapSpePhone->name=$excelData[2];
                    $mapSpePhone->province=$excelData[3];
                }
                $mapSpePhone->phone=$excelData[0];
                $mapSpePhone->phone_type=intval($excelData[1]);
                $mapSpePhone->match_type=1;//need change
                $mapSpePhone->status=intval($excelData[6]);
                $mapSpePhone->save();
            }
            //return true;
            print_r($objReader->sheets[0]['cells']);
        }catch(Exception $e) {
            return false;
        }
    }

    public function actionTest1(){
        $d = "false";
        echo $d ? "false" : "not";
        echo true === "true";
    }
}