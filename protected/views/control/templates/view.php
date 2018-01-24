<?php
/* @var $this TemplatesController */
/* @var $model Template */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Manage Email Templates') => array('control/templates' . $backParameters),
	$model->alias => '',
);

?>

<h1><?=Yii::t('base', 'View Email Template');?> "<?php echo CHtml::encode($model->alias); ?>"</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'alias',
		'subject',
		'language',
	),
)); ?>

<div class="form-actions">
    <div class="offset2">
        <?php echo CHtml::link(Yii::t('base', 'Back'), array('/control/templates/index' . $backParameters), array('class' => 'btn btn-primary')); ?>
        <?php echo CHtml::link(Yii::t('base', 'Edit'), array('/control/templates/update', 'id' => $model->id), array('class' => 'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('base', 'Delete'), 'javascript:void(0)', array('class' => 'btn btn-danger', 'onclick' => "if(confirm('" . Yii::t('base', 'Are you sure you want to delete this item?') . "')) location.href='".Yii::app()->urlManager->createUrl('/control/templates/delete', array('id' => $model->id))."';")); ?>
    </div>
</div>