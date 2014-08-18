<?php
/**
 * all ajax json
 */
class CommonUtilsController extends EbuptController{

    /**
     * @access public
     * @param is添加备注
     * @return nul
     */
    public function actionAddNotes(){
        $stream_number = $_GET["streamNumber"];
        $susdesc = $_GET["notes"];
        $sus_record = SerInterDbtBlackAr::model()->find('stream_number = '.$stream_number);
        $environment = Yii::app()->params['environment'];
        if($environment != "develop"){
            $sus_record ->susdesc = iconv("UTF-8","GBK//ignore",$susdesc);
        }
        $result = $sus_record->save() ? "true" : "false";
        return $this->renderJson($result);
    }

    /**
     *获取试听文件列表
     *@param callingNumber 流水号
     *@return null
     */
    public function actionGetAuditRecords($streamNumber){
        $auditOper = trim($_GET["auditOper"]);
        $sus_record = SerInterDbtBlackAr::model()->find('stream_number = '.$streamNumber);
        $callingNumber = $sus_record->phone_number;
        //根据此电话号码，查询所有录音列表
        $all_records = AsmacConstants::getRecordsByPhoneNumber($callingNumber);
        //$suspect_records= array();
        foreach($all_records as $k=>$item){
            $eachName = str_ireplace(".","_",$item);
            $arr = explode("_",$eachName);
            $each['record_name']=$item;
            $each['phone_number']=$arr[0];
            $each['start_time']=date("Y-m-d H:i:s.000",strtotime($arr[1]));
            $each['susdesc']="被叫用户为：".$arr[2];
            $all_records[$k]=$each;
        }
        $this->renderJson($this->renderSmarty("manage/_recordList.html",array('suspect_records'=>$all_records,'streamNumber'=>$streamNumber,'auditOper'=>$auditOper),true));
        //$this->renderSmarty("manage/_recordList.html",array('suspect_records'=>$all_records,'streamNumber'=>$streamNumber));
    }

    /**
     * 处理确认情况
     * @param callingNumber
     * @param type 0正常，1诈骗 ，2正常+诈骗电话号码
     * 确认思路：都要修改疑似表的相关字段num_state、Illegal_reason、ensure_time
     * 非正常的，查询没有则新建确认表的数据，注意不同类型有效期，有则更新
     * 关于有效期和策略相关的数据可以通过查表
     * @return null
     */
    public function actionMakeRecordAudited($streamNumber,$type){
        $response = $this->makeRecordAudited($streamNumber,$type);
        return $this->renderJson($response);
    }
    private function makeRecordAudited($streamNumber,$type){
        $sus_record = SerInterDbtBlackAr::model()->find('stream_number = '.$streamNumber);
        $sus_record->ensure_time = date("YmdHis",time());
        $pho_num = $sus_record->phone_number;
        $reasons = array(0,1,3);
        $sus_record->illegal_reason =$reasons[$type];
        $states = array(2,1,3);
        $sus_record->num_state = $states[$type];
        $saved = $sus_record->save() ? 'true' : 'false';
        $confirm_record = SerInterBlackAr::model()->find('phone_number = "'.$pho_num.'"');
        if($type == 1){
            //$confirm_record = SerInterBlackAr::model();
            if(empty($confirm_record)){
                $confirm_record = new SerInterBlackAr();
                $confirm_record->setAttributes($sus_record->attributes);
                $confirm_record->seg_flag='1';
                $confirm_record->intercept_times=0;
            }
            $days = ItfSysconfigHelper::get_valid_days($sus_record->phone_type);
            //date("Y-m-d H:i:s.000",strtotime($arr[1]));
            $intercept_valid = time()+$days*24*3600;
            $confirm_record->intercept_valid = date("YmdHis",$intercept_valid);
        }else{
            if(!empty($confirm_record)){
                $intercept_valid = time()-365*24*3600;
                $confirm_record->intercept_valid = date("YmdHis",$intercept_valid);
            }
        }
        if(!empty($confirm_record)){
            $confirm_record->illegal_reason=$reasons[$type];
            $mapSperPho = MapSpePhoneAr::model()->find('phone = "'.$pho_num.'"');
            $reason_desc= empty($mapSperPho) ? $sus_record->susdesc : $mapSperPho->name;
            $environment = Yii::app()->params['environment'];
            if($environment != "develop"){
                $confirm_record->reason_desc= iconv("UTF-8","GBK//ignore",$reason_desc);
            }else{
                $confirm_record->reason_desc= $reason_desc;
            }
            $saved= ($confirm_record->save()&& $saved) ? "true" : "false";
        }
        $status = AsmacConstants::get_phoNum_status($sus_record->num_state,$sus_record->ensure_time);
        $result = AsmacConstants::get_phoNum_audit_result($sus_record->num_state,$sus_record->illegal_reason);
        $response = array($saved,$streamNumber);
        $response[2]="<span style='color:red'><strong>$status</strong></span>";
        $response[3]="<span style='color:red'><strong>$result</strong></span>";
        return $response;
    }

