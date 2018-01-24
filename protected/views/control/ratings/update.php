<?php

CHtml::$afterRequiredLabel = '';

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Comments Settings - Moderate Comments') => array('control/settings/comments/moderate'),
    Yii::t('base', 'Edit Comments') => ''
);

?>

<h4><?= Yii::t('base', 'Edit Rate From User') . '&nbsp;"' .  CHtml::encode($model->user->username) . '"&nbsp;' . Yii::t('base', 'To Seller') . '&nbsp;"' . CHtml::encode($model->product->user->username) . '"'; ?></h4>


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'banned-comments-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
)); ?>

    <div class="row">
        <label for="communication"><?php echo Yii::t('base', 'Communication'); ?></label>
        <input type="text" name="communication" style="width: 50%" value="<?php echo $model->communication; ?>">
    </div>

    <div class="row">
        <label for="description"><?php echo Yii::t('base', 'Description'); ?></label>
        <input type="text" name="description" style="width: 50%" value="<?php echo $model->description; ?>">
    </div>

    <div class="row">
        <label for="shipment"><?php echo Yii::t('base', 'Shipment'); ?></label>
        <input type="text" name="shipment" style="width: 50%" value="<?php echo $model->shipment; ?>">
    </div>
    
    <div class="form-actions">
        <div class="offset2">
            <?php echo CHtml::link(Yii::t('base', 'Back'), array('control/ratings/view', 'id' => $model->id), array('class' => 'btn btn-primary')); ?>
            <?php echo CHtml::submitButton(Yii::t('base', 'Save'), array('class' => 'btn btn-success', 'name' => 'save')); ?>
        </div>
    </div>
<?php $this->endWidget(); ?>
</div>