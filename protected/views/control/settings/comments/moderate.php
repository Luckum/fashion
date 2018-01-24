<?php

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Comments Settings - Moderate Comments') => '',
);

?>

<h1><?=Yii::t('base', 'Comments Settings - Moderate Comments');?></h1>

<div class="text-right">
    <?php echo CHtml::link(Yii::t('base', 'Banned Words'), array('/control/settings/comments/bannedwords'), array('class' => 'btn btn-primary')); ?>
</div>

<?php 
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'moderate-grid',
    'dataProvider' => $model,
    'enableHistory' => true, 
    'htmlOptions' => array('style' => 'cursor: pointer;'),
    'selectionChanged' => "function(id){window.location='" . Yii::app()->createUrl('control/settings/comments/view', array('id'=>'')) . "/' + $.fn.yiiGridView.getSelection(id);}",
    'columns'=>array(
        array('name' => 'product_id', 'value' => '$data->product->title'),
        array('name' => 'user_id', 'value' => '$data->user->username'),
        array('name' => 'seller_id', 'value' => '$data->product->user->username'),
        array('name' => 'comment', 'value' => 'ucfirst($data->comment)'),
        array('name' => 'response', 'value' => 'ucfirst($data->response)'),
        array('name' => 'comment_status', 'value' => 'ucfirst($data->comment_status)', 'filter' => false),
        array('name' => 'response_status', 'value' => 'ucfirst($data->response_status)', 'filter' => false),
    ),
));
?>
