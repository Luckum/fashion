<?php
/* @var $this BlocksController */
/* @var $model HomepageBlock */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('/control/index'),
	Yii::t('base', 'Manage Homepage Block') => '',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#block-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?=Yii::t('base', 'Manage Homepage Block');?></h1>

<p>
<?=Yii::t('base', 'You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.'); ?>
</p>

<?php echo CHtml::link(Yii::t('base', 'Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'block-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'enableHistory' => true, 
	'htmlOptions' => array('style' => 'cursor: pointer;'),
    'selectionChanged' => "function(id){window.location='" . Yii::app()->createUrl('control/blocks/update', array('id'=>'')) . "' + $.fn.yiiGridView.getSelection(id);}",
	'columns'=>array(
		'id',
		'image',
		'link_type',
		'url',
        array('header' => 'title', 'value' => '$data->homepageBlockContents[0]->title'),
        array('header' => 'content', 'value' => '$data->homepageBlockContents[0]->content'),
		'visible',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}',
            'htmlOptions' => array('width' => '10%'),
		),
	),
)); ?>
