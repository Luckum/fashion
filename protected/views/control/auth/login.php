<?php
/* @var $this IndexController */

CHtml::$afterRequiredLabel = '';

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('/control/index'),
	Yii::t('base', 'Log In') => '',
);
?>
<h1><?=Yii::t('base', 'Log In');?></h1>

<p><?=Yii::t('base', 'Please fill out the following form with your login credentials:');?></p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'login-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>
<?php echo $form->errorSummary($model, '<a class="close" data-dismiss="alert" href="#">&times;</a>', '', array('class' => 'alert alert-error mid')); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password'); ?>
    </div>

    <!-- div class="row rememberMe">
        <?php echo $form->checkBox($model,'rememberMe'); ?>
        <?php echo $form->label($model,'rememberMe'); ?>
        <?php echo $form->error($model,'rememberMe'); ?>
    </div -->

    <div class="row buttons form-actions">
        <div class="offset2">
        <?php echo CHtml::submitButton(Yii::t('base', 'Login'), array('class'=>'btn btn-primary')); ?>
        </div>
    </div>

<?php $this->endWidget(); ?>
</div><!-- form -->

