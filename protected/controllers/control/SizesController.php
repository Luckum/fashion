<?php

class SizesController extends AdminController
{
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => SizeChart::model()->findByPk($id),
            'backParameters' => HttpHelper::retrievePreviousGetParameters()
        ));
    }

    public function actionCreate()
    {
        $model = new SizeChart;

        if(isset($_POST['SizeChart']))
        {
            $model->attributes=$_POST['SizeChart'];
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

        if(isset($_POST['SizeChart']))
        {
            $model->attributes=$_POST['SizeChart'];
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
        $model=new SizeChart('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['SizeChart'])) {
            $model->attributes=$_GET['SizeChart'];
        }

        HttpHelper::saveGetParameters();

        $this->render('index',array(
            'model'=>$model,
        ));
    }

    public function loadModel($id)
    {
        $model=SizeChart::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}