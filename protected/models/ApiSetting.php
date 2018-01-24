<?php

class ApiSetting extends CFormModel
{
	private   $_file;
    private   $_params = array();
    private $_paramsFileName;
    private static $_apis = array('dhl', 'mailchimp', 'quickBooks', 'paypal');

    public function __construct($paramsFileName) {
        $this->_paramsFileName = $paramsFileName;
        parent::__construct();
    }
    
	public function init()
	{
		$this->_file  = $this->getFilePath();
		if (!file_exists($this->_file)) {
			throw new CException("File $this->_file does not exist");
		}
		$this->_params = require $this->_file;
	}
	
	public function getFilePath()
	{
        return Yii::getPathOfAlias('application.config.params.' . $this->_paramsFileName) . '.php';
	}

    public static function getApisName()
    {
        return self::$_apis;
    }
	
	/**
	 * @return array validation rules for model attributes.
	 */
    public function rules()
    {
    	return array( 
    		array(implode(',', array_keys($this->_params)), 'required', 'on'=>'required', 'message' => '*required'),
    	);
    }
    
    /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{ 
		$labels = array();        
        foreach ($this->_params as $key => $value) {
            $labels[$key] = Yii::t('base', $this->generateAttributeLabel($key));
        }
        foreach (self::$_apis as $key => $value) {
            $labels[$key] = Yii::t('base', $this->generateAttributeLabel($key));
        }        
        return $labels;
    }
	
	public function getSettings()
    {
    	return $this->_params;
    }
    
	public function setSettings($data)
    {
        foreach($this->_params as $key => $value) {
            if (isset($data[$key])) {
                $this->_params[$key] = $data[$key];
            }    
        }
    }

    protected function beforeValidate(){
        foreach ($this->getSettings() as $key => $value) {
            if (!empty($value)) {
                $this->setScenario('required');
            }
        }
        return parent::beforeValidate();
    }
    
    /**
     *  Save array of new settings in the file
     */
	public function save()
    {
    	if ($this->validate()) {
            return file_put_contents(
                $this->_file, '<?php return ' . var_export($this->_params, true) . ';'
            );
        }      
        return false;
     }
    
	public function __get($name)
    {
    	if (isset($this->_params[$name])) {
            return $this->_params[$name];
    	}
        try {
            return parent::__get($name);
        } catch (CException $e) {
            return '';
        }
    }
    
    public function __set($name, $value)
    {
        if (isset($this->_params[$name])) {
            $this->_params[$name] = $value;
        } else {
            parent::__set($name, $value);
        }                
    }        
}