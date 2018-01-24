<?php
/* @var $this UsersController */
/* @var $model User */
/* @var $form CActiveForm */
CHtml::$afterRequiredLabel = '';
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    
)); 

?>

	<?php echo $form->errorSummary($model); ?>
    <?php echo $form->errorSummary($sellerModel); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>40,'maxlength'=>40, 'value'=>'')); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'country_id'); ?>
		<?php echo $form->dropDownList($model, 'country_id', CHtml::listData(Country::model()->findAll(), 'id', 'name')); ?>
		<?php echo $form->error($model,'country_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model, 'status', $model->getStatuses()); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
    
    <div class="row">
        <label for="User_type"><?= $model->getAttributeLabel('type'); ?></label>
        <select id="User_type" name="User[type]">
            <?php foreach ($model->getTypes() as $k => $type): ?>
                <option value="<?= $k; ?>" <?php if (!$model->isNewRecord && !empty($sellerModel->user_id) && $type == User::SELLER): ?> selected <?php endif; ?>><?= $type; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
	<div id="seller_info" <?php if ($model->isNewRecord || (!$model->isNewRecord && empty($sellerModel->user_id))): ?> style="display: none;" <?php endif; ?>>
        <div class="row">
            <?php echo $form->labelEx($sellerModel,'seller_type'); ?>
            <?php echo $form->dropDownList($sellerModel, 'seller_type', $sellerModel->getTypes()); ?>
            <?php echo $form->error($sellerModel,'seller_type'); ?>
        </div>
        
        <div class="row">
            <label>
                <?php echo strtolower(Yii::t('base', 'Default Comission Rate')); ?>:
                <?php echo (Yii::app()->params['payment']['default_comission_rate'] * 100) . '%'; ?>
            </label>
            <label>
                <?php echo Yii::t('base', 'leave this field blank if you want to use default comission for this user'); ?>
            </label>
            <?php echo $form->labelEx($sellerModel,'comission_rate'); ?>
            <?php echo $form->textField($sellerModel,'comission_rate',array('size'=>3,'maxlength'=>3, 'value' => $sellerModel->comission_rate * 100)); ?>
            <?php echo $form->error($sellerModel,'comission_rate'); ?>
        </div>
        
        <div class="row">
            <?php echo $form->labelEx($sellerModel,'paypal_email'); ?>
            <?php echo $form->textField($sellerModel,'paypal_email',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($sellerModel,'paypal_email'); ?>
        </div>
    </div>
    
    <div class="form-actions">
        <div class="offset2">
            <?php echo CHtml::submitButton(($model->isNewRecord ? Yii::t('base', 'Create') : Yii::t('base', 'Save')), array('class' => 'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('base', 'Back'), ($model->isNewRecord ?
                array('/control/users/index') :
                //array('/control/users/view', 'id' => $model->id)),
                array('/control/users/index' . $backParameters)),
                array('class' => 'btn btn-primary')); ?>
        </div>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
    $(document).ready(function() {
        $("#User_type").change(function() {
            if ($(this).val() == <?= User::SELLER; ?>) {
                $("#seller_info").show();
            } else {
                $("#seller_info").hide();
            }
        });
    });
</script>