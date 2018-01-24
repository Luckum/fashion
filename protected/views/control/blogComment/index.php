<?php
/* @var $this BlogCommentController */
/* @var $model BlogComment */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Blog')=>array('control/blog'),
    Yii::t('base', 'Manage Blog Comments') => array('control/blogComment'),
);
?>

<h1><?=Yii::t('base', 'Manage Blog Comments');?></h1>

<div class="text-right">
    <?php echo CHtml::link(Yii::t('base', 'Create New Blog Comment'), array('/control/blogComment/create'), array('class' => 'btn btn-primary')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'tag-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'enableHistory' => true,
    'htmlOptions' => array('style' => 'cursor: pointer;'),
    'selectionChanged' => "function(id){window.location='" . Yii::app()->createUrl('control/blogComment/view', array('id'=>'')) . "' + $.fn.yiiGridView.getSelection(id);}",
    'columns'=>array(
        'id',
        'content',
        array(
            'name' => 'status',
            'value' => '$data->statusName',
            'filter' => $model->getStatuses()
        ),
        'create_time',
        'update_time',
        array(
            'name' => 'author_search',
            'value' => '$data->author->username'
        ),
        array(
            'name' => 'title_search',
            'value' => '$data->post->title',
            'filter' => BlogPost::getAllPosts()
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{view} {update} {delete}',
            'htmlOptions' => array('width' => '10%'),
        ),
    ),
)); ?>
