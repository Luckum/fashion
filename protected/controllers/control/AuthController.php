<?php

class AuthController extends AdminController
{
    public function actionLogin()
    {
        if(!Yii::app()->admin->isGuest) {
            $this->redirect('/control/index');
        }
        $model=new LoginForm('adminlogin');

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->adminLogin()) {
                $this->redirect(Yii::app()->admin->returnUrl);                
            }
        }
        // display the login form
        $this->render('login',array('model'=>$model));
    }
    
    public function actionAccessError() {
        $this->render('accessError');
    }

    public function actionLogout()
    {
        Yii::app()->admin->logout(false);
        $this->redirect('');
    }

}