<?php
/* @var $this BlogPostController */
/* @var $model BlogPost */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Blog')=>array('control/blog'),
    Yii::t('base', 'Manage Blog Posts') => array('control/blogPost'),
);
?>

<h1><?=Yii::t('base', 'Manage Blog Posts');?></h1>

<div class="text-right">
    <?php echo CHtml::link(Yii::t('base', 'Create New Blog Post'), array('/control/blogPost/create'), array('class' => 'btn btn-primary')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'tag-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'enableHistory' => true,
    'selectionChanged' => "function(id){window.location='" . Yii::app()->createUrl('control/blogPost/view', array('id'=>'')) . "' + $.fn.yiiGridView.getSelection(id);}",
    'htmlOptions' => array('style' => 'cursor: pointer;'),
    'columns'=>array(
        'title',
        'short_description',
        array(
            'name' => 'image',
            'filter' => false,
            'type' => 'html',
            'value'=> '$data->thumbnailImageTag',
        ),
        //TODO Add filters!

        // array(
        //     'name' => 'tags_field',
        //     'filter' => false,
        //     'value' => '$data->normalizedTags'
        // ),
        array(
            'name' => 'status',
            'value' => '$data->getStatusName()',
            'filter' => BlogPost::model()->getStatuses()
        ),
        array(
            'name' => 'create_time',
            'value' => 'date("Y-m-d", strtotime($data->create_time))'
        ),
        array(
            'name' => 'update_time',
            'value' => 'date("Y-m-d", strtotime($data->update_time))'
        ),
        array(
            'name' => 'allow_add_comments',
            'value' => '$data->getAllowAddCommentsName()',
            'filter' => BlogPost::model()->getAllowAddCommentsVariants()
        ),
        array(
            'name' => 'publish_at',
            'value' => '(strpos($data->publish_at, "0000-") !== false) ? "" : $data->publish_at'
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{view} {update} {comments} {delete}',
            'htmlOptions' => array('width' => '10%'),
            'buttons' => array(
                'comments' => array(
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/comments.png',
                    'url'=>'Yii::app()->createUrl("control/blogComment") . "?BlogComment[title_search]=" . $data->id',
                    'label'=>Yii::t("base", "Post Comments"),
                ),
            )
        ),
    ),
)); ?>

