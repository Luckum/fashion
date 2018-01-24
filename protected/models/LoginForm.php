<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required', 'message' => '*required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'safe'),
			// password needs to be authenticated
            array('password', 'clientauth', 'on'=>'clientlogin'),
			array('password', 'adminauth', 'on'=>'adminlogin'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
            'rememberMe'=>Yii::t('base', 'Remember me'),
            'username'=>Yii::t('base', 'Email'),
			'password'=>Yii::t('base', 'Password'),
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function clientauth($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new ClientIdentity($this->username,$this->password);
			if(!$this->_identity->authenticate())
				$this->addError('password', Yii::t('base', 'Incorrect e-mail or password.'));
		}
	}
    
    public function adminauth($attribute,$params)
    {
        if(!$this->hasErrors())
        {
            $this->_identity=new AdminIdentity($this->username,$this->password);
            if(!$this->_identity->authenticate())
                $this->addError('password',Yii::t('base', 'Incorrect e-mail or password.'));
        }
    }

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function clientLogin()
	{
		if($this->_identity===null)
		{
			$this->_identity=new ClientIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===ClientIdentity::ERROR_NONE)
		{
			$duration = $this->rememberMe ? 3600*24*30 : 3600*24; // 30 days
            Yii::app()->member->login($this->_identity, $duration);
			return true;
		}
		else
			return false;
	}
    
    /**
     * Logs in the staff using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function adminLogin()
    {
        if($this->_identity===null)
        {
            $this->_identity=new AdminIdentity($this->username,$this->password);
            $this->_identity->authenticate();
        }
        if($this->_identity->errorCode===AdminIdentity::ERROR_NONE)
        {
            //$duration=0;//$this->rememberMe ? 3600*24*30 : 0; // 30 days
            //@see http://www.yiiframework.com/doc/api/1.1/CWebUser#login-detail
            $duration = 3600*24*365;
            Yii::app()->admin->login($this->_identity,$duration);
            return true;
        }
        else
            return false;
    }
}