    public function actionMakeRecordDeleted($streamNumber){
        $result = null;
        $sus_record = SerInterDbtBlackAr::model()->find('stream_number = '.$streamNumber);
        $pho_num = $sus_record->phone_number;
        $result += SerInterBlackAr::model()->deleteAll('phone_number = "'.$pho_num.'"');
        $result += SerInterDbtBlackAr::model()->deleteAll('stream_number = '.$streamNumber);
        return $this->renderJson($result);
    }

    /**
     * 获取最新的电话记录
     * 满足条件：记录数超过10次，且去前15条
     * @
     */
    public function actionGetIntervalData(){
        $helper = new SerInterDbtblackHelper();
        $suspect_records =$helper->get_newest_suspected_records();
        $environment = Yii::app()->params['environment'];
        if($environment != "develop"){
            $encode = mb_detect_encoding($suspect_records, array('GB2312','GBK','UTF-8'));
        }
        foreach($suspect_records as $item){
            $status = AsmacConstants::get_phoNum_status($item->num_state,$item->ensure_time);
            $result = AsmacConstants::get_phoNum_audit_result($item->num_state,$item->illegal_type);
            if($environment != "develop"){
                $susdesc = '';
                $susdesc .= $item->susdesc;
                $item->susdesc = AsmacConstants::encode2utf8($encode,$susdesc);
            }
            $item->num_state = $status;
            $item->illegal_type = $result;
            $item->start_time=date("Y-m-d H:i:s.000",strtotime($item->start_time));
            $item->end_time=date("Y-m-d H:i:s.000",strtotime($item->end_time));
        }
        $this->renderJson($this->renderSmarty("manage/_intervalData.html",array('suspect_records'=>$suspect_records),true));
    }

    /**
     * 统计页面表格里的数据
     *numberType callingNumber calledNumber notesDesc strategyType
     *operTimeBegin operTimeEnd
     */
    public function actionGetStatisticsInjectedData(){
        $tabNum=$_GET["tabNum"];
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
        $model = new AsmacLoginForm();
        $model->page_selector = $tabNum;
        $offset = ($countPerPage)*$currentPage;
        if($offset<0) $offset = 0;
        $statistics_records =AsmacConstants::get_grids_data_by_conditions($countPerPage,$offset,true);
        if($statistics_records!==false){
            $environment = Yii::app()->params['environment'];
            if($environment != "develop"){
                $encode = mb_detect_encoding($statistics_records, array('GB2312','GBK','UTF-8'));
            }
            foreach($statistics_records as $item){
                if($tabNum==3){
                    if($environment != "develop"){
                        $reason_desc = ''.$item->reason_desc;
                        $item->reason_desc = AsmacConstants::encode2utf8($encode,$reason_desc);
                    }
                    $item->illegal_type = SerInterBlackHelper::get_illegal_type($item->illegal_type);
                    $item->illegal_reason = SerInterBlackHelper::get_illegal_reason($item->illegal_reason);
                    $item->commit_time=date("Y-m-d H:i:s.000",strtotime($item->commit_time));
                    //$item->intercept_valid=date("Y-m-d H:i:s.000",strtotime($item->intercept_valid));
                    $item->intercept_valid=date("Y-m-d H:i:s.000",strtotime($item->intercept_valid));
                }else{
                    $illegal_type = AsmacConstants::get_phoNum_audit_result($item->num_state,$item->illegal_type);
                    $item->illegal_type = $illegal_type;
                    if($environment != "develop"){
                        $sus_type_desc = ''.$item->sus_type_desc;
                        $item->sus_type_desc = AsmacConstants::encode2utf8($encode,$sus_type_desc);
                    }
                    $item->start_time=date("Y-m-d H:i:s.000",strtotime($item->start_time));
                    $item->end_time=date("Y-m-d H:i:s.000",strtotime($item->end_time));
                }
            }
        }
        //$this->renderSmarty("commonUtils/_statisticsInjectedData.html",array('model'=>$model,'statistics_records'=>$statistics_records));
        $this->renderJson($this->renderSmarty("commonUtils/_statisticsInjectedData.html",array('model'=>$model,'statistics_records'=>$statistics_records),true));
    }

