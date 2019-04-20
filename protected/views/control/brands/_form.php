<?php
/* @var $this BrandsController */
/* @var $model Brand */
/* @var $form CActiveForm */
CHtml::$afterRequiredLabel = '';
Yii::import('ext.select2.Select2');

if (!$model->isNewRecord) {
    Yii::app()->clientScript->registerScript('variant', "
        $('#add-variant-btn').click(function() {
            $('#s2id_variant').show();
            $('#cancel-variant-btn').show();
            $('#add-variant-btn').hide();
            $('#s2id_variant_to').hide();
            $('#cancel-variant-to-btn').hide();
            $('#add-variant-to-btn').show();
        });
        $('#cancel-variant-btn').click(function() {
            $('#s2id_variant').hide();
            $('#cancel-variant-btn').hide();
            $('#add-variant-btn').show();
        });
        
        $('#add-variant-to-btn').click(function() {
            $('#s2id_variant_to').show();
            $('#cancel-variant-to-btn').show();
            $('#add-variant-to-btn').hide();
            $('#s2id_variant').hide();
            $('#cancel-variant-btn').hide();
            $('#add-variant-btn').show();
        });
        $('#cancel-variant-to-btn').click(function() {
            $('#s2id_variant_to').hide();
            $('#cancel-variant-to-btn').hide();
            $('#add-variant-to-btn').show();
        });
    ");
}


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
    
    <?php if (!$model->isNewRecord): ?>
        <?php if ($model->brand_variants): ?>
            <p><b>Variants</b></p>
            <?php foreach ($model->brand_variants as $variant): ?>
                <?= $variant->name ?><br />
            <?php endforeach; ?>
        <?php endif; ?>
        <?= Select2::dropDownList('variant', '', Brand::getAllBrands(true), 
                array(
                    'empty' => '',
                    'style' => 'width: 50%; display: none;',
                    'select2Options' => array(
                        'placeholder' => 'Select brand',
                    ),
                )
        ); ?>
        <?php echo CHtml::link(Yii::t('base', 'Cancel'), 'javascript:void(0)', array('class' => 'btn btn-primary', 'id' => 'cancel-variant-btn', 'style' => 'display: none;')); ?>
        
        <?= Select2::dropDownList('variant_to', '', Brand::getAllBrands(true), 
                array(
                    'empty' => '',
                    'style' => 'width: 50%; display: none;',
                    'select2Options' => array(
                        'placeholder' => 'Select brand',
                    ),
                )
        ); ?>
        <?php echo CHtml::link(Yii::t('base', 'Cancel'), 'javascript:void(0)', array('class' => 'btn btn-primary', 'id' => 'cancel-variant-to-btn', 'style' => 'display: none;')); ?>
    <?php endif; ?>

	<div class="form-actions">
		<div class="offset2">
			<?php if (!$model->isNewRecord): ?>
                <?php echo CHtml::link(Yii::t('base', 'Add variant to brand'), 'javascript:void(0)', array('class' => 'btn btn-primary', 'id' => 'add-variant-btn')); ?>
                <?php echo CHtml::link(Yii::t('base', 'Set brand as variant'), 'javascript:void(0)', array('class' => 'btn btn-primary', 'id' => 'add-variant-to-btn')); ?>
            <?php endif; ?>
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