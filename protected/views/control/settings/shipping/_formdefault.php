<?php
/* @var $this ShippingController */
/* @var $model ShippingRateDefault */
/* @var $form CActiveForm */
CHtml::$afterRequiredLabel = '';
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'shipping-default-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
    
)); 

?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'country_id'); ?>
        <?php echo $form->dropDownList($model, 'country_id',  CHtml::listData(Country::model()->findAll(), 'id', 'name')); ?>
        <?php echo $form->error($model,'country_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'rate'); ?>
        <?php echo $form->textField($model,'rate',array('size'=>3,'maxlength'=>3)); ?>
        <?php echo $form->error($model,'rate'); ?>
    </div>
        
    <div class="form-actions">
        <div class="offset2">
            <?php echo CHtml::submitButton(($model->isNewRecord ? Yii::t('base', 'Create') : Yii::t('base', 'Save')), array('class' => 'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('base', 'Back'), array('/control/settings/shipping/index'), array('class' => 'btn btn-primary')); ?>
        </div>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
