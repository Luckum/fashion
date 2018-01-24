<?php
/* @var $this BlogCategoryController */
/* @var $model BlogCategory */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Blog')=>array('control/blog'),
    Yii::t('base', 'Manage Blog Categories') => array('control/blogCategory/' . $backParameters),
    Yii::t('base', 'Create Blog Category') => '',
);

?>

<h1><?=Yii::t('base', 'Create Blog Categories'); ?></h1>

<?php $this->renderPartial('_form_multi', array('model'=>$model)); ?>