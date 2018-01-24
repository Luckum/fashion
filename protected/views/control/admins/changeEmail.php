<?php
/* @var $this UsersController */
/* @var $model Users */

CHtml::$afterRequiredLabel = '';

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('/control/index'),
    $model->username => array('/control/admins/view', 'id' => $model->id),
    Yii::t('base', 'Change Email') => ''
);
?>
<div>

    <h1><?=Yii::t('base', 'Update Email for');?> "<?php echo CHtml::encode($model->username); ?>"</h1>

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'admins-form',
        'enableAjaxValidation'=>false,
    )); ?>

    <?php echo $form->errorSummary($model, '<a class="close" data-dismiss="alert" href="#">&times;</a><strong>The following errors occurred:</strong><br><br>', '', array('class' => 'alert alert-error mid')); ?>
    <?php
    if($saved) {
    ?>
    <div class="alert alert-success">Changes Saved Successfully!<a class="close" data-dismiss="alert" href="#">&times;</a></div>
    <?php
    }
    ?>
    <div class="row">
        <div class="span6 offset1">
            <div class="row">
                <?php echo $form->labelEx($model,'Email'); ?>
                <?php echo CHtml::textField('email', $model->email); ?>
            </div>
        </div>

    </div>
    <div class="form-actions">
        <div class="offset2">
            <?php echo CHtml::submitButton(Yii::t('base', 'Save Changes'), array('class' => 'btn btn-primary')); ?>
            <?php echo CHtml::link(Yii::t('base', 'Cancel'), array('/control/admins/view/','id' =>$model->id), array('class' => 'btn')); ?>
        </div>
    </div>

<?php $this->endWidget(); ?>
</div>
