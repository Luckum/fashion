<?php
/* @var $this SizeCategoriesController */
/* @var $model SizeChartCat */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Manage Size Categories') => array('control/sizes/' . $backParameters),
    $model->type.' '.$model->size => '',
);

?>
<h1><?=Yii::t('base', 'View Size'); ?> "<?php echo CHtml::encode($model->type.' '.$model->size); ?>"</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'type',
        'size',
        array('name' => 'size_chart_cat_id', 'value' => $model->sizeChartCat->name),
    ),
)); ?>

<div class="form-actions">
    <div class="offset2">
        <?php echo CHtml::link(Yii::t('base', 'Back'), array('/control/sizes/index' . $backParameters), array('class' => 'btn btn-primary')); ?>
        <?php echo CHtml::link(Yii::t('base', 'Edit'), array('/control/sizes/update', 'id' => $model->id), array('class' => 'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('base', 'Delete'), 'javascript:void(0)', array('class' => 'btn btn-danger', 'onclick' => "if(confirm('".Yii::t('base', 'Are you sure you want to delete this item?')."')) location.href='".Yii::app()->urlManager->createUrl('/control/sizes/delete', array('id' => $model->id))."';")); ?>
    </div>
</div>
