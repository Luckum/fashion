<?php
class WebAdmin extends CWebUser
{
    public $loginUrl = array('/control/auth/login');
    public $returnUrl = array('/control/index');
    public $allowAutoLogin = true;
    
    public function __get($name)
    {
        if ($this->hasState('__userInfo')) {
            $user=$this->getState('__userInfo',array());
            if (isset($user->$name)) {
                return $user->$name;
            }
        }
        if ($this->hasState($name)) {
            return $this->getState($name,array());
        }

        try{
            return parent::__get($name);
        }catch(Exception $e){
            Yii::log($e->getMessage());
            //$this->logout();
            return '';
        }
    }
 
    public function login($identity, $duration = 0) {
        $this->setState('__userInfo', $identity->getUser());
        parent::login($identity, $duration);
    }
    
    public function init() {
        parent::init();
    }
    
}
