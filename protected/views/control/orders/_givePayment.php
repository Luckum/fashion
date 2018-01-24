<?php
CHtml::$afterRequiredLabel = '';
?>
<div style="margin-left: 30px;">
    <div class="row">
        <label for="seller_mail"><?= Yii::t('base', 'Seller Paypal Email'); ?></label>
        <input type="text" id="seller_mail" value="<?=$model->product->user->sellerProfile->paypal_email?>" readonly>
    </div>

    <div class="row">
        <label for="product"><?= Yii::t('base', 'Product'); ?></label>
        <input type="text" id="product" value="<?=$model->product->brand->name.", ".
            $model->product->title.", size " .
        (empty($model -> product -> size_chart) ? Yii :: t('base', 'No size') : $model -> product -> size_chart -> size) . ", ID#".
            $model->product->id?>" readonly>
    </div>

    <div class="row">
        <label for="item_price"><?= Yii::t('base', 'Item price'); ?></label>
        <input type="text" id="item_price" value="<?php echo $model->itemPrice?>" readonly>
    </div>

    <div class="row">
        <label for="subtotal"><?= Yii::t('base', 'Subtotal'); ?></label>
        <input type="text" id="subtotal" value="<?php echo $model->subtotal?>">
    </div>

    <div class="row">
        <label for="shipping_fee"><?= Yii::t('base', 'Shipping fee'); ?></label>
        <input type="text" id="shipping_fee" value="<?php echo $model->shipping_cost?>">
    </div>

    <div class="row">
        <label for="comission"><?= Yii::t('base', 'Your comission'); ?></label>
        <input type="text" id="comission" value="<?php echo $model->comission?>">
    </div>

    <div class="row">
        <label for="paypal_comission"><?= Yii::t('base', 'Paypal comission'); ?></label>
        <input type="text" id="paypal_comission" value="<?php echo $model->paypalComission?>" readonly>
    </div>

    <div class="row">
        <label for="total"><?= Yii::t('base', 'Total'); ?></label>
        <input type="text" id="total" value="<?php echo $model->totalWithPaypalComission?>" readonly>
    </div>

    <?php 
        $currency = Yii::app()->params['payment']['currency'];
        if (PAYPAL_SANDBOX) {
            $currency = 'USD';
        }
     ?>


    <div class="row">
        <form id="payform" name="_xclick" action="https://www.<?php if (PAYPAL_SANDBOX) echo 'sandbox.'?>paypal.com/ru/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="no_shipping" value="1">
            <input type="hidden" name="business" value="<?=$model->product->user->sellerProfile->paypal_email?>">
            <input type="hidden" name="currency_code" value="<?=$currency?>">
            <input type="hidden" name="item_name" value="<?=$model->product->brand->name." ".
            $model->product->title.", size ".
            empty($model -> product -> size_chart) ? Yii :: t('base', 'No size') : $model -> product -> size_chart -> size . ", ID#".
            $model->product->id?>">
            <input type="hidden" name="item_number" value="<?=$model->id?>">
            <input type="hidden" id="amount" name="amount" value="<?=$model->totalWithPaypalComission?>">
            <input type="hidden" name="notify_url" value="<?=$this->createAbsoluteUrl('/members/shop/ipnVendorPay',array('id' => $model->id))?>">
            <input type="hidden" name="return" value="<?=$this->createAbsoluteUrl('/control/orders')?>">
            <input type="hidden" name="cancel_return" value="<?=$this->createAbsoluteUrl('/control/orders')?>">
            <input type="submit" name="submit" value="<?=Yii::t('base', 'Pay Now')?>" class="btn btn-success">
            <?php echo CHtml::link(Yii::t('base', 'Close'), '#', array('class' => 'btn btn-primary', 'onclick' => '$("#givePayment").dialog("close");')); ?>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#subtotal, #shipping_fee, #comission").keyup(function (e) {
            var subtotal = parseFloat($('#subtotal').val());
            var shipping_fee = parseFloat($('#shipping_fee').val());
            var comission = parseFloat($('#comission').val());
            total = Math.round((subtotal + shipping_fee - comission) * 100) / 100;
            totalWithCommision = (total + <?=OrderItem::USD_PAY?>)/(1 - <?=OrderItem::USD_FEE_PERCENT?>);
            var paypal_comission = Math.round((totalWithCommision - total) * 100) / 100;
            $('#paypal_comission').val(paypal_comission);

            if (isNaN(total)) totalWithCommision = 0;
            
            $('#total').val(totalWithCommision.toFixed(2));
            $('#amount').val(totalWithCommision.toFixed(2));
        });

        $("#subtotal, #shipping_fee, #comission").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                 // Allow: Ctrl+A, Command+A
                (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
                 // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                     // let it happen, don't do anything
                     return;
            }

            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

        $('#payform').on('submit', function () {
            var total = $('#total').val();
            if (total == 0) {
                alert('<?= Yii::t('base', 'You cannot send this price') ?>');
                return false;
            }
            var message = '<?= Yii::t('base', 'Are you sure you want payout ') ?>' + total + ' euro?';
            return confirm(message);
        });
    });
</script>
