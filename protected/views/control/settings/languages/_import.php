<?php 
    CHtml::$afterRequiredLabel = '';
 ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'import-lng-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

    <div class="row">
        <?php echo $form->labelEx($formModel, 'file'); ?>
        <?php echo $form->fileField($formModel,'file'); ?>
        <?php echo $form->error($formModel,'file'); ?>
    </div>
    
    <div class="form-actions">
        <div class="offset2">
            <?php echo CHtml::submitButton(Yii::t('base', 'Import'), array('class' => 'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('base', 'Close'), '#', array('class' => 'btn btn-primary', 'onclick' => '$("#importLang").dialog("close");')); ?>
        </div>
    </div>

<?php $this->endWidget(); ?>

</div>