    //绘图用数据，与上面应该是统一的
    public function actionGetChartsData(){
        $tabNum=$_GET["tabNum"];
        $tabTitles=array("","按策略分析信息总览","确认信息总览","拦截信息总览");
        $charData_1=array("charName"=>array("按策略分析信息总览饼图","按策略分析信息总览柱状图"),
            "seriesName"=>array("比重","数目"),
            "data"=>array("pie"=>array("公众举报"=>33.0,"110尾号"=>12.5,"公检法号码"=>47.5,"特服尾号"=>17.0),
                "column"=>array("123"=>33,"110尾号"=>12,"公检法号码"=>48,"特服尾号"=>17),
            ));
        $charData_2=array("charName"=>array("确认信息总览饼图","确认信息总览柱状图"),
            "seriesName"=>array("比重","数目"),
            "data"=>array("pie"=>array("疑似"=>75.0,"确认"=>25.0),
                "column"=>array("123"=>75,"确认"=>25),
            ));
        $charData_3=array("charName"=>array("拦截信息总览饼图","拦截信息总览柱状图"),
            "seriesName"=>array("比重","数目"),
            "data"=>array("pie"=>array("网间国际"=>23.0,"网间非国际"=>34.0,"网内国际"=>13.0,"网内非国际"=>30.0),
                "column"=>array("123"=>23.0,"网间非国际"=>34.0,"网内国际"=>13.0,"网内非国际"=>30.0),
            ));
        $charDatas=array('',$charData_1,$charData_2,$charData_3);
        $model = new AsmacLoginForm();
        //$model->totalNum=$this->get_grids_data_by_conditions(0,0,false);
        $allTabsArray=array();
        $allTabsArray[1]=array("公众举报","110尾号","公检法号码","特服尾号");
        $allTabsArray[2]=$allTabsArray[1];
        $allTabsArray[3]=array("网间国际","网间非国际","A口国际","SCP");
        $results = array();
        $_partName= $_GET["partName"];
        if($_partName =='null') $_partName =$allTabsArray[$tabNum][0];
        foreach($allTabsArray[$tabNum] as $item){
            $_GET["partName"]=$item;
            $results[$item] = AsmacConstants::get_grids_data_by_conditions(0,0,false);
            $model->totalNum += $results[$item];
        }
        $_GET["partName"]=$_partName;
        $model->tabTitle = $tabTitles[$tabNum];
        $charDatas[$tabNum]['data']['column']=$results;
        foreach($results as $k=>$v){
            $results[$k]= (float)sprintf('%.0f', (floatval($v) / floatval(1)) * 100);
        }
        $charDatas[$tabNum]['data']['pie']=$results;
        $model->page_selector = $tabNum;
        $params = $_GET;
        $this->renderJson($this->renderSmarty("commonUtils/_statisticsChartsJs.html",array("charData"=>$charDatas[$tabNum],'params'=>$params),true));
    }

