<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AdminIdentity extends CUserIdentity
{
    public $admin;
    private $_id;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	 public function authenticate() 
     {
        $admin = Admin::model()->findByAttributes(array('username' => $this->username));       
        if($admin == null) {
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        }
        else{
            
            if($admin->password!=sha1($this->password))
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            else {
                $this->setUser($admin);
                $this->_id = $admin->id;
                $this->setState('username', $admin->username);
                /// update last login value
                $admin->saveAttributes(array('last_login' => date('Y-m-d H:i:s')));
                $this->errorCode=self::ERROR_NONE;

            }
        }
        return !$this->errorCode;
    }
    
    public function getUser()
    {
        return $this->admin;
    }
 
    public function setUser($admin)
    {
        $this->admin=$admin;
    }

    public function getId()
    {
        return $this->_id;
    }
}