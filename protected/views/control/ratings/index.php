<?php
/* @var $this OrdersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Manage Ratings') => '',
);

?>

<h1><?=Yii::t('base', 'Manage Ratings');?></h1>

<?php

$this->widget('FGridView', array(
    'id'=>'rating-grid',
    'template'=>'{summary} {pager} {items} {pager}',
    'dataProvider'=>$model,
    'controller' => 'ratings',
    'enableHistory' => true, 
    'htmlOptions' => array('style' => 'cursor: pointer;'),
    'selectionChanged' => "function(id){window.location='" . Yii::app()->createUrl('control/ratings/view', array('id'=>'')) . "' + $.fn.yiiGridView.getSelection(id);}",
    'columns'=>array(
        'id',
        array('name' => 'product_id', 'value' => '$data->product->title'),
        array('name' => 'user_id', 'value' => '$data->user->username'),
        array('name' => 'seller_id', 'value' => '$data->product->user->username'),
        'communication',
        'description',
        'shipment',
        'total',
        'added_date',
    ),
)); 

?>

