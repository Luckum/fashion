<?php
/* @var $this ProfileController */

$this->breadcrumbs = array(
    'Client Area' => array('members/index'),
    'Account Settings' => '',
);
$countriesAr = json_encode(array_flip(Yii::app()->params['countries']));
?>
<div class="uk-block uk-margin-large-top">
    <div class="uk-container uk-container-center">
        <div>
            <div class="uk-text-center uk-position-relative">
                <div
                    class="uk-h1 uk-margin-small-bottom uk-display-inline-block uk-margin-right"><?= Yii::t('base', 'Bag') ?></div>
                <ul data-uk-switcher="{connect:'#step'}"
                    class="uk-list-switcher uk-list-switcher-position uk-margin-small-bottom">
                    <li><a href="">1. <?= Yii::t('base', 'Cart') ?></a></li>
                    <li><a href="">2. <?= Yii::t('base', 'Checkout') ?></a></li>
                    <li><a href="">3. <?= Yii::t('base', 'Order complete') ?></a></li>
                </ul>
            </div>
            <ul id="step" class="uk-switcher">
                <!--FIRST SWITCH-->
                <li>
                    <?php $this->renderPartial('_checkout_cart_1',
                        array('total' => $total, 'user' => $user, 'returnUrl' => $returnUrl)); ?>
                </li>
                <!--END FIRST SWITCH-->
                <!--SECOND SWITCH-->
                <li>
                    <div class="uk-grid">
                        <div class="uk-width-1-1 uk-width-large-5-6 uk-width-medium-5-6 uk-width-small-1-1 uk-push-1-6">
                            <div>
                                <div class="uk-margin-large-right uk-margin-small-bottom">
                                    <b><?= Yii::t('base', 'Your shipping information') ?></b>
                                </div>
                                <div class="uk-hidden-large uk-block-border">
                                    <div class="uk-text-center uk-margin-bottom">
                                        <b><?= Yii::t('base', 'Order summary') ?></b></div>
                                    <div class="uk-flex uk-flex-center uk-text-line-height">
                                        <div class="uk-text-right uk-margin-right">
                                            <div class="uk-margin-bottom-mini"><?= Yii::t('base', 'Your cart') ?></div>
                                            <div class="uk-margin-bottom-mini"><?= Yii::t('base', 'Shipping') ?></div>
                                            <div class="uk-margin-bottom-mini"><b><?= Yii::t('base', 'Total') ?></b>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="uk-margin-bottom-mini">&euro;&nbsp;<span
                                                    class="your_cart_cost"><?= $total ?></span></div>
                                            <div class="uk-margin-bottom-mini">&euro;&nbsp;<span
                                                    class="shipping_cost"></span></div>
                                            <div class="uk-margin-bottom-mini"><b>&euro;&nbsp;<span
                                                        class="total_cost"><?= $total ?></span></b></div>
                                        </div>
                                    </div>
                                    <div class="uk-text-center uk-margin-large-top">
                                        <a href="#"
                                           class="uk-button place_order_link"><?= Yii::t('base', 'place order') ?></a>
                                    </div>
                                    <div class="uk-text-center uk-margin-top">
                                        <?php echo CHtml::link('‹ ' . Yii::t('base', 'continue shopping'), $this->createAbsoluteUrl('/members/index/index'), array('class' => 'uk-base-link')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="uk-grid shopping-cart-form-wrapper">
                        <?php $this->renderPartial('_checkout_cart_2', array('user' => $user, 'shipping_address' => $shipping_address)); ?>
                        <div
                            class="uk-width-1-1 uk-width-large-1-4 uk-width-medium-1-1 uk-width-small-1-1 uk-push-2-10">
                            <div class="uk-block-border uk-visible-large">
                                <div class="uk-text-center uk-margin-bottom">
                                    <b><?= Yii::t('base', 'Order summary') ?></b></div>
                                <div class="uk-flex uk-flex-center uk-text-line-height">
                                    <div class="uk-text-right uk-margin-right">
                                        <div class="uk-margin-bottom-mini"><?= Yii::t('base', 'Your cart') ?></div>
                                        <div class="uk-margin-bottom-mini"><?= Yii::t('base', 'Shipping') ?></div>
                                        <div class="uk-margin-bottom-mini"><b><?= Yii::t('base', 'Total') ?></b></div>
                                    </div>
                                    <div>
                                        <div class="uk-margin-bottom-mini">&euro;&nbsp;<span
                                                class="your_cart_cost"><?= $total ?></span></div>
                                        <div class="uk-margin-bottom-mini">&euro;&nbsp;<span
                                                class="shipping_cost"></span></div>
                                        <div class="uk-margin-bottom-mini"><b>&euro;&nbsp;<span
                                                    class="total_cost"><?= $total ?></span></b></div>
                                    </div>
                                </div>
                                <div class="uk-text-center uk-margin-large-top">
                                    <a href="#"
                                       class="uk-button place_order_link"><?= Yii::t('base', 'place order') ?></a>
                                </div>
                                <div class="uk-text-center uk-margin-top">
                                    <?php echo CHtml::link('‹ ' . Yii::t('base', 'continue shopping'), $this->createAbsoluteUrl('/members/index/index'), array('class' => 'uk-base-link')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <!--END SECOND SWITCH-->
                <!--THIRD SWITCH-->
                <li>
                    <div class="uk-grid">
                        <div class="uk-width-1-1 uk-width-large-5-6 uk-width-medium-5-6 uk-width-small-1-1 uk-push-1-6">
                            <div>
                                <div class="uk-margin-large-right uk-margin-small-bottom">
                                </div>
                                <div class="uk-hidden-large uk-block-border">
                                    <div class="uk-text-center uk-margin-bottom">
                                        <b><?= Yii::t('base', 'Order summary') ?></b></div>
                                    <div class="uk-flex uk-flex-center uk-text-line-height">
                                        <div class="uk-text-right uk-margin-right">
                                            <div class="uk-margin-bottom-mini"><?= Yii::t('base', 'Your cart') ?></div>
                                            <div class="uk-margin-bottom-mini"><?= Yii::t('base', 'Shipping') ?></div>
                                            <div class="uk-margin-bottom-mini"><b><?= Yii::t('base', 'Total') ?></b>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="uk-margin-bottom-mini">&euro;&nbsp;<span
                                                    class="your_cart_cost"><?= $total ?></span></div>
                                            <div class="uk-margin-bottom-mini">&euro;&nbsp;<span
                                                    class="shipping_cost"></span></div>
                                            <div class="uk-margin-bottom-mini"><b>&euro;&nbsp;<span
                                                        class="total_cost"><?= $total ?></span></b></div>
                                        </div>
                                    </div>
                                    <div class="uk-text-center uk-margin-large-top">
                                        <?php echo CHtml::link(Yii::t('base', 'view order'), $this->createAbsoluteUrl('members/profile/history'), array('class' => 'uk-button')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="uk-grid shopping-cart-form-wrapper">
                        <?php $this->renderPartial('_checkout_cart_3'); ?>
                        <div
                            class="uk-width-1-1 uk-width-large-1-4 uk-width-medium-1-1 uk-width-small-1-1 uk-push-2-10">
                            <div class="uk-block-border uk-visible-large">
                                <div class="uk-text-center uk-margin-bottom">
                                    <b><?= Yii::t('base', 'Order summary') ?></b></div>
                                <div class="uk-flex uk-flex-center uk-text-line-height">
                                    <div class="uk-text-right uk-margin-right">
                                        <div class="uk-margin-bottom-mini"><?= Yii::t('base', 'Your cart') ?></div>
                                        <div class="uk-margin-bottom-mini"><?= Yii::t('base', 'Shipping') ?></div>
                                        <div class="uk-margin-bottom-mini"><b><?= Yii::t('base', 'Total') ?></b></div>
                                    </div>
                                    <div>
                                        <div class="uk-margin-bottom-mini">&euro;&nbsp;<span
                                                class="your_cart_cost"><?= isset($inYourCart) ? $inYourCart : '' ?></span></div>
                                        <div class="uk-margin-bottom-mini">&euro;&nbsp;<span
                                                class="shipping_cost"><?= isset($shipping_cost) ? $shipping_cost : '' ?></span></div>
                                        <div class="uk-margin-bottom-mini"><b>&euro;&nbsp;<span
                                                    class="total_cost"><?= isset($total) ? $total : '' ?></span></b></div>
                                    </div>
                                </div>
                                <div class="uk-text-center uk-margin-large-top">
                                    <?php echo CHtml::link(Yii::t('base', 'view order'), $this->createAbsoluteUrl('members/profile/history'), array('class' => 'uk-button')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <!--END THIRD SWITCH-->
            </ul>
        </div>
    </div>
</div>

<script type="text/javascript">
    function selectCountryShipping(country_name, country_id, onload) {
        $('#shipping_country_id').val(country_id);
        $('#shipping').val(country_name);
        $('#hidden_shipping').val(country_id);

        // default for pay-country autocomplete
        //
        onload = typeof onload !== 'undefined' ? onload : false;

        if(onload){
            $('#country_pay').val(country_id);
            $('#input_country_pay').val(country_name);
        }

        $.ajax({
            type: 'POST',
            data: {id: country_id},
            url: globals.url + '/members/shop/shippingRate',
            success: function (data, textStatus, jqXHR) {
                $(".shipping_cost").html(data);
                var shippingValue = !isNaN(parseInt(data)) ? parseInt(data) : 0;
                $(".total_cost").html(shippingValue + parseInt($("#subtotal_cost").text()));
                $("#amount").val(shippingValue + parseInt($("#subtotal_cost").text()));
            }
        });

        return false;
    }

    function selectCountryPay(country_name, country_id) {
        $('#country_pay').val(country_id);
        $('#input_country_pay').val(country_name);
    }

    jQuery(document).ready(function ($) {

        <?php if(!empty($orderComplete)): ?>
        $('ul.uk-list-switcher li:nth-child(3)').addClass('uk-active');
        <?php endif; ?>
        <?php if(isset($user->country)): ?>

        selectCountryShipping(
            '<?php echo $user->country->name; ?>',
            <?php echo $user->country_id; ?>);

        //debugCountry();

        <?php endif; ?>

        <?php if(isset($shipping_address->country)): ?>

        selectCountryShipping(
            '<?php echo $shipping_address->country->name; ?>',
            <?php echo $shipping_address->country_id; ?>,
            true);

        //debugCountry();

        <?php endif; ?>

        $('.country_input').autocomplete({
            source: function (request, response) {
                var source = <?php echo Country::jquery_source(); ?>;
                var data = getDataForAutocomplete(request, source);
                response(data);
            },
            select: function (event, ui) {
                var item = ui.item;
                $(this).val(item.label);
                var hidden = $(this).parent().children('.country_hidden');
                $(hidden).val(item.value);

                if(event.target.id == 'shipping'){
                    selectCountryShipping(item.label, item.value, false);
                }else{
                    selectCountryPay(item.label, item.value);
                }

                //debugCountry();

                return false;
            }
        });

        $(document).on("click", '.place_order_link', function () {
            $('#continueButton').click();
        });

        $(document).on("click", '.cart_checkout_link', function () {
            $('ul.uk-list-switcher li:nth-child(2) a').click();
        });

        $('.delete-item').on('click', function () {
            if (confirm('<?= Yii::t('base', 'Are you sure you want remove this item from bag?') ?>')) {
                var url = globals.url + '/members/shop/removeFromBagGetNewData';
                var id = $(this).data('id');
                var shipping_country_id = $('#shipping_country_id').val();
                var row = $('tr[data-id="' + id + '"]');
                var data = {'id': id, 'shipping_country_id': shipping_country_id};
                $.post(url, data, function (response) {
                    $('#cart').html(response.cart);
                    scrollbar();
                    $('#cart_bag_count').html(response.cart_bag_count);
                    $('#subtotal_cost, .your_cart_cost').html(response.cart_cost);
                    $('.shipping_cost').html(response.shipping_cost);
                    $('.total_cost').html(response.total_cost);
                }, "json");
                row.hide('slow', function () {
                    row.remove();
                });
            }
        });

        $('#phone, #zip_code').keyup(function (e) {
            this.value = this.value.replace(/^\.|[^\d\.]|\.(?=.*\.)|^0+(?=\d)/g, '');
        });

        $(document).on("click", '.place_order', function () {
            var error = false;
            $(".cart_error").each(function (indx, element) {
                $(element).hide();
            });

            if (!$("#email").val()) {
                error = true;
                showError($("#email"));
            }

            if (!$("#firstname").val()) {
                error = true;
                showError($("#firstname"));
            }

            if (!$("#lastname").val()) {
                error = true;
                showError($("#lastname"));
            }

            if (!$("#address").val()) {
                error = true;
                showError($("#address"));
            }

            // if (!$("#address2").val()) {
            //     error = true;
            //     showError($("#address2"));
            // };
            if (!$("#zip_code").val()) {
                error = true;
                showError($("#zip_code"));
            }

            if (!$("#city").val()) {
                error = true;
                showError($("#city"));
            }

            if (!$("#phone").val()) {
                error = true;
                showError($("#phone"));
            }

            if ($("#country_pay").val() == '') {
                error = true;
                showError($("#country_pay"));
            }

            // if ($.type($("input[name=PaymentSystem]:checked").val()) != 'string') {
            //  error = true;
            //  showError($("#PaymentSystem"));
            // };
            if ($("input[name=agreeCookies]:checked").val() != 1) {
                error = true;
                showError($("#agreeCookies").parent().next());
            }

            if (error) {
                return false;
            }
        });
    });

    function showError(el) {
        el.closest("div.uk-form-row").find(".cart_error").show();
    }

    function debugCountry(){
        console.log('shipping country id - ');
        console.log($('#shipping_country_id').val());

        console.log('shipping country name - ');
        console.log($('#shipping').val());

        console.log('shipping country id - ');
        console.log($('#hidden_shipping').val());

        console.log('pay country name - ');
        console.log($('#input_country_pay').val());

        console.log('pay country id - ');
        console.log($('#country_pay').val());
    }

</script>
