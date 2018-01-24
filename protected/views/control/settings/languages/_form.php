<?php 
    CHtml::$afterRequiredLabel = '';
 ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'language-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
    
)); 

?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'name'); ?>
        <?php echo $form->textField($model,'name'); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>
    
    <?php if ($model->getOldPrefix() != Yii::app()->sourceLanguage): ?>
        <div class="row">
            <?php echo $form->labelEx($model,'prefix'); ?>
            <?php echo $form->textField($model,'prefix',array('maxlength'=>2)); ?>
            <?php echo $form->error($model,'prefix'); ?>
        </div>
    <?php endif; ?>
    
    <div class="form-actions">
        <div class="offset2">
            <?php echo CHtml::submitButton(Yii::t('base', 'Save'), array('class' => 'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('base', 'Back'), (array('/control/settings/languages/index')), array('class' => 'btn btn-primary')); ?>
        </div>
    </div>

<?php $this->endWidget(); ?>

</div>