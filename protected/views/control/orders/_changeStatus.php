<?php
CHtml::$afterRequiredLabel = '';

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'order-form',
)); ?>
    <div class="row">
        <div style="margin-left: 30px;">
            <?php echo $form->labelEx($model, 'status'); ?>
            <?php echo $form->dropDownList($model, 'status', $model->getStatus()); ?>
            <?php echo $form->error($model, 'status'); ?>
        </div>
    </div>

    <div class="form-actions">
        <div class="offset2">
            <?php echo CHtml::submitButton(Yii::t('base', 'Save'), array('class' => 'btn btn-success')); ?>
            <?php echo CHtml::link(Yii::t('base', 'Close'), '#', array('class' => 'btn btn-primary', 'onclick' => '$("#changeStatus").dialog("close");')); ?>
        </div>
    </div>
<?php
$this->endWidget();
?>