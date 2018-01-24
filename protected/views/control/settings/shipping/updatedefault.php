<?php
/* @var $this ShippingController */
/* @var $model ShippingRatedefault */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel') => array('control/index'),
    Yii::t('base', 'Shipping Settings') => array('control/settings/shipping'),
    Yii::t('base', 'Edit Default Rate For Seller Country') => ''
);

?>

<h1><?= Yii::t('base', 'Edit Default Seller Country Rate'); ?></h1>

<?php $this->renderPartial('_formdefault', array('model'=>$model)); ?>