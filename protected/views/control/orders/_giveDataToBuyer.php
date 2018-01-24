<?php
CHtml::$afterRequiredLabel = '';

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'give-data-form',
    'enableAjaxValidation'=>true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
<?php if(empty($model->tracking_number)) : ?>
<div class="row">
    <div style="margin-left: 30px;">
        <label for="buyer_email"><?= Yii::t('base', 'Buyer Email'); ?></label>
        <input type="text" value="<?= CHtml::encode($model->order->user->email); ?>" name="buyer_email">
        <div id="buyer_email_errors" class="errorMessage" style=""></div>
    </div>
</div>

<div class="row">
    <div style="margin-left:30px">
        <div class="checkbox">
            <label><input type="checkbox" id="haveTrackNo" value="">We have tracking No.</label>
        </div>
    </div>
</div>

<div class="row" id="forNumber">
    <div style="margin-left: 30px;">
        <label for="tracking_number"><?= Yii::t('base', 'Tracking number'); ?></label>
        <input type="text" name="tracking_number">
        <div id="tracking_number_errors" class="errorMessage" style=""></div>
    </div>
</div>

<div class="row" id="forLink">
    <div style="margin-left: 30px;">
        <label for="link"><?= Yii::t('base', 'Tracking link'); ?></label>
        <input type="text" name="link">
        <div id="link_errors" class="errorMessage" style=""></div>
    </div>
</div>
<?php else: ?>
    <?= Yii::t('base', 'Data Already Sent'); ?>
<?php endif; ?>

<div class="form-actions">
    <div class="offset2">
        <?php if (empty($model->tracking_number)): echo CHtml::submitButton(Yii::t('base', 'Send'), array('class' => 'btn btn-success', 'id' => 'send')); endif; ?>
        <?php echo CHtml::link(Yii::t('base', 'Close'), '#', array('class' => 'btn btn-primary', 'onclick' => '$("#giveDataToBuyer").dialog("close");')); ?>
    </div>
</div>
<?php
$this->endWidget();
?>

<script>
    $(document).ready(function () {
        $('#forNumber').hide();
        $('#forLink').hide();

        $("#haveTrackNo").change(function() {
            if($("#haveTrackNo").prop("checked")) {
                $('#forNumber').show();
                $('#forLink').show();
            } else {
                $('#forNumber').hide();
                $('#forLink').hide();
            }
        });
    });
    $('#send').click(function(e){
        e.preventDefault();
        var email = $('input[name=buyer_email]').val();
        var trackingNumber = $('input[name=tracking_number]').val();
        var trackingLink = $('input[name=link]').val();

        if($("#haveTrackNo").prop("checked")) {
            if(email == '') {
                $('#buyer_email_errors').html('<p style="color:red;">*required</p>');
                $('#buyer_email_errors').show();
            }
            if (trackingNumber == '') {
                $('#tracking_number_errors').html('<p style="color:red;">*required</p>');
                $('#tracking_number_errors').show();
            }
            if (trackingLink == '') {
                $('#link_errors').html('<p style="color:red;">*required</p>');
                $('#link_errors').show();
            }
            else {
                $('#give-data-form').submit();
            }
        } else {
            if(email == '') {
                $('#buyer_email_errors').html('<p style="color:red;">*required</p>');
                $('#buyer_email_errors').show();
            }
            else {
                $('#give-data-form').submit();
            }
        }
        $('input[name=buyer_email]').change(function() {
            var email = $('input[name=buyer_email]').val();
            if(email != '') {
                $('#buyer_email_errors').hide();
            }
        });
        $('input[name=tracking_number]').change(function() {
            var trackingNumber = $('input[name=tracking_number]').val();
            if(trackingNumber != '') {
                $('#tracking_number_errors').hide();
            }
        });
        $('input[name=link]').change(function() {
            var trackingLink = $('input[name=link]').val();
            if(trackingLink != '') {
                $('#link_errors').hide();
            }
        });
    });

</script>
