<?php
	/* @var $this ProductsController */
	/* @var $model Product */

	$this->breadcrumbs=array(
		Yii::t('base', 'Control Panel')=>array('/control/index'),
		Yii::t('base', 'Manage Products') => array('/control/products'),
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

<?php if (Yii::app()->user->hasFlash('importSuccess')): ?>
    <div class="row-fluid">
        <div class="alert alert-success">
            <?php echo Yii::app()->user->getFlash('importSuccess'); ?>
        </div>
    </div>
<?php endif; ?>

<h1><?=Yii::t('base', 'Manage Products');?></h1>
<p><?=Yii::t('base', 'You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.'); ?></p>
<div class="text-right">
    <?php echo CHtml::link(Yii::t('base', 'Import scrapper data'), array('/control/products/import'), array('class' => 'btn btn-success')); ?>
<!--    <?php echo CHtml::link(Yii::t('base', 'Clear images folders'), array('/control/products/clear'), array('class' => 'btn btn-success')); ?>-->
    <?php echo CHtml::link(Yii::t('base', 'Create New Product'), array('/control/products/create'), array('class' => 'btn btn-primary')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'enableHistory' => true,
	'htmlOptions' => array('style' => 'cursor: pointer;'),
    'selectionChanged' => "function(id){window.location='" . Yii::app()->createUrl('control/products/view', array('id'=>'')) . "' + $.fn.yiiGridView.getSelection(id);}",
	'columns'=>array(
		'id',
		'title',
		array(
			'name' => 'category_search', 
			'value' => '$data->category->getNameByLanguage()->name',
			'filter' => Category::getSubCategoryList(null, true, false)
		),
		array(
			'name' => 'parent_category_search',
			'value' => '$data->category->parent ? $data->category->parent->getNameByLanguage()->name : "Not set"',
			'filter' => Category::getParrentCategoryList()
		),
		array(
			'name' => 'brand_search', 
			'value' => '$data->brand->name'
		),
		array(
			'name' => 'size_search', 
			'value' => 'empty($data -> size_chart) ? Yii :: t(\'base\', \'No size\') : $data -> size_chart -> size'),
		array(
			'name' => 'condition', 
			'value' => '$data->getConditionsName()',
			'filter' => Product::getConditions()
		),
		array(
			'name' => 'user_search', 
			'value' => '$data->user->username'
		),
		'added_date',
		array(
			'name' => 'our_selection', 
			'value' => '($data->our_selection == 0) ? "No" : "Yes"',
			'filter' => array(0 => 'No', 1 => 'Yes')
		),
		array(
			'name' => 'status', 
			'value' => '$data->getStatusName()',
			'filter' => Product::model()->getStatuses()
		),
		array(
			'class'=>'CButtonColumn',
			'htmlOptions' => array('width' => '13%'),
			'template'=>'{view} {update} {delete} {approve} {decline}',
			'buttons' => array(
				'approve' => array(
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/approve.png',
					'url'=>'Yii::app()->createUrl("control/products/approve", array("id"=>$data->id))',
					'label'=>Yii::t("base", "Approve Product"),
					'visible' => '$data->status == Product::PRODUCT_STATUS_DEACTIVE || $data->status == Product::PRODUCT_STATUS_PENDING',
				),
				'decline' => array(
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/decline.png',
					'url'=>'Yii::app()->createUrl("control/products/decline", array("id"=>$data->id))',
					'label'=>Yii::t("base", "Decline Product"),
					'visible' => '$data->status == Product::PRODUCT_STATUS_DEACTIVE || $data->status == Product::PRODUCT_STATUS_PENDING',
				),
			)

		),
	),
)); ?>

