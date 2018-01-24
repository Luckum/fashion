<?php
/* @var $this AttributeValueController */
/* @var $model AttributeValue */
/* @var $form CActiveForm */
$languages = array();
foreach (UtilsHelper::getLanguages() as $lang) {
	$languages[$lang] = $lang;
}

CHtml::$afterRequiredLabel = '';
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'attribute-value-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<?php 
		for ($i=0; $i < 10; $i++):
	?>
		<div class="row">
			<?php echo $form->labelEx($model,'[' . $i . ']language'); ?>
			<?php echo $form->dropDownList($model,'[' . $i . ']language', $languages); ?>
			<?php echo $form->error($model,'[' . $i . ']language'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'[' . $i . ']group_id'); ?>
			<?php echo $form->dropDownList($model,'[' . $i . ']group_id', AttributeValueGroup::getGroups()); ?>
			<?php echo $form->error($model,'[' . $i . ']group_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'[' . $i . ']value'); ?>
			<?php echo $form->textField($model,'[' . $i . ']value',array('size'=>60,'maxlength'=>512, 'class' => 'value_field')); ?>
			<?php echo $form->error($model,'[' . $i . ']value'); ?>
		</div>

		<hr/>
	<?php 
		endfor;
	?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->