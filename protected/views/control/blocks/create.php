<?php
/* @var $this BlocksController */
/* @var $model HomepageBlock */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('control/index'),
	Yii::t('base', 'Manage Homepage Block') => array('control/blocks'),
	Yii::t('base', 'Create Homepage Block') => '',
);
?>

<h1><?=Yii::t('base', 'Create Homepage Block'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>