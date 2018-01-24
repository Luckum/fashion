<?php

class WebClient extends CWebUser
{
    public $loginUrl;
    public $returnUrl;
    public $allowAutoLogin = true;
    
    public function __get($name)
    {
        if ($this->hasState($name)) {
            return $this->getState($name,array());
        }
        if ($this->hasState('__userInfo')) {
            $user=$this->getState('__userInfo',array());
            if (isset($user[$name])) {
                return $user[$name];
            }
        }
        
        try{
            return parent::__get($name);
        }catch(Exception $e){
            Yii::log($e->getMessage());
            //$this->logout();
            return '';
        }
    }

    public function __set($name, $value)
    {
        $this->setState($name, $value);
    }
 
    public function login($identity, $duration = 0) {
        $this->setState('__userInfo', $identity->getUser());
        parent::login($identity, $duration);
    }
    
    public function init() {
        $this->returnUrl = array('/members/index');
        $this->loginUrl = array('/members/auth/login');
        parent::init();
    }
}
