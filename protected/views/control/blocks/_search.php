<?php
/* @var $this BlocksController */
/* @var $model HomepageBlock */
/* @var $form CActiveForm */
CHtml::$afterRequiredLabel = '';
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'image'); ?>
		<?php echo $form->textField($model,'image'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'link_type'); ?>
		<?php echo $form->dropDownList($model,'link_type', $model->getLinkType()); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'url'); ?>
		<?php echo $form->textField($model,'url'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->