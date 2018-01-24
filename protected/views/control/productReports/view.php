<?php

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Item reports') => array('control/productReports'),
    Yii::t('base', 'View report') => ''
);

?>

<h4><?= Yii::t('base', 'View Report Between User') . '&nbsp;"' .  CHtml::encode(isset($model->user->username) ? $model->user->username : "") . '"&nbsp;' . Yii::t('base', 'And Seller') . '&nbsp;"' . CHtml::encode(isset($model->product->user->username) ? $model->product->user->username : "") . '"'; ?></h4>
<div class="row-fluid">
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'attributes'=>array(
            array('name' => 'product', 'value' => isset($model->product->title) ? $model->product->title : ""),
            array('name' => 'user_id', 'value' => isset($model->user->username) ? $model->user->username : ""),
            'comment',
            'added_date',
        ),
    )); ?>
</div>
<div class="form-actions">
    <div class="offset2">
        <?php echo CHtml::link(Yii::t('base', 'Back'), array('control/productReports'), array('class' => 'btn btn-primary')); ?>
        <?php echo CHtml::link(Yii::t('base', 'Edit Report'), array('/control/productReports/update', 'id' => $model->id), array('class' => 'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('base', 'Delete Report'), 'javascript:void(0)', array('class' => 'btn btn-danger', 'onclick' => "if(confirm('".Yii::t('base', 'Are you sure you want to delete this response?')."')) location.href='".Yii::app()->urlManager->createUrl('/control/productReports/delete', array('id' => $model->id))."';")); ?>
    </div>
</div>
