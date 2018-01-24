<?php
/* @var $this UsersController */
/* @var $model User */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel') => array('control/index'),
    Yii::t('base', 'Manage Users') => array('control/users'),
    Yii::t('base', 'Create User') => ''
);

?>

<h1><?= Yii::t('base', 'Create User'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'sellerModel' => $sellerModel)); ?>