    /**
     * test
     */
    public function actionGetChartsData1(){
        $tabNum=$_GET["tabNum"];
        $tabTitles=array("","按策略分析信息总览","确认信息总览","拦截信息总览");
        $charData_1=array("charName"=>array("按策略分析信息总览饼图","按策略分析信息总览柱状图"),
            "seriesName"=>array("比重","数目"),
            "data"=>array("pie"=>array("公众举报"=>33.0,"110尾号"=>12.5,"公检法号码"=>47.5,"特服尾号"=>17.0),
                "column"=>array("公众举报"=>33,"110尾号"=>12,"公检法号码"=>48,"特服尾号"=>17),
            ));
        $charData_2=array("charName"=>array("确认信息总览饼图","确认信息总览柱状图"),
            "seriesName"=>array("比重","数目"),
            "data"=>array("pie"=>array("疑似"=>75.0,"确认"=>25.0),
                "column"=>array("疑似"=>75,"确认"=>25),
            ));
        $charData_3=array("charName"=>array("拦截信息总览饼图","拦截信息总览柱状图"),
            "seriesName"=>array("比重","数目"),
            "data"=>array("pie"=>array("网间国际"=>23.0,"网间非国际"=>34.0,"网内国际"=>13.0,"网内非国际"=>30.0),
                "column"=>array("网间国际"=>23.0,"网间非国际"=>34.0,"网内国际"=>13.0,"网内非国际"=>30.0),
            ));
        $charDatas=array('',$charData_1,$charData_2,$charData_3);
        $model = new AsmacLoginForm();
        $model->tabTitle = $tabTitles[$tabNum];
        $model->page_selector = $tabNum;
        $params = $_GET;
        $this->renderJson($this->renderSmarty("commonUtils/_statisticsChartsJs.html",array("charData"=>$charDatas[$tabNum],'params'=>$params),true));
    }

    //single add
    public function actionAddSingle($phoneType,$phone_number){
        $result = $this->addSingle($phoneType,$phone_number);
        if($result==='true'){
            $message = "该[$phone_number]已存在,请您知晓！";
        }else{
            $message = $result ? "添加成功！" : "网络异常，请稍后!";
        }
        return $this->renderJson($message);
    }

    private function addSingle($phoneType,$phone_number){
        //commit_time, start_time, end_time, phone_number, phone_type, illegal_reason, num_state,
        //last_called, susdesc, actperiod, act_type, fe_id', 'required')
        $temp = SerInterDbtBlackAr::model()->find('phone_number = "'.$phone_number.'"');
        if($temp) return "true";
        $serInterDbt= new SerInterDbtBlackAr();
        $serInterDbt->phone_number=$phone_number;
        $times = date("YmdHis");
        $serInterDbt->commit_time=$serInterDbt->end_time=$serInterDbt->start_time=$times;
        $serInterDbt->phone_type=5;
        $serInterDbt->illegal_type=1;
        $serInterDbt->call_times=1;
        $serInterDbt->last_called=$phone_number;
        $environment = Yii::app()->params['environment'];
        if($environment != "develop"){
            $serInterDbt->susdesc=iconv("UTF-8","GBK//ignore","来源于客户投诉");
        }
        $serInterDbt->actperiod=1;
        $serInterDbt->act_type=99;
        $serInterDbt->fe_id=256;
        if($phoneType==1){
            $serInterDbt->num_state=$serInterDbt->illegal_reason=1;
            $serInterDbt->ensure_time=$times;
        }else{
            $serInterDbt->num_state=$serInterDbt->illegal_reason=0;
        }
        try{
            $serInterDbt->save();
            if($phoneType==1){
                $records= SerInterDbtBlackAr::model()->find('phone_number = '.$phone_number);
                $this->makeRecordAudited($records->stream_number,1);
            }
            $result = true;
        }catch(Exception $e){
            SerInterDbtBlackAr::model()->deleteAll('phone_number = '.$records->phone_number);
            $result = false;
        }
        return $result;
    }

    //add batch
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
                for($col = 1; $col <=$highestColumn; $col++) {
                    if($col==2){
                        $excelData[] = mb_substr($objReader->sheets[0]['cells'][$row][$col],0,1,'utf-8');
                    }else{
                        $excelData[] = $objReader->sheets[0]['cells'][$row][$col];
                    }
                }
                $result = $this->addSingle($excelData[1],$excelData[0]);
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
                for($col = 1; $col <=$highestColumn; $col++) {
                    if($col==2){
                        $excelData[] = mb_substr($objReader->sheets[0]['cells'][$row][$col],0,1,'utf-8');
                    }else{
                        $excelData[] = $objReader->sheets[0]['cells'][$row][$col];
                    }
                }
                //actionAddSingle($phoneType,$phone_number)
                $this->actionAddSingle($excelData[1],$excelData[0]);
            }
            return true;
            //print_r($objReader->sheets[0]['cells']);
            //print_r($excelData);
        }catch(Exception $e) {
            return false;
        }
    }
}
