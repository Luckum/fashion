<?php
/* @var $this SellersProfileController */
/* @var $model SellerProfile */

$this->breadcrumbs=array(
	'Seller Profiles'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List SellerProfile', 'url'=>array('index')),
	array('label'=>'Create SellerProfile', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#seller-profile-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Seller Profiles</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'seller-profile-grid',
	'dataProvider'=>$model->search(),
	'enableHistory' => true,
	'filter'=>$model,
	'columns'=>array(
		'id',
		'user_id',
		'seller_type',
		'comission_rate',
		'paypal_email',
		'rating',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
