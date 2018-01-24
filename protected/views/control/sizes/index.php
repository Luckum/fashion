<?php
    /* @var $this SizesController */
    /* @var $model SizeChartCat */

    $this->breadcrumbs=array(
        Yii::t('base', 'Control Panel')=>array('/control/index'),
        Yii::t('base', 'Manage Sizes') => array('/control/sizes'),
    );

    Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
        });
        $('.search-form form').submit(function(){
            $('#product-grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
?>

<h1><?=Yii::t('base', 'Manage Sizes');?></h1>
<p><?=Yii::t('base', 'You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.'); ?></p>
<div class="text-right">
    <?php echo CHtml::link(Yii::t('base', 'Create New Size'), array('/control/sizes/create'), array('class' => 'btn btn-primary')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'size-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'enableHistory' => true,
    'htmlOptions' => array('style' => 'cursor: pointer;'),
    'selectionChanged' => "function(id){window.location='" . Yii::app()->createUrl('control/sizes/view', array('id'=>'')) . "' + $.fn.yiiGridView.getSelection(id);}",
    'columns'=>array(
        'id',
        array(
            'name' => 'type', 
            'filter' => SizeChart::model()->getAllFieldValues('type')
        ),
        array(
            'name' => 'size', 
            //'filter' => SizeChart::model()->getAllFieldValues('size')
        ),
        array(
            'name' => 'size_cat_search', 
            'value' => '$data->sizeChartCat->name',
            'filter' =>SizeChart::model()->getSizeChartCategories('name'),
        ),
        array(
            'class'=>'CButtonColumn',
            'htmlOptions' => array('width' => '10%'),
        )
    ),
)); ?>

