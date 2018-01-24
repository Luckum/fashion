<?php
/* @var $this UsersController */
/* @var $model Users */

CHtml::$afterRequiredLabel = '';

$this->breadcrumbs=array(
    Yii::t('base', 'Control Panel')=>array('/control/index'),
    $model->username => array('/control/admins/view', 'id' => $model->id),    
    Yii::t('base', 'Change Password') => ''
);
?>
<div>

    <h1><?=Yii::t('base', 'Update Password for');?> "<?php echo CHtml::encode($model->username); ?>"</h1>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'admins-form',
    'enableAjaxValidation'=>false,
)); ?>


<?php $this->renderPartial('/shared/profile/changePassword', array('model' => $model, 'form' => $form, 'saved' => $saved, 'self' => $self)); ?>
    <div class="form-actions">
        <div class="offset2">
            <?php echo CHtml::submitButton(Yii::t('base', 'Save Changes'), array('class' => 'btn btn-primary')); ?>
            <?php echo CHtml::link(Yii::t('base', 'Cancel'), array('/control/admins/view/','id' =>$model->id), array('class' => 'btn')); ?>    
        </div>
    </div>

<?php $this->endWidget(); ?>
</div>
