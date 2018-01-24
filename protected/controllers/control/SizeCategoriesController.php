<?php

class SizeCategoriesController extends AdminController
{
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => SizeChartCat::model()->findByPk($id),
            'backParameters' => HttpHelper::retrievePreviousGetParameters()
        ));
    }

    public function actionCreate()
    {
        $model = new SizeChartCat;

        if(isset($_POST['SizeChartCat']))
        {
            $model->attributes=$_POST['SizeChartCat'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['SizeChartCat']))
        {
            $model->attributes=$_POST['SizeChartCat'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }

        $this->render('update',array(
            'model'=>$model,
            'backParameters' => HttpHelper::retrievePreviousGetParameters()
        ));
    }

    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function actionIndex()
    {
        $model=new SizeChartCat('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['SizeChartCat'])) {
            $model->attributes=$_GET['SizeChartCat'];
        }

        HttpHelper::saveGetParameters();

        $this->render('index',array(
            'model'=>$model,
        ));
    }

    public function loadModel($id)
    {
        $model=SizeChartCat::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}