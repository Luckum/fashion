<?php
/* @var $this SellersProfileController */
/* @var $model SellerProfile */
/* @var $form CActiveForm */
CHtml::$afterRequiredLabel = '';
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'seller-profile-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'seller_type'); ?>
		<?php echo $form->textField($model,'seller_type',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'seller_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comission_rate'); ?>
		<?php echo $form->textField($model,'comission_rate',array('size'=>2,'maxlength'=>2)); ?>
		<?php echo $form->error($model,'comission_rate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'paypal_email'); ?>
		<?php echo $form->textField($model,'paypal_email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'paypal_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rating'); ?>
		<?php echo $form->textField($model,'rating',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'rating'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->