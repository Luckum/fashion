<?php

CHtml::$afterRequiredLabel = '';

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Colors') => '',
);

?>

<h1><?=Yii::t('base', 'Colors Management');?></h1>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'colors-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    )); ?>

    <div class="row">
        <label for="colors"><?= Yii::t('base', 'List of Colors') ?></label>
        <textarea name="colors" rows="8" style="width: 70%"><?= CHtml::encode($data); ?></textarea><br/><small><?= Yii::t('base', 'Separate values by comma (",")'); ?></small>
    </div>

    <div class="form-actions">
        <div class="offset2">
            <?php echo CHtml::submitButton(Yii::t('base', 'Save'), array('class' => 'btn btn-success')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>