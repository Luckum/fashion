<?php
/* @var $this BrandsController */
/* @var $model Brand */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel') => array('control/index'),
    Yii::t('base', 'Manage Sizes') => array('control/sizes'),
    Yii::t('base', 'Create Size') => '',
);
?>
    <h1><?=Yii::t('base', 'Create Size'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>