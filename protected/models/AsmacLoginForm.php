<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class AsmacLoginForm extends FormModel
{
    public $username;
    public $login_passwd;
    public $returnUrl;
    public $tabTitle;
    public $message;
    public $errorInfo = "";

    private $_identity;

    /*
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules(){
        return array(
            // username and password are required
            array('username, login_passwd', 'required'),
            // password needs to be authenticated
            //array('login_passwd', 'authenticate', 'skipOnError'=>true),
            array('username, returnUrl','safe')
        );
    }

    /*
     * Declares attribute labels.
     */
    public function attributeLabels(){
        return array(
            'verifyCode'=>'Verification Code',
        );
    }

    /*
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute,$params){
        $this->_identity=new UserIdentity($this->username,$this->login_passwd);
        if(!$this->_identity->authenticate())
            $this->addError('password','Incorrect username or password.');
    }

    /*
     *处理登录过程
     */
    public function processLogin(){
        if($this->username != NULL && $this->login_passwd != NULL){
            $authenticate = new UserIdentity($this->username,$this->login_passwd);
            if ($authenticate->authenticate()){  //如果验证通过
                Yii::app()->user->login($authenticate, 3600*24*7);//存入session
                return true;
            }else{
                $this->message = '用户名密码错误';
                return false;
            }
        }
    }
}
