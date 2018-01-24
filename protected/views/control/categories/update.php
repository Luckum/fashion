<?php
/* @var $this CategoriesController */
/* @var $model Category */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('control/index'),
	Yii::t('base', 'Manage Categories') => array('control/categories' . $backParameters),
	$model->alias => array('control/categories/view', 'id' => $model->id),
	Yii::t('base', 'Update Category') => '',
);

?>

<h1><?=Yii::t('base', 'Update Category');?> "<?php echo CHtml::encode($model->alias); ?>"</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'backParameters' => $backParameters)); ?>
