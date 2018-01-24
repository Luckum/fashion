<?php

class BlocksController extends AdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
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

		if(isset($_POST['HomepageBlock']))
		{
			$model->attributes=$_POST['HomepageBlock'];

            if (!preg_match('/^https?:/i', $model -> url)) {
                $model -> url = $model -> getRelativeUrl($model -> url);
            }

			$upload_path = Yii::getPathOfAlias('webroot') . ShopConst::HOME_BLOCK_IMAGE_MAX_DIR;

			$img = CUploadedFile::getInstance($model, 'image');

			$oldName = isset($_POST['HomepageBlock']['oldImage']) ? $_POST['HomepageBlock']['oldImage'] : null;

			$model->image = $img ? ImageHelper::getUniqueValidName($upload_path, $img->getName()) : $oldName;

			if($model->save()) {
				if(isset($img)) {
					ImageHelper::cSaveHomeBlockImage($img, $model->image);
				} else {
					ImageHelper::saveHomeBlockImage($model->image);
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
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new HomepageBlock('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['HomepageBlock']))
			$model->attributes=$_GET['HomepageBlock'];

		HttpHelper::saveGetParameters();

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return HomepageBlock the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=HomepageBlock::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param HomepageBlock $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='block-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionGetMaxOrder($parent_id, $new, $curr) {
		if($parent_id < 1) $parent_id = null;
		$max = Category::model()->getMaxOrder($parent_id);
		$output = '';
		if($new != 0) $max++;
		for($i = 0; $i <= ($max); $i++) {
			$output .= '<option value="' . $i . '"'.($i == $curr ? ' selected' : '').'>' . $i . '</option>';
		}
		echo $output;
		Yii::app()->end();
	}

	public function deleteImage($img){
		$imagePath=Yii::getPathOfAlias('webroot.images.upload.blocks').DIRECTORY_SEPARATOR.$img;
        if(is_file($imagePath) && HomepageBlock::model()->existImg($img) < 2)
            unlink($imagePath);
    }

    public function actionGetBrands() {
        $brands = Brand::getAllBrands();
 
        $this->renderPartial('_brand', $brands, false, true);
	}
}
