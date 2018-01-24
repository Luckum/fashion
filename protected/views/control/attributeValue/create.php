<?php
/* @var $this AttributeValueController */
/* @var $model AttributeValue */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Manage Attributes') => array('control/attributes'),
    Yii::t('base', 'Attribute defined values') => array('control/attributeValue'),
    Yii::t('base', 'Add defined attribute value(s) for dropdown lists and checkbox list')
);

?>

<h1><?php echo Yii::t('base', 'Add defined attribute value(s) for dropdown lists and checkbox list'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>