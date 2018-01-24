<?php
/* @var $this CategoriesController */
/* @var $model Category */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Manage Products') => array('control/products'),
	$model->title => '',
);

?>

<h1><?=Yii::t('base', 'View Product');?> "<?php echo $model->title; ?>"</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		array(
			'name' => 'category_id', 
			'value' => $model->category->getNameByLanguage()->name
		),
		array(
			'label' => Yii::t('base', 'Sub Category'), 
			'value' => $model->category->parent ? $model->category->parent->getNameByLanguage()->name : "Not set"
		),
		array(
			'label' => Yii::t('base', 'Attributes'),
			'type'=>'raw',
			'value' => $model->attributes() ? $model->attributes() : "Not set"
		),
		array(
			'name' => 'size_type',
			'value' => $model->size_chart->size . ' (' . $model->size_chart->type . ')'
		),
		array(
			'name' => 'brand_id', 
			'value' => $model->brand->name
		),
		array(
			'name' => 'condition', 
			'value' => $model->getConditionsName()
		),
		array(
			'name' => 'user_id', 
			'value' => $model->user->username
		),
		array(
			'name' => 'status',
			'value' => $model->getStatusName(),
		),
		'added_date',
	),
)); ?>

<div class="form-actions">
    <div class="offset2">
    	<?php echo CHtml::link(Yii::t('base', 'Back'), $this->createAbsoluteUrl('/control/products/index'), array('class' => 'btn btn-primary')); ?>
        <?php echo CHtml::link(Yii::t('base', 'Edit'), $this->createAbsoluteUrl('/control/products/update', array('id' => $model->id)), array('class' => 'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('base', 'Delete'), 'javascript:void(0)', array('class' => 'btn btn-danger', 'onclick' => "if(confirm('" . Yii::t('base', 'Are you sure you want to delete this item?') . "')) location.href='".Yii::app()->urlManager->createUrl('/control/products/delete', array('id' => $model->id))."';")); ?>
    </div>
</div>
