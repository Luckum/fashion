<?php

class LanguagesController extends AdminController
{
    public function actionIndex()
    {
        $this->render('index', array(
            'dataProvider' => Language::getListForTableview()
        ));
    }
    
    public function actionCreate()
    {
        $model = new Language();
        if (Yii::app()->request->isPostRequest && !empty($_POST['Language'])) {       
            $model->setAttributes($_POST['Language']);     
            if ($model->validate()) {
                if ($model->save()) {
                    $this->redirect(array('/control/settings/languages'));
                }    
            }
        }    
        $this->render('create', array(
            'model' => $model,
        ));
    }
    
    public function actionUpdate()
    {
        $model = $this->loadModel();
        if (Yii::app()->request->isPostRequest && !empty($_POST['Language'])) {
            $model->setAttributes($_POST['Language']);
            if ($model->validate()) {
                if ($model->save()) {
                    $this->redirect(array('/control/settings/languages'));
                }
            }
        }
        $this->render('update',array(
            'model' => $model,
        ));
    }
    
    public function loadModel()
    {
        if (isset($_GET['prefix']) && !empty($_GET['prefix'])) {
            $model= new Language($_GET['prefix']);
        } else {
            throw new CHttpException(404, 'Language Prefix is not defined.');
        }
        return $model;
    }
    
    public function actionDelete()
    {
        if (Yii::app()->request->isPostRequest && isset($_GET['prefix']) && $_GET['prefix'] != Yii::app()->sourceLanguage) {
            $this->loadModel()->delete();

            if (!isset($_GET['ajax']))
                $this->redirect(array('/control/settings/languages'));
        }
        else
            throw new CHttpException(400,'You can not delete the base language of the system');
    }
    
    public function actionExport()
    {
        $model = $this->loadModel();
        $fileContent = $model->getFileContent($model->prefix);
        if ($fileContent) {
            Yii::app()->request->sendFile($model->prefix . '_' . date("Y-m-d") . '.php', $fileContent);
        } else {
            throw new CHttpException(404, 'File is not exist.');
        }
    }
    
    public function actionImport()
    {
        $formModel = new LanguageImportForm();
        
        if (isset($_POST['LanguageImportForm'])) {
            $formModel->file = CUploadedFile::getInstance($formModel, 'file');
            $model = $this->loadModel();
            if ($formModel->validate()) {
                $formModel->file->saveAs($model->dir . DIRECTORY_SEPARATOR . 'base.php');
                $this->redirect(array('/control/settings/languages'));
            }
        }
        $this->renderPartial('_import', array(
            'formModel' => $formModel,
        ), false, true);
    }
}