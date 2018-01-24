<?php
/* @var $this PagesController */
/* @var $model Pages */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('control/index'),
	Yii::t('base', 'Manage Static Pages') => '',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#page-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?=Yii::t('base', 'Manage Static Pages');?></h1>
<p>
<?=Yii::t('base', 'You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.'); ?>
</p>

<?php echo CHtml::link(Yii::t('base', 'Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="text-right">
    <?php echo CHtml::link(Yii::t('base', 'Create New Static Page'), array('/control/pages/create'), array('class' => 'btn btn-primary')); ?>
</div>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'page-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'enableHistory' => true, 
	'htmlOptions' => array('style' => 'cursor: pointer;'),
    'selectionChanged' => "function(id){window.location='" . Yii::app()->createUrl('control/pages/update', array('id'=>'')) . "' + $.fn.yiiGridView.getSelection(id);}",
	'columns'=>array(
		'id',
		'slug',
		'page_title',
		array('name' => 'position', 'value' => '$data->getPositionName()'),
		'menu_order',
		'footer_order',
		array('name' => 'status', 'value' => '$data->getStatusName()'),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update} {delete}',
            'htmlOptions' => array('width' => '10%'),
		),
	),
)); ?>
