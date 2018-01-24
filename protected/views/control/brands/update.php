<?php
/* @var $this BrandsController */
/* @var $model Brand */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('control/index'),
	Yii::t('base', 'Manage Brands') => array('control/brands/' . $backParameters),
	$model->name => array('view','id'=>$model->id),
	Yii::t('base', 'Update Brand') => '',
);

?>

<h1><?=Yii::t('base', 'Update Brand'); ?> "<?php echo CHtml::encode($model->name); ?>"</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'backParameters' => $backParameters)); ?>