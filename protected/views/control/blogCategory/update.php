<?php
/* @var $this BlogCategoryController */
/* @var $model BlogCategory */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Blog')=>array('control/blog'),
    Yii::t('base', 'Manage Blog Categories') => array('control/blogCategory/' . $backParameters),
    Yii::t('base', 'Update Blog Category') => '',
);

?>

<h1><?=Yii::t('base', 'Update Blog Category'); ?> <?php echo CHtml::encode($model->name); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'backParameters' => $backParameters)); ?>