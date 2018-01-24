<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    
    private $_pageTitle;
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/client_layout';
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    public function init()
    {    
        if (empty($_GET['language']))
            $_GET['language'] = 'en';
 
        Yii::app()->language = $_GET['language'];
        parent::init();
    }

    /**
    * List of pubic actions
    * 
    * @var mixed
    */
    public function getPageTitle() {
        
        if($this->_pageTitle!==null)
            return $this->_pageTitle;
        else {
            if(count($this->breadcrumbs) > 0) {
                $steps = array_keys($this->breadcrumbs);
                return $this->_pageTitle=Yii::app()->name.' - '.implode(' / ', $steps);
            }
            else 
                return parent::getPageTitle();
        }
    }
}
