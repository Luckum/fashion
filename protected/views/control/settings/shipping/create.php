<?php
/* @var $this ShippingController */
/* @var $model ShippingRate */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel') => array('control/index'),
    Yii::t('base', 'Shipping Settings') => array('control/settings/shipping'),
    Yii::t('base', 'Create Rate For Country') => ''
);

?>

<h1><?= Yii::t('base', 'Create Country Rate'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>