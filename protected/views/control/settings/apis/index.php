<?php
/* @var $this ProductsController */
/* @var $model Product */

CHtml::$afterRequiredLabel = '';

$this->breadcrumbs=array(
	Yii::t('base', 'Control Panel')=>array('/control/index'),
	Yii::t('base', 'Apis Settings') => '',
);
?>

<h1><?=Yii::t('base', 'Apis Settings');?></h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'apis-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
)); ?>

	<?php foreach ($settings as $apiName => $model) : ?>
		<h3 class="heading"><?= $model->getAttributeLabel($apiName) ?></h3>

		<?php foreach ($model->getSettings() as $param => $value) : ?>
			<div class="row">
				<?php echo $form->labelEx($model, $param); ?>
				<?php echo $form->textArea($model, $param, array('name' => 'ApiSetting['.$apiName.']['.$param.']')); ?>
				<?php echo $form->error($model, $param); ?>
			</div>
		<?php endforeach; ?>

		<?php if ($apiName == 'quickBooks'): ?>
				<div class="offset2">
					<?php echo CHtml::link(Yii::t('base', 'Get auth token'), array('/control/settings/apis/getTokenQb'), array('class' => (QuickbooksAuth::isExpireToken()) ? 'btn btn-warning' : 'btn btn-success')); ?>
				</div>
		<?php endif; ?>
		
	<?php endforeach; ?>
    
    <div class="form-actions">
		<div class="offset2">
			<?php echo CHtml::submitButton(Yii::t('base', 'Save'), array('class' => 'btn btn-success')); ?>
			<?php echo CHtml::link(Yii::t('base', 'Back'), array('/control/index/index'), array('class' => 'btn btn-primary')); ?>
		</div>
	</div>
<?php $this->endWidget(); ?>

</div>