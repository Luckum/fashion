<?php
/* @var $this BlogCommentController */
/* @var $model BlogComment */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Blog')=>array('control/blog'),
    Yii::t('base', 'Manage Blog Comments') => array('control/blogComment/' . $backParameters),
    Yii::t('base', 'View Blog Comment') => '',
);
?>

<h1><?=Yii::t('base', 'View Blog Comment'); ?> #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'content',
		//'status',
		'create_time',
		'update_time',
		'author.username',
		'post.title',
        array(
            'name' => 'status',
            'value' => $model->statusName
        )
	),
)); ?>

<div class="form-actions">
    <p class="pull-left">
        <?php echo CHtml::link(Yii::t('base', 'Back'), array('/control/blogComment/index' . $backParameters), array('class' => 'mr100 btn btn-primary')); ?>
        <?php echo CHtml::link(Yii::t('base', 'Edit'), array('/control/blogComment/update', 'id' => $model->id), array('class' => 'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('base', 'Delete'), 'javascript:void(0)', array('class' => 'btn btn-danger', 'onclick' => "if(confirm('" . Yii::t('base', 'Are you sure you want to delete this item?') . "')) location.href='".Yii::app()->urlManager->createUrl('/control/blogComment/delete', array('id' => $model->id))."';")); ?>
    </p>
</div>
