<?php
/* @var $this BlogCategoryController */
/* @var $model BlogCategory */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Blog')=>array('control/blog'),
    Yii::t('base', 'Manage Blog Categories') => array('control/blogCategory'),
);

?>

<h1><?=Yii::t('base', 'Manage Blog Categories');?></h1>

<div class="text-right">
    <?php echo CHtml::link(Yii::t('base', 'Create New Blog Categories'), array('/control/blogCategory/create'), array('class' => 'btn btn-primary')); ?>
</div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'category-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'enableHistory' => true,
    'selectionChanged' => "function(id){window.location='" . Yii::app()->createUrl('control/blogCategory/update', array('id'=>'')) . "' + $.fn.yiiGridView.getSelection(id);}",
    'htmlOptions' => array('style' => 'cursor: pointer;'),
    'columns'=>array(
        'id',
        'name',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update} {delete}',
            'htmlOptions' => array('width' => '10%'),
        ),
    ),
)); ?>
