<?php
/* @var $this CategoriesController */
/* @var $model Category */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('control/index'),
	Yii::t('base', 'Manage Categories') => array('control/categories'),
	Yii::t('base', 'Create Category') => '',
);
?>

<h1><?=Yii::t('base', 'Create Category'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>