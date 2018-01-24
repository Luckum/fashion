<?php

class MenuImagesController extends AdminController
{
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$model->setScenario('update');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MainMenuImages']))
		{
			$model->attributes=$_POST['MainMenuImages'];

			if (!preg_match('/^https?:/i', $model->url1)) {
                $model->url1 = $model -> getRelativeUrl($model->url1);
            }

            if (!preg_match('/^https?:/i', $model->url2)) {
                $model->url2 = $model -> getRelativeUrl($model->url2);
            }

			$upload_path = Yii::getPathOfAlias('webroot') . ShopConst::HOME_BLOCK_IMAGE_MAX_DIR;

			$img = CUploadedFile::getInstance($model, 'image1');

			$oldName = isset($_POST['HomepageBlock']['oldImage1']) ? $_POST['HomepageBlock']['oldImage1'] : null;

			$model->image1 = $img ? ImageHelper::getUniqueValidName($upload_path, $img->getName()) : $oldName;

			$img2 = CUploadedFile::getInstance($model, 'image2');

			$oldName2 = isset($_POST['HomepageBlock']['oldImage2']) ? $_POST['HomepageBlock']['oldImage2'] : null;

			$model->image2 = $img2 ? ImageHelper::getUniqueValidName($upload_path, $img2->getName()) : $oldName2;

			if($model->block_type == MainMenuImages::ONE_IMAGE) {
				$model->image2 = NULL;
				$model->link2_type = NULL;
				$model->url2 = NULL;
			}

			if($model->save()) {
				if(isset($img)) {
					ImageHelper::cSaveHomeBlockImage($img, $model->image1);
				} else {
					ImageHelper::saveHomeBlockImage($model->image1);
				}

				if(isset($img2)) {
					ImageHelper::cSaveHomeBlockImage($img2, $model->image2);
				} else {
					ImageHelper::saveHomeBlockImage($model->image2);
				}

				$backParameters = HttpHelper::retrievePreviousGetParameters();
				$this->redirect(array('index'  . $backParameters));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'backParameters' => HttpHelper::retrievePreviousGetParameters()
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new MainMenuImages('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MainMenuImages']))
			$model->attributes=$_GET['MainMenuImages'];

		HttpHelper::saveGetParameters();

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MainMenuImages the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=MainMenuImages::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param MainMenuImages $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='main-menu-images-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
