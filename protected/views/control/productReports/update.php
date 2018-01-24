<?php

CHtml::$afterRequiredLabel = '';

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('control/index'),
    Yii::t('base', 'Comments Settings - Moderate Comments') => array('control/settings/comments/moderate'),
    Yii::t('base', 'Edit Comments') => ''
);

?>

<h4><?= Yii::t('base', 'Edit Rate From User') . '&nbsp;"' .  CHtml::encode(isset($model->user->username) ? $model->user->username : "") . '"&nbsp;' . Yii::t('base', 'To Seller') . '&nbsp;"' . CHtml::encode(isset($model->product->user->username) ? $model->product->user->username : "") . '"'; ?></h4>


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
        <label for="comment"><?php echo Yii::t('base', 'Comment'); ?></label>
        <textarea name="comment"><?=CHtml::encode($model->comment)?></textarea>
    </div>
    
    <div class="form-actions">
        <div class="offset2">
            <?php echo CHtml::link(Yii::t('base', 'Back'), array('control/productReports/view', 'id' => $model->id), array('class' => 'btn btn-primary')); ?>
            <?php echo CHtml::submitButton(Yii::t('base', 'Save'), array('class' => 'btn btn-success', 'name' => 'save')); ?>
        </div>
    </div>
<?php $this->endWidget(); ?>
</div>