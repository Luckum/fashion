<?php
/* @var $this SellersProfileController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Seller Profiles',
);

$this->menu=array(
	array('label'=>'Create SellerProfile', 'url'=>array('create')),
	array('label'=>'Manage SellerProfile', 'url'=>array('admin')),
);
?>

<h1>Seller Profiles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
