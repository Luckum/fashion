<?php
/* @var $this SizeCategoriesController */
/* @var $model SizeChartCat */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Manage Size Categories') => array('control/sizeCategories/' . $backParameters),
    $model->name => '',
);

?>
<h1><?=Yii::t('base', 'View Size Category'); ?> "<?php echo CHtml::encode($model->name); ?>"</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        array('name' => 'top_category', 'value' => $model->topCategory->alias),
        'name',
    ),
)); ?>

<div class="form-actions">
    <div class="offset2">
        <?php echo CHtml::link(Yii::t('base', 'Back'), array('/control/sizeCategories/index' . $backParameters), array('class' => 'btn btn-primary')); ?>
        <?php echo CHtml::link(Yii::t('base', 'Edit'), array('/control/sizeCategories/update', 'id' => $model->id), array('class' => 'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('base', 'View sizes for this category'), array('/control/sizes/index', 'SizeChart[size_chart_cat_id]' => $model->id), array('class' => 'btn btn-primary')); ?>
        <?php echo CHtml::link(Yii::t('base', 'Delete'), 'javascript:void(0)', array('class' => 'btn btn-danger', 'onclick' => "if(confirm('".Yii::t('base', 'Are you sure you want to delete this item?')."')) location.href='".Yii::app()->urlManager->createUrl('/control/sizeCategories/delete', array('id' => $model->id))."';")); ?>
    </div>
</div>
