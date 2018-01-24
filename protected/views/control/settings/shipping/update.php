<?php
/* @var $this ShippingController */
/* @var $model ShippingRate */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel') => array('control/index'),
    Yii::t('base', 'Shipping Settings') => array($backUrl ? $backUrl : 'control/settings/shipping'),
    Yii::t('base', 'Edit Rate For Country') => ''
);

?>

<h1><?= Yii::t('base', 'Edit Country Rate'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'backUrl' => $backUrl)); ?>