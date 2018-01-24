<?php
/* @var $this OrdersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Manage Item Reports') => '',
);

?>

<h1><?=Yii::t('base', 'Manage Item Reports');?></h1>

<?php

$this->widget('FGridView', array(
    'id'=>'report-grid',
    'template'=>'{summary} {pager} {items} {pager}',
    'dataProvider'=>$model,
    'controller' => 'productReports',
    'enableHistory' => true, 
    'htmlOptions' => array('style' => 'cursor: pointer;'),
    'selectionChanged' => "function(id){window.location='" . Yii::app()->createUrl('control/productReports/view', array('id'=>'')) . "' + $.fn.yiiGridView.getSelection(id);}",
    'columns'=>array(
        array('name' => 'product_id', 'value' => 'isset($data->product->title) ? $data->product->title : ""'),
        array('name' => 'user_id', 'value' => 'isset($data->user->username) ? $data->user->username : ""'),
        'comment',
        'added_date',
    ),
)); 

?>

