<?php
/* @var $this AttributesController */
/* @var $model Attribute */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Manage Attributes')=>array('index' . $backParameters),
	$model->alias => array('control/attributes/view', 'id' => $model->id),
    Yii::t('base', 'Update Attribute') => '',
);

?>

<h1><?=Yii::t('base', 'Update Attribute');?> "<?php echo CHtml::encode($model->alias); ?>"</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'backParameters' => $backParameters)); ?>