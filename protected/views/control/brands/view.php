<?php
/* @var $this BrandsController */
/* @var $model Brand */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Manage Brands') => array('control/brands/' . $backParameters),
	$model->name => '',
);

?>
<h1><?=Yii::t('base', 'View Brand'); ?> "<?php echo CHtml::encode($model->name); ?>"</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>

<div class="form-actions">
    <div class="offset2">
        <?php echo CHtml::link(Yii::t('base', 'Back'), array('/control/brands/index' . $backParameters), array('class' => 'btn btn-primary')); ?>
        <?php echo CHtml::link(Yii::t('base', 'Edit'), array('/control/brands/update', 'id' => $model->id), array('class' => 'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('base', 'View products for this brand'), array('/control/products/index', 'brandid' => $model->id), array('class' => 'btn')); ?>
        <?php echo CHtml::link(Yii::t('base', 'Delete'), 'javascript:void(0)', array('class' => 'btn btn-danger', 'onclick' => "if(confirm('".Yii::t('base', 'Are you sure you want to delete this item?')."')) location.href='".Yii::app()->urlManager->createUrl('/control/brands/delete', array('id' => $model->id))."';")); ?>
    </div>
</div>
