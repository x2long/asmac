<?php

class SiteController extends EbuptController
{
    public $model ;
    public $layout = '';
    public function filters() {
        //return array('accessControl',);
    }

    public function accessRules(){
      /*  return array(
            array('deny',
                'actions'=>array('create'),
                'users'=>array('Guest','test','guest'),
            ),
            array('deny',
                'actions'=>array('create'),
                'expression'=>array($this,'isNotAdmin'),
            ),
        );*/
    }
    //网站主页 暂时定为登陆页面，功能最简答出发
    public function actionIndex(){
        if(!Yii::app()->user->isGuest){
            $this->redirect(Yii::app()->user->defaultUrl);
        }
        $model= new AsmacLoginForm();
        $model->errorInfo='';
        if(isset($_POST["j_username"])) {
            $model->username=$_POST["j_username"];
            $model->login_passwd = $_POST['j_password'];
            // validate user input and redirect to the previous page if valid
            var_dump($model->processLogin());
            if ( $model->validate() && $model->processLogin() ){
                // 按以下优先级决定检查地址：
                $nextUrl = Yii::app()->user->defaultUrl;
                // 重定向到上面决定的页面
                $this->redirect($nextUrl);
            }
            else {
                // 记录登录错误的次数(into $_SESSION)
                $errCount = Yii::app()->user->getState('loginError');
                ++$errCount;
                Yii::app()->user->setState('loginError', $errCount);
                $model->errorInfo = "您输入的用户名或密码错误！";
            }
        } else {
            $model->errorInfo = "";
        }
        $this->renderSmarty('site/index.html', array('model' => $model));
    }

    /*
     * logout
     */
    public function actionLogout(){
        Yii::app()->user->logout();//注销session
        $this->redirect(Yii::app()->getBaseUrl());
    }

    public function actionCreate(){
        if(isset($_POST['classname']) && ($_POST['classname'])){
            $info= $_POST;
            $classname = $_POST['classname'];
        }else{
            $classname = 'CfgItrStrategyAr';
        }
        if(isset($_POST['encryption']) && $_POST['encryption'] && !empty($_POST[$_POST['encryption']])){
            $encryption = $_POST['encryption'];
            $user_helper = new LoginUserHelper();
            $_POST[$encryption] = $user_helper->do_hash($_POST[$encryption] );
        }
        $instance = new $classname();
        $attributes = $instance->attributes;
        if(isset($_POST['number']) && !empty($_POST['number'])){
            $number = $_POST['number'];
        }else{
            $number = 1;
        }
        if(isset($_POST['save']) && !empty($_POST['save'])){
            // no for
            $allvalues = $_POST;
            $allvalues = AsmacConstants::iconv_array($allvalues);
            for($i=0;$i<$number;$i++){
                $instance->setAttributes($allvalues);
                if(isset($allvalues["phone_number"])){
                    $instance->phone_number = $allvalues["phone_number"]+$i;
                }
                $save = $instance->save() ? "yes" : "no";
            }
        }
        //var_dump(array_keys($attributes));
        $attributes = array_keys($attributes);
        $classes = array('CfgItrStrategyAr','ItfContralogAr','ItfRecordlogAr','ItfSysconfigAr','MapSpePhoneAr',
                         'SerInterBlackAr','SerInterDbtBlackAr','LoginUserAr');
        $this->renderSmarty("site/generate.html",array("classes"=>$classes,'save'=>$save,'classname'=>$classname,'attributes'=>$attributes,'info'=>$allvalues));

    }

    protected function isNotAdmin($user){//判断是否是管理员
        return ($this->loadModel($user->id)->user_name!="admin");
    }

    public function loadModel($id) {
        $model=LoginUserAr::model()->findByPk((int)$id);
        if($model===null){
            throw new CHttpException(404,'页面不存在');
        }
        return $model;
    }
    
}
