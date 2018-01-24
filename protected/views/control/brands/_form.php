<?php
/* @var $this BrandsController */
/* @var $model Brand */
/* @var $form CActiveForm */
CHtml::$afterRequiredLabel = '';
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'brand-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="form-actions">
		<div class="offset2">
			<?php echo CHtml::submitButton(($model->isNewRecord ? Yii::t('base', 'Create') : Yii::t('base', 'Save')), array('class' => 'btn btn-success')); ?>
			<?php echo CHtml::link(Yii::t('base', 'Back'), ($model->isNewRecord ?
				array('/control/brands/index') :
				//array('/control/brands/view', 'id' => $model->id)),
				array('/control/brands/index' . $backParameters)),
				array('class' => 'btn btn-primary')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->