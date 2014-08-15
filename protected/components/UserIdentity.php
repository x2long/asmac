<?php
/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	
	private $_id;
	
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user_helper = new LoginUserHelper();
        $username=$this->username;
        $password=$this->password;
		$user = $user_helper->find('user_name = ?', array($username));
		if(count($user) != 0) {
            $reader_validate = $user_helper->validate_password($password,$user);
            if($reader_validate){
                $this->_id = $user->user_id;
                $this->setState('name', $user->user_name);
                $this->setState('defaultUrl', $this->getDefaultUrl());
                return true;
            }else{
                return false;
            }
	    }
       	else {
			return FALSE;
        }
	}

	public function getId()
	{
		return $this->_id;
	}
	
	public function getDefaultUrl() {
        return Yii::app()->getBaseUrl()."/manage";
    }
}
