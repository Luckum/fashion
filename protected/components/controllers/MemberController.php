<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class MemberController extends Controller
{
    public $title;
    public $meta_description;
    public $meta_keywords;
    /**
    * List of pubic actions
    * 
    * @var mixed
    */
    public $publicActions = array(
        'login',
        'registration',
        'index',
        'showCategory',
        'productDetails',
        'addToBag',
        'removeFromBag',
        'sizeChart',
        'getSizeListForSubCat',
        'shipInfo',
        'forgotPassword',
        'ipn',
        'eternal'
    );
    
    public function beforeAction($action) {
        if(!Yii::app()->member->isGuest) return true;

        if(!in_array($action->id, $this->publicActions)) {
            if (Yii::app()->request->cookies->contains('return')) {
                unset(Yii::app()->request->cookies['return']);
            }

            if(Yii::app()->request->isAjaxRequest){
                $return = new CHttpCookie('return', Yii::app()->request->urlReferrer);
                $return->expire = time()+60*5; 
                Yii::app()->request->cookies['return'] = $return;

                Yii::app()->clientScript->registerScript('ajaxLoginRedirect', '
                    window.location.href = "'.Yii::app()->createAbsoluteUrl(Yii::app()->member->loginUrl[0]).'";
                ');
            } else {
                $return = new CHttpCookie('return', Yii::app()->createAbsoluteUrl(Yii::app()->controller->id.'/'.$action->id, $_POST));
                $return->expire = time()+60*5; 
                Yii::app()->request->cookies['return'] = $return;
                $this->redirect(Yii::app()->member->loginUrl);
            }
        }
        return true;
    }   
}
