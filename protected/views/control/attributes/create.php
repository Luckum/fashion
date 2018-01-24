<?php
/* @var $this AttributesController */
/* @var $model Attribute */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
	Yii::t('base', 'Manage Attributes')=>array('index'),
	Yii::t('base', 'Create Attribute') => '',
);
?>

<h1><?=Yii::t('base', 'Create Attribute');?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'isCreateMode' => true)); ?>