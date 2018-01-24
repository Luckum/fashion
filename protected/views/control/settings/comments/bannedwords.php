<?php

CHtml::$afterRequiredLabel = '';

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Comments Settings - Banned words') => '',
);

?>

<h1><?=Yii::t('base', 'Comments Settings - Banned words');?></h1>

<div class="text-right">
    <?php echo CHtml::link(Yii::t('base', 'Moderate Comments'), array('/control/settings/comments/moderate'), array('class' => 'btn btn-primary')); ?>
</div>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'banned-words-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
)); ?>

    <div class="row">
        <label for="banned_words"><?= Yii::t('base', 'List of Banned Words') ?></label>
        <textarea name="banned_words" rows="8" style="width: 70%"><?= CHtml::encode($data); ?></textarea><br/><small><?= Yii::t('base', 'Separate values by comma (",")'); ?></small>
    </div>
    
    <div class="form-actions">
        <div class="offset2">
            <?php echo CHtml::submitButton(Yii::t('base', 'Save'), array('class' => 'btn btn-success')); ?>
        </div>
    </div>
<?php $this->endWidget(); ?>
</div>