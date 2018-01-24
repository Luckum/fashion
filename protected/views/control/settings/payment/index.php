<?php

CHtml::$afterRequiredLabel = '';

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Payment Settings') => '',
);

?>

<h1><?=Yii::t('base', 'Payment Settings');?></h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'payment-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
)); ?>

    <div class="row">
        <label for="default_comission_rate"><?= Yii::t('base', 'Default Comission Rate') . '&nbsp;,%'; ?></label>
        <input type="text" name="default_comission_rate" value="<?= $data['default_comission_rate'] * 100; ?>" maxlength="3">
    </div>
        
    <div class="form-actions">
        <div class="offset2">
            <?php echo CHtml::submitButton(Yii::t('base', 'Save'), array('class' => 'btn btn-success', 'name' => 'save')); ?>
        </div>
    </div>
<?php $this->endWidget(); ?>
</div>