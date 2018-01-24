<?php
/* @var $this AttributesController */
/* @var $model Attribute */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Manage Attributes') => '',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#attribute-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?=Yii::t('base', 'Manage Attributes');?></h1>

<p>
<?=Yii::t('base', 'You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.'); ?>
</p>

<?php echo CHtml::link(Yii::t('base', 'Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<div class="text-right">
    <?php
    echo CHtml::link(Yii::t('base', 'Groups'), array('/control/attributeValueGroup'), array('class' => 'btn btn-primary'));
    echo '&nbsp;';
    $route = array('/control/attributes/create');     
    if(!is_null(Yii::app()->request->getParam('categoryid', null))) 
        $route['categoryid'] = Yii::app()->request->getParam('categoryid');
    echo CHtml::link(Yii::t('base', 'Set values for dropdown lists and checkbox list'), array('/control/attributeValue'), array('class' => 'btn btn-primary'));
    echo '&nbsp;';
    echo CHtml::link(Yii::t('base', 'Add attribute'), $route, array('class' => 'btn btn-primary'));     
?>
</div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'attribute-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'enableHistory' => true,
	'htmlOptions' => array('style' => 'cursor: pointer;'),
    'selectionChanged' => "function(id){window.location='" . Yii::app()->createUrl('control/attributes/update', array('id'=>'')) . "' + $.fn.yiiGridView.getSelection(id);}",
	'columns'=>array(
		'id',
		'type',
        array(
            'header' => Yii::t('base', 'Categories'),
            'value' => '$data->getCategoriesAsString()'
        ),
		'alias',
		'required',
		'status',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update} {delete}',
            'htmlOptions' => array('width' => '10%'),
		),
	),
)); ?>
