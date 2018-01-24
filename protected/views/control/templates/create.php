<?php
/* @var $this TemplatesController */
/* @var $model Templates */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('control/index'),
	Yii::t('base', 'Manage Email Templates') => array('control/templates'),
	Yii::t('base', 'Create Email Template') => '',
);
?>

<h1><?=Yii::t('base', 'Create Email Template'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>