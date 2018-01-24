<?php
/* @var $this BrandsController */
/* @var $model Brand */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel') => array('control/index'),
    Yii::t('base', 'Manage Size Categories') => array('control/sizeCategories'),
    Yii::t('base', 'Create Size Category') => '',
);
?>
    <h1><?=Yii::t('base', 'Create Size Category'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>