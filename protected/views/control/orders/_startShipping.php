<?php
CHtml::$afterRequiredLabel = '';

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'start-shipping-form',
    'enableAjaxValidation'=>true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
<?php if (empty($model->shipping_status)): ?>
    <div class="row">
        <div style="margin-left: 30px;">
            <label for="seller_email"><?= Yii::t('base', 'Seller Email'); ?></label>
            <input type="text" value="<?= CHtml::encode($model->product->user->email); ?>" name="seller_email">
            <div id="seller_email_errors" class="errorMessage" style=""></div>
        </div>
    </div>

    <div class="row">
        <div style="margin-left: 30px;">
                <?php echo CHtml::activeLabel($model, 'document', array('required' => true)); ?>
                <?php echo $form->fileField($model,'document'); ?>
                <?php echo $form->error($model,'document'); ?>
        </div>
    </div>
<?php else: ?>
    <?= Yii::t('base', 'Coupon Already Sent'); ?>
<?php endif; ?>

    <div class="form-actions">
        <div class="offset2">
            <?php if (empty($model->shipping_status)): echo CHtml::submitButton(Yii::t('base', 'Send'), array('class' => 'btn btn-success', 'id' => 'send')); endif; ?>
            <?php echo CHtml::link(Yii::t('base', 'Close'), '#', array('class' => 'btn btn-primary', 'onclick' => '$("#startShipping").dialog("close");')); ?>
        </div>
    </div>
<?php
$this->endWidget();
?>

<script>
    $('#send').click(function(e){
        e.preventDefault();
        var filename = $('#OrderItem_document').val();
        var email = $('input[name=seller_email]').val();
        if(email == '') {
            $('#seller_email_errors').html('<p style="color:red;">*required</p>');
            $('#seller_email_errors').show();
        }
        if(filename == '') {
            $('#OrderItem_document_em_').html('<p style="color:red;">*required</p>');
            $('#OrderItem_document_em_').show();
        } else {
            $('#start-shipping-form').submit();
        }
        $('#OrderItem_document').change(function() {
            var filename = $('#OrderItem_document').val();
            if(filename != '') {
                $('#OrderItem_document_em_').hide();
            }
        });
        $('input[name=seller_email]').change(function() {
            var email = $('input[name=seller_email]').val();
            if(email != '') {
                $('#seller_email_errors').hide();
            }
        });
    })
</script>
