<?php

class BrandsController extends AdminController
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
		$model=new Brand;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Brand']))
		{
			$model->attributes=$_POST['Brand'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

        if (isset($_POST['Brand'])) {
			$model->attributes = $_POST['Brand'];
			if ($model->save()) {
                if (!empty($_POST['variant'])) {
                    $variant_id = $_POST['variant'];
                    Product::model()->updateAll(['brand_id' => $model->id], 'brand_id = ' . $variant_id);
                    $brand = Brand::model()->findByPk($variant_id);
                    Brand::model()->deleteAll('id = ' . $variant_id);
                    $variant = new BrandVariant();
                    $variant->name = $brand->name;
                    $variant->url = $brand->url;
                    $variant->brand_id = $model->id;
                    $variant->save();
                }
                if (!empty($_POST['variant_to'])) {
                    $brand_id = $_POST['variant_to'];
                    Product::model()->updateAll(['brand_id' => $brand_id], 'brand_id = ' . $model->id);
                    $brand = Brand::model()->findByPk($model->id);
                    Brand::model()->deleteAll('id = ' . $model->id);
                    $variant = new BrandVariant();
                    $variant->name = $brand->name;
                    $variant->url = $brand->url;
                    $variant->brand_id = $brand_id;
                    $variant->save();
                    $this->redirect(array('update', 'id' => $brand_id));
                }
            }
		}

		$this->render('update',array(
			'model'=>$model,
			'backParameters' => HttpHelper::retrievePreviousGetParameters()
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
	public function actionIndex()
	{
        $model=new Brand('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Brand']))
			$model->attributes=$_GET['Brand'];

		HttpHelper::saveGetParameters();

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Brand the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Brand::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Brand $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='brand-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionGenerateUrls()
	{
		$models = Brand::model()->findAll();
		foreach($models as $model) {
			if(empty($model->url)) {
				$model->generateUrl();
				$model->save();
			}
		}
	}
}
