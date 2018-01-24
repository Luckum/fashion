<?php
/* @var $this BlocksController */
/* @var $model HomepageBlock */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Manage Homepage Block') => array('control/blocks' . $backParameters),
	$model->getContentByLanguage()->title => '',
);

?>

<h1><?=Yii::t('base', 'View Homepage Block');?> "<?php echo CHtml::encode($model->getContentByLanguage()->title); ?>"</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'label' => Yii::t('base', 'Title'),
			'value' => $model->getContentByLanguage()->title,
		),
		'image',
		'link_type',
		'url',
		array(
			'label' => Yii::t('base', 'Visible?'),
			'value' => ($model->visible == 1) ? 'yes' : 'no',
		),

	),
)); ?>

<div class="form-actions">
    <div class="offset2">
        <?php echo CHtml::link(Yii::t('base', 'Back'), array('/control/blocks/index' . $backParameters), array('class' => 'btn btn-primary')); ?>
        <?php echo CHtml::link(Yii::t('base', 'Edit'), array('/control/blocks/update', 'id' => $model->id), array('class' => 'btn btn-success')); ?>
    </div>
</div>
