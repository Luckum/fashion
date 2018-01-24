<?php
/* @var $this CategoriesController */
/* @var $model Category */

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('/control/index'),
	Yii::t('base', 'Manage Categories') => '',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#category-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?=Yii::t('base', 'Manage Categories');?></h1>

<p>
<?=Yii::t('base', 'You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.'); ?>
</p>

<?php echo CHtml::link(Yii::t('base', 'Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<div class="text-right">
    <?php echo CHtml::link(Yii::t('base', 'Create New Category'), array('/control/categories/create'), array('class' => 'btn btn-primary')); ?>
</div>

<?= (isset($error)) ? CHtml::hiddenField('error', $error) : '';  ?>

<div id="row-category">
	<?php $this->widget('CatGridView', array(
	    'id'=>'category-grid',
	    'dataProvider'=>$model->search(),
	    'filter'=>$model,
	    //'enableHistory' => true, 
	    'htmlOptions' => array('style' => 'cursor: pointer;'),
	    //'summaryText' => false,
    	'selectionChanged' => "function(id){window.location='" . Yii::app()->createUrl('control/categories/view', array('id'=>'')) . "' + $.fn.yiiGridView.getSelection(id);}",
	    'ajaxUrl' => array('/control/categories/moveOrder'),
	    'columns'=>array(
	    	'id',
			array('header' => Yii::t('base', 'Parent Category'), 'value' => '$data->parent ? $data->parent->alias : "Not set"'),
			array(
	            'name'=>'alias',
	            'value'=>'str_repeat("&nbsp;", $data->indent * 8) . CHtml::encode($data->alias)',
	            'type'=>'raw',
	        ),
			array('name' => 'status', 'value' => '$data->getStatusName()'),
			'menu_order',
			array(
		        'class'=>'CButtonColumn',
		        'template'=>'{up} {down}',
		        'htmlOptions'=>array(
		                'width'=>80,
		        ),
		        'buttons' => array(
		                'up'=>array(
		                        'label'=>Yii::t('base', 'Up'),
		                        'imageUrl'=>Yii::app()->getBaseUrl(true).'/images/icon_up.png',
		                        'click' => 'js:function(e) {
		                        	var id = $(this).closest("tr").find("td:first-child").html();

					                $.fn.yiiGridView.update(
					                	"category-grid", 
					                	{data: "id="+id+"&move=up",
					                	complete: function(jqXHR, status) {
								            if (status=="success") {
								                $("#content").html(jqXHR.responseText);
								                if (typeof $("#error").val() != "undefined" && $("#error").val() != "") {
								                	alert($("#error").val());
								                }
								            }
								        }}
								    );
					                return false;
					            }',
					            'visible' => '($data->menu_order < 2 || $data->getMinOrder(($data->parent) ? $data->parent->id : null) == $data->menu_order) ? 0 : 1',
		                ),
		                'down'=>array(
		                        'label'=>Yii::t('base', 'Down'),
		                        'imageUrl'=>Yii::app()->getBaseUrl(true).'/images/icon_down.png',
		                        'click' => 'js:function(e) {
		                        	var id = $(this).closest("tr").find("td:first-child").html();
		                        	
					                $.fn.yiiGridView.update(
					                	"category-grid", 
					                	{data: "id="+id+"&move=down",
					                	complete: function(jqXHR, status) {
								            if (status=="success") {
								                $("#content").html(jqXHR.responseText);
								                if (typeof $("#error").val() != "undefined" && $("#error").val() != "") {
								                	alert($("#error").val());
								                }
								            }
								        }}
								    );
					                return false;
					            }',
					            'visible' => '($data->getMaxOrder(($data->parent) ? $data->parent->id : null) == $data->menu_order) ? 0 : 1',
		                ),
		        ),
		),
	        array(
	            'class'=>'CButtonColumn',
	            'template'=>'{update} {delete}',
                'htmlOptions' => array('width' => '10%'),
	        ),
	    ),
	)); ?>

</div>