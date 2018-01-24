<?php

class AdminsController extends AdminController
{
    public $adminsActive = true;
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

    public function actionChangePassword($id) {
        $model = $this->loadModel($id);

        $self = ($id == Yii::app()->admin->id);

        $saved = false;
        if(isset($_POST) && count($_POST)>0) {

            if($self) {
                if($model->password!==sha1($_POST['existing_password'])) {
                    $model->addError('password', Yii::t('base', 'Your existing password was not correct'));
                }
            }
            if($_POST['new_password']=='') {
                $model->addError('password', Yii::t('base', 'You did not enter a password'));
            }
            if($_POST['new_password'] != $_POST['new_password2']) {
                $model->addError('password', Yii::t('base', 'The passwords you entered did not match'));
            }
            if(!$model->hasErrors()) {
                $model->setAttributes(array('password' => sha1($_POST['new_password'])));
                if($model->save()) {
                    $saved = true;
                }
            }
        }

        $this->render('changePassword', array('model' => $model, 'saved' => $saved, 'self' => $self));
    }

    public function actionChangeEmail($id) {
        $model = $this->loadModel($id);

        $self = ($id == Yii::app()->admin->id);

        $saved = false;
        if(isset($_POST) && count($_POST)>0) {

            if($_POST['email']=='') {
                $model->addError('email', Yii::t('base', 'You did not enter an email'));
            }
            if(!$model->hasErrors()) {
                $model->setAttributes(array('email' => $_POST['email']));
                if($model->save()) {
                    $saved = true;
                }
            }
        }

        $this->render('changeEmail', array('model' => $model, 'saved' => $saved, 'self' => $self));
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Users the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Admin::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,Yii::t('base', 'The requested page does not exist.'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Users $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='admins-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
