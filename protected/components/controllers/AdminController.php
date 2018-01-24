<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class AdminController extends Controller
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout='//layouts/admin';
    /**
    * List of pubic actions
    * 
    * @var mixed
    */
    public $publicActions = array('login');
    
    public function beforeAction($action) {
        $cs = Yii::app()->clientScript;
        $baseUrl = Yii::app()->baseUrl; 
        $cs->registerCssFile($baseUrl . '/css/admin.css');

        if(!Yii::app()->admin->isGuest) return true;
        if(!in_array($action->id, $this->publicActions)) $this->redirect(Yii::app()->admin->loginUrl);
        return true;
    }
}
