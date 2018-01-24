<?php
/* @var $this BrandsController */
/* @var $model Brand */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('control/index'),
	Yii::t('base', 'Manage Brands') => '',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#brand-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?=Yii::t('base', 'Manage Brands');?></h1>
<p>
<?=Yii::t('base', 'You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.'); ?>
</p>

<?php echo CHtml::link(Yii::t('base', 'Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="text-right">
    <?php echo CHtml::link(Yii::t('base', 'Create New Brand'), array('/control/brands/create'), array('class' => 'btn btn-primary')); ?>
</div>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php
    /**
     * Конфигурация автозаполнения.
     */
    $autoCompleteCfg = array(
        'model' => $model,
        'attribute' => 'name',
        'id' => 'b_name',
        'source'  => array_values(Brand::getAllBrands()),
        'options' => array(
            'minLength' => '1',
            'showAnim'  => 'fold',
            'select' => 'js: function(a, b) {
                location.href = location.origin + "/control/brands?Brand[name]=" + b.item.label;
            }'
        ),
    );
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'brand-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'ajaxUpdate'=>false, 
	'enableHistory' => true, 
	'htmlOptions' => array('style' => 'cursor: pointer;'),
    	'selectionChanged' => "function(id){window.location='" . Yii::app()->createUrl('control/brands/update', array('id'=>'')) . "' + $.fn.yiiGridView.getSelection(id);}",
	'columns'=>array(
		'id',
		array(
			'name'   => 'name',
            'filter' => $this->widget('zii.widgets.jui.CJuiAutoComplete', $autoCompleteCfg, true)
        ),
		array('header' => Yii::t('base', 'Products'), 'value' => 'count($data->products)'),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update} {delete}',
            'htmlOptions' => array('width' => '10%'),
		),
	),
)); ?>
