<?php
/**
 * Created by JetBrains PhpStorm.
 * User: xuxiaolong
 * Date: 14-7-7
 * Time: 下午2:36
 * To change this template use File | Settings | File Templates.
 * 对数据库的操作封装在这里
 */
class LoginUserHelper extends LoginUserAr{
    public $model;

    public function LoginUserHelper(){
        $this->model = LoginUserAr::model();
    }

    public function do_hash($string){
        $salt = substr(md5($string), 0, 9);
        return $salt . sha1($salt . $string);
    }

    public function hash_Validate( $source, $target ){
        return ( $this->do_hash($source) == $target);
    }

    public function validate_password($password,$reader){
        $validate = false;
        if ( ($password == '123456') && ($reader->login_passwd =='123456') ){
            $validate = true;
        }
        if($this->hash_Validate($password,$reader->login_passwd)){
            $validate = true;
        }
        return $validate;
    }
}