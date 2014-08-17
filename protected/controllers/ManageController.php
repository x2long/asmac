<?php
//class for main feature
class ManageController extends EbuptController
{
	public $model ;
	public $layout = '';

    public function filters() {
        return array('accessControl',);
    }

    public function accessRules(){
        return array(
            array('deny',
                'actions'=>array('index','dataStatistic','audit','dataQuery'),
                'users'=>array('Guest','test','guest'),
            ),
        );
    }

    public function actionIndex(){
        if( isset($_GET["countPerPage"]) && $_GET["countPerPage"]){
            $countPerPage =trim($_GET['countPerPage']);
        }else{
            $countPerPage = 20;
        }
        if( isset($_GET["currentPage"]) && $_GET["currentPage"]){
            $currentPage =trim($_GET['currentPage']);
        }else{
            $currentPage = 0;
        }
        if( isset($_GET["needInterval"]) && $_GET["needInterval"]){
            $needInterval =trim($_GET['needInterval']);
        }else{
            $needInterval = "true";
        }
        $model = new AsmacLoginForm();
        $model->username = Yii::app()->user->name;
        $title = "人工审核";
        $helper = new SerInterDbtblackHelper();
        $params =$_GET;
        $model->totalNum =$helper->get_suspected_records_by_conditions(0,0,false);
        if($model->totalNum === false) $model->totalNum = 0;
        $model->currentPage = $currentPage;
        $model->countPerPage = $countPerPage;
        $offset = ($countPerPage)*$currentPage;
        if($offset<0) $offset = 0;
        if($needInterval==="true"){
            $suspect_records =$helper->get_newest_suspected_records();
        }else{
            $suspect_records =$helper->get_suspected_records_by_conditions($countPerPage,$offset,true);
        }
        if($suspect_records != false){
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
        }
        $this->renderSmarty('manage/index.html',array('model'=>$model,'title'=>$title,'suspect_records'=>$suspect_records,'params'=>$params));

    }

    //审核,actually is history
    public function actionAudit(){
        if( isset($_GET["countPerPage"]) && $_GET["countPerPage"]){
            $countPerPage =trim($_GET['countPerPage']);
        }else{
            $countPerPage =20;
        }
        if( isset($_GET["currentPage"]) && $_GET["currentPage"]){
            $currentPage =trim($_GET['currentPage']);
        }else{
            $currentPage =0;
        }
        //根据上面的情况查询数据
        //============================
        $helper = new SerInterDbtblackHelper();
        //$suspect_records =$helper->get_newest_suspected_records();
        $model = new AsmacLoginForm();
        $params =$_GET;
        $model->totalNum =$helper->get_suspected_records_by_conditions(0,0,false);
        if($model->totalNum === false) $model->totalNum = 0;
        $model->currentPage = $currentPage;
        $model->countPerPage = $countPerPage;
        $offset = ($countPerPage)*$currentPage;
        if($offset<0) $offset = 0;
        $suspect_records =$helper->get_suspected_records_by_conditions($countPerPage,$offset,true);
        if($suspect_records != false){
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
        }
        //=============================
        $model->username=Yii::app()->user->name;
        $this->renderSmarty('manage/audit.html',array('model'=>$model,'suspect_records'=>$suspect_records,'params'=>$params));
    }

    public function actionCallHistory(){
        if( isset($_GET["countPerPage"]) && $_GET["countPerPage"]){
            $countPerPage =trim($_GET['countPerPage']);
        }else{
            $countPerPage = 20;
        }
        if( isset($_GET["currentPage"]) && $_GET["currentPage"]){
            $currentPage =trim($_GET['currentPage']);
        }else{
            $currentPage = 0;
        }
        //============================
        $helper = new ItfContralogHelper();
        //$suspect_records =$helper->get_newest_suspected_records();
        $model = new AsmacLoginForm();
        $params =$_GET;
        $model->totalNum =$helper->get_contralog_records_by_conditions(0,0,false);
        if($model->totalNum === false) $model->totalNum = 0;
        $model->currentPage = $currentPage;
        $model->countPerPage = $countPerPage;
        $offset = ($countPerPage)*$currentPage;
        if($offset<0) $offset = 0;
        $contralog_records =$helper->get_contralog_records_by_conditions($countPerPage,$offset,true);
        if($contralog_records !== false){
            foreach($contralog_records as $item){
                $item->callbegintime=date("Y-m-d H:i:s.000",strtotime($item->callbegintime));
                $item->callendtime=date("Y-m-d H:i:s.000",strtotime($item->callendtime));
            }
        }
        //=============================
        $model->username=Yii::app()->user->name;
        $this->renderSmarty('manage/callHistory.html',array('model'=>$model,'contralog_records'=>$contralog_records,'params'=>$params));
    }

