<?php
/* @var $this ProductsController */
/* @var $model Product */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('control/index'),
	Yii::t('base', 'Manage Products') => array('control/products'),
	Yii::t('base', 'Create Product') => '',
);
?>

<h1><?=Yii::t('base', 'Create Product'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>