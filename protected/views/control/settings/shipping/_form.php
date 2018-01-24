<?php
/* @var $this ShippingController */
/* @var $model ShippingRate */
/* @var $form CActiveForm */
CHtml::$afterRequiredLabel = '';
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'shipping-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    
)); 

?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'seller_country_id'); ?>
		<?php echo $form->dropDownList($model, 'seller_country_id',  CHtml::listData(Country::model()->findAll(), 'id', 'name')); ?>
		<?php echo $form->error($model,'seller_country_id'); ?>
	</div>

    <div class="row">
        <?php $this->widget('application.extensions.emultiselect.EMultiSelect', array(
                'sortable'=>true,
                'searchable'=>true,
                'width'=>600,
                'dividerLocation'=>0.3
        )); ?>
        <?php echo $form->dropDownList(
        $model,
        'buyer_country_id',
            CHtml::listData(Country::model()->findAll(), 'id', 'name'),
        array('multiple'=>'multiple',
        'key'=>'id', 'class'=>'multiselect')
        ); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'rate'); ?>
        <?php echo $form->textField($model,'rate',array('size'=>3,'maxlength'=>3)); ?>
        <?php echo $form->error($model,'rate'); ?>
    </div>
        
    <div class="form-actions">
        <div class="offset2">
            <?php echo CHtml::submitButton(($model->isNewRecord ? Yii::t('base', 'Create') : Yii::t('base', 'Save')), array('class' => 'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('base', 'Back'),
                array(!empty($backUrl) ? $backUrl : '/control/settings/shipping/index'),
                array('class' => 'btn btn-primary')); ?>
        </div>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->