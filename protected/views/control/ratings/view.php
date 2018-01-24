<?php

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Ratings') => array('control/ratings'),
    Yii::t('base', 'View ratings') => ''
);

?>

<h4><?= Yii::t('base', 'View Rates Between User') . '&nbsp;"' .  CHtml::encode($model->user->username) . '"&nbsp;' . Yii::t('base', 'And Seller') . '&nbsp;"' . CHtml::encode($model->product->user->username) . '"'; ?></h4>
<div class="row-fluid">
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'attributes'=>array(
            array('name' => 'product', 'value' => $model->product->title),
            array('name' => 'user_id', 'value' => $model->user->username),
            array('name' => 'seller_id', 'value' => $model->product->user->username),
            'communication',
            'description',
            'shipment',
            'total',
            'added_date',
        ),
    )); ?>
</div>
<div class="form-actions">
    <div class="offset2">
        <?php echo CHtml::link(Yii::t('base', 'Back'), array('control/ratings'), array('class' => 'btn btn-primary')); ?>
        <?php echo CHtml::link(Yii::t('base', 'Edit Rating'), array('/control/ratings/update', 'id' => $model->id), array('class' => 'btn btn-success')); ?>
        <?php echo CHtml::link(Yii::t('base', 'Delete Rating'), 'javascript:void(0)', array('class' => 'btn btn-danger', 'onclick' => "if(confirm('".Yii::t('base', 'Are you sure you want to delete this response?')."')) location.href='".Yii::app()->urlManager->createUrl('/control/ratings/delete', array('id' => $model->id))."';")); ?>
    </div>
</div>
