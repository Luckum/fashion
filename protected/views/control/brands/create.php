<?php
/* @var $this BrandsController */
/* @var $model Brand */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel') => array('control/index'),
	Yii::t('base', 'Manage Brands') => array('control/brands'),
	Yii::t('base', 'Create Brand') => '',
);
?>
<h1><?=Yii::t('base', 'Create Brand'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>