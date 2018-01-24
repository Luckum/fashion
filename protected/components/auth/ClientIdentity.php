<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class ClientIdentity extends CUserIdentity
{
    
    public $member;
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
        $member = User::model()->findByAttributes(array('email' => $this->username));

		if($member == null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else {
            if($member->password!=sha1($this->password))
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            else {
                $this->setUser($member);
                $this->_id = $member->id;
                $this->setState('username', $member->username);
                /// update last login value
                $member->saveAttributes(array('last_login' => new CDbExpression('NOW()')));
                $this->errorCode=self::ERROR_NONE;
            }
        }
		return !$this->errorCode;
	}
    
    public function getUser()
    {
        return $this->member;
    }
 
    public function setUser($member)
    {
        $this->member=$member->attributes;
    }

    public function getId()
    {
        return $this->_id;
    }
}
