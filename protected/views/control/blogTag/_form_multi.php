<?php
/* @var $this BlogTagController */
/* @var $model BlogTag */
/* @var $form CActiveForm */
CHtml::$afterRequiredLabel = '';
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'blog-tag-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
)); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php
        for ($i=0; $i < 5; $i++):
    ?>
        <div class="row">
            <?php echo $form->labelEx($model,'[' . $i . ']name'); ?>
            <?php echo $form->textField($model,'[' . $i . ']name',array('size'=>60,'maxlength'=>256)); ?>
            <?php echo $form->error($model,'[' . $i . ']name'); ?>
        </div>

        <hr/>
    <?php
        endfor;
    ?>

    <div class="form-actions">
        <div class="offset2">
            <?php echo CHtml::submitButton(($model->isNewRecord ? Yii::t('base', 'Create') : Yii::t('base', 'Save')), array('class' => 'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('base', 'Back'), ($model->isNewRecord ?
                array('/control/blogTag/index') :
                array('/control/blogTag/index' . $backParameters)),
                array('class' => 'btn btn-primary')); ?>
        </div>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->