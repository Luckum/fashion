<?php
/**
 * Model class for Language.
 *
 * The followings priperties are the available:
 * @property stirngs $name
 * @property strings $prefix
 * @property strings $dir - language directory
 */
class Language extends CModel
{
    public $name;
    public $prefix;
    public $dir;
    
    public  $langsDir;
    private $_new = false;
    private $_oldPrefix;
    
    public function __construct($prefix = false)
    {
        $this->langsDir = Yii::app()->messages->basePath;
                
        if (!$prefix) {
            $this->setIsNewRecord(true);
        } else {
            $this->prefix = $prefix;
            $this->dir    = $this->langsDir . DIRECTORY_SEPARATOR . $this->prefix;
            if (!is_dir($this->dir)) {
                throw new CException('There is no directory ' . $this->dir);
            }
            include_once $this->dir . DIRECTORY_SEPARATOR . 'index.php';
            $this->name = $__lang_name;
            $this->_oldPrefix = $this->prefix;
        }        
    }
    
    public function attributeNames()
    {
        return array('name', 'preix');
    }
    
    public static function getList()
    {
        $langs = array();
        $langs_dir = Yii::app()->messages->basePath;

        if (!is_dir($langs_dir)) die("Fatal error - can't find langs directory!");
        $d = dir($langs_dir);
        while (false !== ($entry = $d->read())) {
            if (strpos($entry, ".")) continue;
            $fname = $langs_dir . DIRECTORY_SEPARATOR . $entry . DIRECTORY_SEPARATOR ."index.php";
            if (!file_exists($fname) or !is_file($fname)) 
                continue;
            include($fname);
            $langs[$__lang_sn] = $__lang_name;
        }
        return $langs;
    }
    
    public static function getListForTableview()
    {
        $langsList = self::getList();
        $result    = array();
        foreach ($langsList as $key => $value) {
            $result[] = array(
                'name'   => $value,
                'prefix' => $key
            );
        }
        
        return new CArrayDataProvider($result, array('keyField' => 'prefix'));
    }
    
    public function setIsNewRecord($value)
    {
        $this->_new = $value;
    }
    
    public function attributeLabels()
    {
        return array(
            'name'    => Yii::t('base', 'Language Name'),
            'prefix'  => Yii::t('base', 'Prefix'),
        );
    }
    
    public function rules()
    {
        return array(
            array('name, prefix', 'required', 'message' => '*required'),
            array('prefix', 'length', 'max' => 2),
            array('name, prefix', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('prefix', 'uniquePrefix', 'message' => Yii::t('base', 'Prefix is not unique')),
        );
    }
    
    public function uniquePrefix($attribute, $params = array())
    {
        $langs = self::getList();
        if (!$this->getIsNewRecord()) {
            unset($langs[$this->_oldPrefix]);
        }
        if (!$this->hasErrors()) {
            if (array_key_exists($this->$attribute, $langs)) {
                $this->addError('prefix', $params['message']);
            }
        }
    }
    
    public function getIsNewRecord()
    {
        return $this->_new;
    }
    
    public function save()
    {
        return $this->getIsNewRecord() ? $this->insert() : $this->update();
    }
    
    public function insert()
    {
        $defaultFiles = array_diff(scandir($this->langsDir . DIRECTORY_SEPARATOR . Yii::app()->sourceLanguage), array('..', '.', '.svn'));
        if (mkdir($this->langsDir . DIRECTORY_SEPARATOR . $this->prefix)) {        
            foreach ($defaultFiles as $fname) {
                if ($fname != 'index.php') {
                    copy($this->langsDir . DIRECTORY_SEPARATOR . Yii::app()->sourceLanguage . DIRECTORY_SEPARATOR . $fname, $this->langsDir . DIRECTORY_SEPARATOR . $this->prefix . DIRECTORY_SEPARATOR . $fname);
                } else {
                    $content ='<?php 
                                    $__lang_name = "'.$this->name.'";
                                    $__lang_sn = "'.$this->prefix.'";
                              ?>';
                    fwrite(fopen($this->langsDir . DIRECTORY_SEPARATOR . $this->prefix . DIRECTORY_SEPARATOR . $fname, 'w'), $content);
                }
            }
            return true;
        } else {
            throw new CException('Cannot create diectory ' . $this->langsDir . DS . $this->prefix);
        }
    }
    
    public function update()
    {
        if (Yii::app()->sourceLanguage == $this->name) {
            throw new CException('Prefix of source language cannot be changed');
        }
        $content ='<?php 
                        $__lang_name = "'.$this->name.'";
                        $__lang_sn = "'.$this->prefix.'";
                  ?>';
        fwrite(fopen($this->dir . '/index.php', 'w'), $content);        
        if (rename($this->dir, $this->langsDir . DIRECTORY_SEPARATOR . $this->prefix)) {
            $this->_oldPrefix = $this->prefix;
            return true;
        }
        return false;
    }
    
    public function getOldPrefix()
    {
        return $this->_oldPrefix;
    }
    
    public function delete()
    {
        if (!$this->getIsNewRecord()) {
            if ($this->prefix == Yii::app()->sourceLanguage) {
                Yii::app()->user->setFlash('error', Yii::t('base', 'You cannot delete source language'));
                return false;
            }
            UtilsHelper::rmDir($this->dir);
        }
        else
            throw new CException(Yii::t('yii','The record cannot be deleted because it is new.'));
    }
    
    public function getFileContent($prefix)
    {
        if (file_exists($this->dir . DIRECTORY_SEPARATOR . 'base.php')) {
            $tmp = include ($this->dir . DIRECTORY_SEPARATOR . 'base.php');
        } else {
            return false;
        }
        return '<?php return ' . var_export($tmp, true) . ' ?>';
    }
}
