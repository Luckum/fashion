<?php

class ShippingController extends AdminController
{
    public function actionIndex()
    {
        $data = Yii::app()->params->shipping;

        $model = new ShippingRate('search');
        $model -> unsetAttributes();  // clear any default values

        if (isset($_GET['ShippingRate'])) {
            $model -> attributes = $_GET['ShippingRate'];
        }

        $defaultModel = new ShippingRateDefault('search');
        $defaultModel -> unsetAttributes();  // clear any default values

        if (isset($_GET['ShippingRateDefault'])) {
            $defaultModel -> attributes = $_GET['ShippingRateDefault'];
        }

        if (isset($_POST['save'])) {
            $default_rate = $_POST['default_rate'];
            UtilsHelper::addParams('shipping', 'default_rate', $default_rate);
            $data['default_rate'] = $default_rate;
        }

        HttpHelper::saveUrl();

        $this->render('index',array(
            'data' => $data,
            'model' => $model,
            'defaultModel' => $defaultModel,
        ));
    }
    
    public function actionCreate()
    {
        $model = new ShippingRate;

        if (isset($_POST['ShippingRate'])) {
            foreach($_POST['ShippingRate']['buyer_country_id'] as $buyerCountryId) {
                $model = new ShippingRate;
                $model->attributes = $_POST['ShippingRate'];
                $model->buyer_country_id = $buyerCountryId;
                $model->save();
            }
                $this->redirect(array('/control/settings/shipping/'));
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }
    
    public function actionUpdate($id)
    {
        $backUrl = HttpHelper::retrievePreviousUrl();

        $model = $this->loadModel($id);
        
        if (isset($_POST['ShippingRate'])) {
            $model->attributes = $_POST['ShippingRate'];
            if (!empty($_POST['ShippingRate']['buyer_country_id']) && is_array($_POST['ShippingRate']['buyer_country_id'])) {
                $model->buyer_country_id = array_shift($_POST['ShippingRate']['buyer_country_id']);
            }
            if ($model->save()) {
                $this->redirect(array($backUrl ? $backUrl : '/control/settings/shipping/'));
            }
        }
        
        $this->render('update',array(
            'model'=>$model,
            'backUrl' => $backUrl
        ));
    }
    
    public function loadModel($id)
    {
        $model = ShippingRate::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
    
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('settings/shipping'));
    }
    
    public function actionCreatedefault()
    {
        $model = new ShippingRateDefault();
        
        if (isset($_POST['ShippingRateDefault'])) {
            $model->attributes = $_POST['ShippingRateDefault'];
            if ($model->save()) {
                $this->redirect(array('/control/settings/shipping/'));
            }
        }

        $this->render('createdefault',array(
            'model'=>$model,
        ));
    }
    
    public function actionUpdatedefault($id)
    {
        $model = $this->loadDefaultModel($id);
        
        if (isset($_POST['ShippingRateDefault'])) {
            $model->attributes = $_POST['ShippingRateDefault'];
            if ($model->save()) {
                $this->redirect(array('/control/settings/shipping/'));
            }
        }
        
        $this->render('updatedefault',array(
            'model'=>$model,
        ));
    }
    
    public function loadDefaultModel($id)
    {
        $model = ShippingRateDefault::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
    
    public function actionDeletedefault($id)
    {
        $this->loadDefaultModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('control/settings/shipping'));
    }
}