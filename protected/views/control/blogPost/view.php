<?php
/* @var $this BlogPostController */
/* @var $model BlogPost */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Blog')=>array('control/blog'),
    Yii::t('base', 'Manage Blog Posts') => array('control/blogPost/' . $backParameters),
    CHtml::encode($model->title) => '',
);
?>

<h1><?= Yii::t('base', 'Blog Post'); ?> '<?= CHtml::encode($model->title); ?>'</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
        'short_description',
		array(
            'name' => 'content',
            'type' => 'raw',
        ),
		array(
            'name' => 'image',
            'type' => 'html',
            'value' => $model->thumbnailImageTag,
        ),
		'image_title',
		'seo_title',
        'seo_description',
		array(
            'name' => 'status',
            'value' => $model->getStatusName(),
        ),
        array(
            'name' => 'tags_field',
            'value' => $model->normalizedTags
        ),
        array(
            'name' => 'categories_field',
            'value' => $model->normalizedCategories
        ),
        array(
            'name' => 'allow_add_comments',
            'value' => $model->getAllowAddCommentsName(),
        ),
		array(
            'name' => 'create_time',
            'value' => date("Y-m-d", strtotime($model->create_time)),
        ),
        array(
            'name' => 'update_time',
            'value' => date("Y-m-d", strtotime($model->update_time)),
        ),
		'publish_at',
	),
)); ?>

<div class="form-actions">
    <p class="pull-left">
        <?php echo CHtml::link(Yii::t('base', 'Back'), array('/control/blogPost/index' . $backParameters), array('class' => 'mr100 btn btn-primary')); ?>
        <?php
            if (!$model->isPublished()) {
                echo CHtml::link(Yii::t('base', 'Publish'), array('/control/blogPost/changeStatus', 'id' => $model->id, 'status_id' => BlogPost::POST_STATUS_PUBLISHED), array('class' => 'btn btn-primary'));
            } else {
                echo CHtml::link(Yii::t('base', 'Save as a draft'), array('/control/blogPost/changeStatus', 'id' => $model->id, 'status_id' => BlogPost::POST_STATUS_DRAFTED), array('class' => 'btn btn-primary'));
            }
         ?>
        <?php echo CHtml::link(Yii::t('base', 'Edit'), array('/control/blogPost/update', 'id' => $model->id), array('class' => 'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('base', 'Delete'), 'javascript:void(0)', array('class' => 'btn btn-danger', 'onclick' => "if(confirm('" . Yii::t('base', 'Are you sure you want to delete this item?') . "')) location.href='".Yii::app()->urlManager->createUrl('/control/blogPost/delete', array('id' => $model->id))."';")); ?>
    </p>
</div>
