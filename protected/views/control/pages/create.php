<?php
/* @var $this PagesController */
/* @var $model Pages */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('control/index'),
	Yii::t('base', 'Manage Pages') => array('control/pages'),
	Yii::t('base', 'Create Page') => '',
);
?>

<h1><?=Yii::t('base', 'Create Page'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>