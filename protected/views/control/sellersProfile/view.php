<?php
/* @var $this SellersProfileController */
/* @var $model SellerProfile */

$this->breadcrumbs=array(
	'Seller Profiles'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SellerProfile', 'url'=>array('index')),
	array('label'=>'Create SellerProfile', 'url'=>array('create')),
	array('label'=>'Update SellerProfile', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SellerProfile', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SellerProfile', 'url'=>array('admin')),
);
?>

<h1>View SellerProfile #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'seller_type',
		'comission_rate',
		'paypal_email',
		'rating',
	),
)); ?>
