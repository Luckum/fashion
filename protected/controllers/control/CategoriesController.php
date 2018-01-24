<?php

class CategoriesController extends AdminController
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Category;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Category']))
		{
			$model->attributes=$_POST['Category'];
			$model->menu_order = $model->getMaxOrder($_POST['Category']['parent_id']) + 1;
			$model->alias = $_POST['Category']['alias'];
			$model->external_sale = $_POST['Category']['external_sale'];
			$model->size_chart_cat_id = $_POST['Category']['size_chart_cat_id'];
			if($model->save()) {
				$this->redirect(array('view','id'=>$model->id));
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Category']))
		{
			$model->attributes=$_POST['Category'];
			$model->alias = $_POST['Category']['alias'];
			$model->size_chart_cat_id=$_POST['Category']['size_chart_cat_id'];
			if($model->save()) {
				$this->redirect(array('view','id'=>$model->id));
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
		Product::model()->deleteAll("category_id ='" . $id . "'");

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new Category('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Category']))
			$model->attributes=$_GET['Category'];

		HttpHelper::saveGetParameters();

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Category the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Category::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Category $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='category-form')
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

	public function actionMoveOrder() {
		if(!Yii::app()->request->isAjaxRequest) throw new CHttpException('Url should be requested via ajax only');

        $model=new Category('search');
        $model->unsetAttributes();

        if (isset($_REQUEST['Category'])) {
            $model->attributes = $_REQUEST['Category'];
        }

		if (!isset($_GET['id']) || !isset($_GET['move'])) {
			$this->renderPartial('index',array(
				'model'=>$model,
			));
			Yii::app()->end();
		}
		if (!Category::changeCatOrder($_GET['id'], $_GET['move'])) {
			$error_str = 'You can not move '.$_GET['move'].' this category';
		} else {
			$error_str = '';
		}
		
//		$this->renderPartial('index',array(
//			'model'=>$model,
//			'error' => $error_str,
//		));
//		Yii::app()->end();

		$backParameters = HttpHelper::retrievePreviousGetParameters();

		$this->redirect('/control/categories/index' . $backParameters);
	}
}
