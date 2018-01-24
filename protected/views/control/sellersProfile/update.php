<?php
/* @var $this SellersProfileController */
/* @var $model SellerProfile */

$this->breadcrumbs=array(
	'Seller Profiles'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SellerProfile', 'url'=>array('index')),
	array('label'=>'Create SellerProfile', 'url'=>array('create')),
	array('label'=>'View SellerProfile', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SellerProfile', 'url'=>array('admin')),
);
?>

<h1>Update SellerProfile <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>