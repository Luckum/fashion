<?php
/* @var $this CategoriesController */
/* @var $model Category */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Manage Categories') => array('control/categories' . $backParameters),
	$model->alias => '',
);

?>

<h1><?=Yii::t('base', 'View Category');?> "<?php echo CHtml::encode($model->alias); ?>"</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'parent.alias:text:' . Yii::t('base', 'Parent Category'),
		'alias',
		array(
			'label' => Yii::t('base', 'Status'),
			'value' => $model->getStatusName(),
		),
		'menu_order',
	),
)); ?>

<div class="form-actions">
    <div class="offset2">
        <?php echo CHtml::link(Yii::t('base', 'Back'), array('/control/categories/index' . $backParameters), array('class' => 'btn btn-primary')); ?>
        <?php echo CHtml::link(Yii::t('base', 'Edit'), array('/control/categories/update', 'id' => $model->id), array('class' => 'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('base', 'View products for this category'), array('/control/products/index', 'categoryid' => $model->id), array('class' => 'btn')); ?>
        <?php echo CHtml::link(Yii::t('base', 'View attributes for this category'), array('/control/attributes/index', 'categoryid' => $model->id), array('class' => 'btn btn-warning')); ?>
        <?php echo CHtml::link(Yii::t('base', 'Delete'), 'javascript:void(0)', array('class' => 'btn btn-danger', 'onclick' => "if(confirm('" . Yii::t('base', 'Are you sure you want to delete this item?') . "')) location.href='".Yii::app()->urlManager->createUrl('/control/categories/delete', array('id' => $model->id))."';")); ?>
    </div>
</div>
