<?php
/* @var $this OrdersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Manage Orders') => '',
);

?>

<h1><?=Yii::t('base', 'Manage Orders');?></h1>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'changeStatus',
        'options'=>array(
            'title'=>Yii::t('base', 'Change order status'),
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>'auto',
            'height'=>'auto',
            'resizable'=>'false',
        ),
    ));
$this->endWidget();

$updateStatusDialog =<<<EOT
function() {
    var url = $(this).attr('href');
    $.get(url, function(r){
        $("#changeStatus").html(r).dialog("open");
    });
    return false;
}
EOT;

$this->widget('FGridView', array(
    'id'=>'order-grid',
    'template'=>'{summary} {status} {pager} {items} {pager}',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'enableHistory' => true,
    'controller' => 'orders',
    'htmlOptions' => array('style' => 'cursor: pointer;'),
    'selectionChanged' => "function(id){window.location='" . Yii::app()->createUrl('control/orders/view', array('id'=>'')) . "' + $.fn.yiiGridView.getSelection(id);}",
    'columns'=>array(
        'id',
        array('name' => 'status', 'value' => '$data->status'),
        'added_date',
        array('header' => Yii::t('base', 'Customer'),'name' => 'user_id', 'value' => '$data->user->username'),
        'total',
        array(
            'class'=>'CButtonColumn',
            'htmlOptions' => array('width' => '10%'),
            'template' => '{changestatus} {delete}',
            'buttons' => array(
                'changestatus' => array(
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/changestatus.png',
                    'url'=>'Yii::app()->createUrl("control/orders/changeStatus", array("id"=>$data->id))',
                    'label'=>Yii::t("base", "Change Order Status"),
                    'click' => $updateStatusDialog
                ),
            ),
        ),
    ),
)); 

?>

