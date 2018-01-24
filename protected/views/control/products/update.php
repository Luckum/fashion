<?php
/* @var $this ProductsController */
/* @var $model Product */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('control/index'),
	Yii::t('base', 'Manage Products') => array('control/products' . $backParameters),
	$model->title => array('control/products/view', 'id' => $model->id),
	Yii::t('base', 'Update Product') => '',
);

?>

<h1><?=Yii::t('base', 'Update Product');?> "<?php echo CHtml::encode($model->title); ?>"</h1>

<?php $this->renderPartial('_form', array(
	'model'=>$model,
	'invalidProd'=>$invalidProd,
	'backParameters' => $backParameters)); ?>