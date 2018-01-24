<?php
CHtml::$afterRequiredLabel = '';

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Shipping Settings') => '',
);
?>

<h4><?=Yii::t('base', 'Default Shipping Settings');?></h4>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'shipping-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
)); ?>

    <div class="row">
        <label for="default_rate"><?= Yii::t('base', 'Default Rate, EUR'); ?></label>
        <input type="text" name="default_rate" value="<?= $data['default_rate']; ?>" >
    </div>
    
    <div class="form-actions">
        <div class="offset2">
            <?php echo CHtml::submitButton(Yii::t('base', 'Save'), array('class' => 'btn btn-success', 'name' => 'save')); ?>
        </div>
    </div>
<?php $this->endWidget(); ?>
</div>

<h4><?=Yii::t('base', 'Default Shipping Settings For Countries');?></h4>
<div class="text-right">
    <?php echo CHtml::link(Yii::t('base', 'Add Default Rate For Seller Country'), array('/control/settings/shipping/createdefault'), array('class' => 'btn btn-primary')); ?>
</div>

<?php 
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'shipping-default-grid',
    'dataProvider'=>$defaultModel->search(),
    'filter'=>$defaultModel,
    'enableHistory' => true, 
    'columns'=>array(
        array('name' => 'country_id', 'value' => '$data->country->name'),
        'rate',
        array(
            'class'=>'CButtonColumn',
            'htmlOptions' => array('width' => '10%'),
            'template' => '{update} {delete}',
            'buttons' => array(
                'update' => array(
                    'url'=>'Yii::app()->createUrl("control/settings/shipping/updatedefault", array("id"=>$data->id))',
                ),
                'delete' => array(
                    'url'=>'Yii::app()->createUrl("control/settings/shipping/deletedefault", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
)); 
?>


<h4><?=Yii::t('base', 'Shipping Settings For Countries');?></h4>
<div class="text-right">
    <?php echo CHtml::link(Yii::t('base', 'Add Rate For Seller Country'), array('/control/settings/shipping/create'), array('class' => 'btn btn-primary')); ?>
</div>

<?php 
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'shipping-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'enableHistory' => true, 
    'columns'=>array(
        array('name' => 'seller_country_id', 'value' => '$data->sellerCountry->name'),
        array('name' => 'buyer_country_id', 'value' => '$data->buyerCountry->name'),
        'rate',
        array(
            'class'=>'CButtonColumn',
            'htmlOptions' => array('width' => '10%'),
            'template' => '{update} {delete}'
        ),
    ),
)); 
?>

