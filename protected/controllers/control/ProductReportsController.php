<?php

class ProductReportsController extends AdminController
{
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $dataProvider = new CActiveDataProvider('ProductReport', array(
            'criteria'=>array(
                'order'=>'added_date DESC',
            )
        ));

        $this->render('index',array(
            'model'=>$dataProvider,
        ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Order the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ProductReport::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Order $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='order-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['save'])) {
            ProductReport::model()->updateAll(array(
                "comment" => $_POST['comment'],
            ), "id = :id", array(':id' => $id));
            $this->redirect(array('/control/productReports'));
        }   
        
        $this->render('update',array(
            'model' => $model,
        ));
    }

    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
        
        $this->redirect(array('/control/productReports'));
    }
}