    //数据查询接口
    //疑似：主要看确认等信息，这个在上面已经实现 故不考虑
    //确认：看拦截信息
    //numberType=&callingNumber=&calledNumber=&notesDesc=&strategyType=
    //&operTimeBegin=&countPerPage=10&operTimeEnd=&currentPage=1&countPerPage=10
    public function actionDataQuery(){
        if( isset($_GET["countPerPage"]) && $_GET["countPerPage"]){
            $countPerPage =trim($_GET['countPerPage']);
        }else{
            $countPerPage =20;
        }
        if( isset($_GET["currentPage"]) && $_GET["currentPage"]){
            $currentPage =trim($_GET['currentPage']);
        }else{
            $currentPage =0;
        }
        //根据上面的情况查询数据
        //==================================
        $helper = new SerInterBlackHelper();
        //$suspect_records =$helper->get_newest_suspected_records();
        $model = new AsmacLoginForm();
        $params =$_GET;
        $model->totalNum =$helper->get_confirmed_records_by_conditions(0,0,false);
        if($model->totalNum === false) $model->totalNum = 0;
        $model->currentPage = $currentPage;
        $model->countPerPage = $countPerPage;
        $offset = ($countPerPage)*$currentPage;
        if($offset<0) $offset = 0;
        $confirmed_records =$helper->get_confirmed_records_by_conditions($countPerPage,$offset,true);
        if(!empty($confirmed_records)){
            $environment = Yii::app()->params['environment'];
            if($environment != "develop"){
                $encode = mb_detect_encoding($confirmed_records[0]->reason_desc, array('GB2312','GBK','UTF-8'));
            }
            foreach($confirmed_records as $item){
                if($environment != "develop"){
                    $reason_desc = ''.$item->reason_desc;
                    $item->reason_desc = AsmacConstants::encode2utf8($encode,$reason_desc);
                }
                $item->illegal_type = SerInterBlackHelper::get_illegal_type($item->illegal_type);
                $item->illegal_reason = SerInterBlackHelper::get_illegal_reason($item->illegal_reason);
                $item->commit_time=date("Y-m-d H:i:s.000",strtotime($item->commit_time));
                //$item->intercept_valid=date("Y-m-d H:i:s.000",strtotime($item->intercept_valid));
                $item->intercept_valid=date("Y-m-d H:i:s.000",strtotime($item->intercept_valid));
            }
        }
        //=================================
        $model->username=Yii::app()->user->name;
        $this->renderSmarty("manage/dataQuery.html",array('model'=>$model,'kinds_records'=>$confirmed_records,'params'=>$params));
    }

    //统计查询口径
    public function actionDataStatistic(){
        $model = new AsmacLoginForm();
        $model->username = Yii::app()->user->name;
        $this->renderSmarty("manage/dataStatistics.html",array('model'=>$model));
    }


    /**
     * 根据tab页面来获取数据，此处为初始数据
     * tab=按策略分析:默认显示【 时间：不限】【类型：不限】的数据
     *               查询条件：时间范围和类型
     * tab=国际确认信息:默认显示【 时间：不限】【类型：已确认】的数据
     *               同上
     *          注意以上两项按照策略细分的
     * tab=拦截信息总览:默认显示【 时间：不限】【策略：不限】的数据
     *              查询条件：时间和策略
     */
    public function actionGetStatisticsFrameCharts(){
        $tabNum=$_GET["tabNum"];
        $tabTitles=array("","按策略分析信息总览","确认信息总览","拦截信息总览");
        $model = new AsmacLoginForm();
        $model->tabTitle = $tabTitles[$tabNum];
        $model->page_selector = $tabNum;
        $this->renderJson($this->renderSmarty("manage/_statisticsFrameCharts.html",array('model'=>$model),true));
    }

    public function actionGetStatisticsGrids(){
        //get totalNum for each kind
        $tabNum=$_GET["tabNum"];
        $model = new AsmacLoginForm();
        $allTabsArray=array();
        $allTabsArray[1]=array("高频违规","公众举报","110尾号","公检法号码","特服尾号");
        $allTabsArray[2]=$allTabsArray[1];
        $allTabsArray[3]=array("网间国际","网间非国际","A口国际");
        $model->totalNum = AsmacConstants::get_grids_data_by_conditions(0,0,false);
        $params = $_GET;
        $model->currentPage = 0; //default
        $model->countPerPage = 10; //default
        $this->renderJson($this->renderSmarty("manage/_statisticsGrids.html",array('model'=>$model,'params'=>$params),true));
    }

}
