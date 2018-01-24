<?php

class BlogPostController extends AdminController
{
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'backParameters' => HttpHelper::retrievePreviousGetParameters()
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$_SESSION['KCFINDER']['disabled'] = false; // enables the file browser in the admin
        $_SESSION['KCFINDER']['uploadURL'] = Yii::app()->baseUrl . "/images/blog/uploads/"; // URL for the uploads folder
        $_SESSION['KCFINDER']['uploadDir'] = Yii::getpathOfAlias('webroot') . "/images/blog/uploads/"; // path to the uploads folder

		$model=new BlogPost;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['BlogPost']))
		{
			$model->attributes=$_POST['BlogPost'];
			$model->tags = BlogTag::getIdsFromNames($_POST['BlogPost']['tags']);
			$model->categories = $_POST['BlogPost']['categories'];
			//getting image
			$upload_path = Yii::getPathOfAlias('webroot') . ShopConst::BLOG_IMAGE_MAX_DIR;
			$img = CUploadedFile::getInstance($model, 'image');
			$oldName = isset($_POST['BlogPost']['oldImage']) ? $_POST['BlogPost']['oldImage'] : null;
			$model->image = $img ? ImageHelper::getUniqueValidName($upload_path, $img->getName()) : $oldName;

			if($model->save()) {
				if(isset($img)) {
					ImageHelper::cSaveBlogImage($img, $model->image);
				} else {
					ImageHelper::saveBlogImage($model->image);
				}

				$this->redirect(array('view','id'=>$model->id));
			} else {
				$model->image = $oldName;
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$_SESSION['KCFINDER']['disabled'] = false; // enables the file browser in the admin
        $_SESSION['KCFINDER']['uploadURL'] = Yii::app()->baseUrl . "/images/blog/uploads/"; // URL for the uploads folder
        $_SESSION['KCFINDER']['uploadDir'] = Yii::getpathOfAlias('webroot') . "/images/blog/uploads/"; // path to the uploads folder

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['BlogPost']))
		{
			$model->attributes=$_POST['BlogPost'];
			$model->tags = BlogTag::getIdsFromNames($_POST['BlogPost']['tags']);
			$model->categories = $_POST['BlogPost']['categories'];

			//getting image
			$upload_path = Yii::getPathOfAlias('webroot') . ShopConst::BLOG_IMAGE_MAX_DIR;
			$img = CUploadedFile::getInstance($model, 'image');
			$oldName = isset($_POST['BlogPost']['oldImage']) ? $_POST['BlogPost']['oldImage'] : null;
			$model->image = $img ? ImageHelper::getUniqueValidName($upload_path, $img->getName()) : $oldName;

			if($model->save()) {
				if(isset($img)) {
					ImageHelper::cSaveBlogImage($img, $model->image);
				} else {
					ImageHelper::saveBlogImage($model->image);
				}
				$this->redirect(array('view','id'=>$model->id));
			} else {
				$model->image = $oldName;
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'backParameters' => HttpHelper::retrievePreviousGetParameters()
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new BlogPost('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['BlogPost']))
			$model->attributes=$_GET['BlogPost'];

		HttpHelper::saveGetParameters();

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * @param integer $id the ID of the model
	 * @param integer $status_id status
	 */
	public function actionChangeStatus($id, $status_id)
	{
		$nowDate = date('Y-m-d H:i:s');
		$updateParams = array(
		    'status' => intval($status_id),
		    'update_time' => $nowDate
		);
		if ($status_id == BlogPost::POST_STATUS_PUBLISHED) {
			$updateParams['create_time'] = $nowDate;
		}
		BlogPost::model()->updateByPk($id, $updateParams);
		$this->redirect(array('index'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return BlogPost the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=BlogPost::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param BlogPost $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='blog-post-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
