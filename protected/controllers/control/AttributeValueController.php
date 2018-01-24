<?php

class AttributeValueController extends AdminController
{
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new AttributeValue;
        
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AttributeValue']))
		{
			$allValidated = true;
			foreach ($_POST['AttributeValue'] as $attrValue) {
				if (empty($attrValue['value'])) continue;
				$model = new AttributeValue;
				$model->attributes = $attrValue;
				$allValidated = ($model->validate() && $allValidated);
				if (!$allValidated) {
					break;
				}
			}

			if ($allValidated) {
				foreach ($_POST['AttributeValue'] as $attrValue) {
					$model = new AttributeValue;
					$model->attributes = $attrValue;
					$model->save();
				}
				$this->redirect(array('index'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex($categoryid = null)
	{
		$model=new AttributeValue('search');
		$model->unsetAttributes();  // clear any default values
        
		if(isset($_GET['AttributeValue']))
			$model->attributes=$_GET['AttributeValue'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Attribute the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AttributeValue::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Attribute $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='attribute-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
