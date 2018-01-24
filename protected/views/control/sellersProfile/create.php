<?php
/* @var $this SellersProfileController */
/* @var $model SellerProfile */

$this->breadcrumbs=array(
	'Seller Profiles'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SellerProfile', 'url'=>array('index')),
	array('label'=>'Manage SellerProfile', 'url'=>array('admin')),
);
?>

<h1>Create SellerProfile</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>