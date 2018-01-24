<?php
/* @var $this BlogTagController */
/* @var $model BlogTag */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Blog')=>array('control/blog'),
    Yii::t('base', 'Manage Blog Tags') => array('control/blogTag/' . $backParameters),
    Yii::t('base', 'Update Blog Tag') => '',
);

?>

<h1><?=Yii::t('base', 'Update Blog Tag'); ?> <?php echo CHtml::encode($model->name); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'backParameters' => $backParameters)); ?>