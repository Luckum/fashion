<div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-1 uk-width-small-1-1 uk-push-1-10">
    <?php echo CHtml::beginForm(array('/members/shop/pay'), 'post', 
        array('class'=>'checkout_cart2 uk-form uk-form-stacked uk-form-modal')); ?>
        <?= CHtml::hiddenField('amount', '' ) ?>
        <?= CHtml::hiddenField('shipping_country_id', '' ) ?>
        <div class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-2 uk-grid-width-medium-1-2 uk-grid-width-small-1-1">
            <div class="uk-form-row">
                <?php echo CHtml::label(Yii::t('base', 'Your paypal email:'), 'email', 
                    array('required' => true, 'class' => 'uk-form-label')); ?>
                <div class="uk-form-controls">
                    <?php echo CHtml::textField('email', (isset($user->sellerProfile->paypal_email) && !empty($user->sellerProfile->paypal_email)) ? $user->sellerProfile->paypal_email : $user->email); ?>
                </div>
                <div class="cart_error"><?= Yii::t('base', 'You must enter your email') ?></div>
            </div>
        </div>
        <div class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-2 uk-grid-width-medium-1-2 uk-grid-width-small-1-1">
            <div>
                <div class="uk-form-row">
                    <?php echo CHtml::label(Yii::t('base', 'First name:'), 'firstname', 
                        array('required' => true, 'class' => 'uk-form-label')); ?>
                    <div class="uk-form-controls">
                        <?php echo CHtml::textField('firstname', $shipping_address->first_name); ?>
                    </div>
                    <div class="cart_error"><?= Yii::t('base', 'You must enter your firstname') ?></div>
                </div>
            </div>
            <div class="margin-top-small-screen">
                <div class="uk-form-row">
                    <?php echo CHtml::label(Yii::t('base', 'Last name:'), 'lastname', 
                        array('required' => true, 'class' => 'uk-form-label')); ?>
                    <div class="uk-form-controls">
                        <?php echo CHtml::textField('lastname', $shipping_address->surname); ?>
                    </div>
                    <div class="cart_error"><?= Yii::t('base', 'You must enter your lastname') ?></div>
                </div>
            </div>

        </div>

        <div class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-2 uk-grid-width-medium-1-2 uk-grid-width-small-1-1">
            <div>
                <div class="uk-form-row">
                    <?php echo CHtml::label(Yii::t('base', 'Address'), 'address',
                        array('required' => true, 'class' => 'uk-form-label')); ?>
                    <div class="uk-form-controls">
                        <div class="uk-margin-small-bottom">
                            <?php echo CHtml::textField('address', $shipping_address->address); ?>
                            <div class="cart_error"><?= Yii::t('base', 'You must enter address') ?></div>
                        </div>
                    </div>
                </div>
                <div class="uk-form-row">
                    <div class="uk-form-controls">
                        <?php echo CHtml::textField('address2', $shipping_address->address_2); ?>
                        <div class="cart_error"><?= Yii::t('base', 'You must enter second address') ?></div>
                    </div>
                </div>
            </div>
            <div class="margin-top-small-screen">
                <div class="uk-form-row">
                    <?php echo CHtml::label(Yii::t('base', 'Post code'), 'zip_code',
                        array('required' => true, 'class' => 'uk-form-label')); ?>
                    <div class="uk-form-controls">
                        <?php echo CHtml::textField('zip_code', $shipping_address->zip); ?>
                    </div>
                    <div class="cart_error"><?= Yii::t('base', 'You must enter your post code') ?></div>
                </div>
            </div>

        </div>

        <div class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-2 uk-grid-width-medium-1-2 uk-grid-width-small-1-1">
            <div>
                <div class="uk-form-row">
                    <?php echo CHtml::label(Yii::t('base', 'State:'), 'state', 
                        array('class' => 'uk-form-label')); ?>
                    <div class="uk-form-controls">
                        <?php echo CHtml::textField('state', $shipping_address->state); ?>
                    </div>
                </div>
                <div class="uk-form-row">
                    <?php echo CHtml::label(Yii::t('base', 'City'), 'city',
                        array('required' => true, 'class' => 'uk-form-label')); ?>
                    <div class="uk-form-controls">
                        <?php echo CHtml::textField('city', $shipping_address->city); ?>
                    </div>
                    <div class="cart_error"><?= Yii::t('base', 'You must enter your city') ?></div>
                </div>
                <div class="uk-form-row">
                    <?php echo CHtml::label(Yii::t('base', 'Phone'), 'phone',
                        array('required' => true, 'class' => 'uk-form-label')); ?>
                    <div class="uk-form-controls">
                        <span>+ </span>
                        <span class="tel"><?php echo CHtml::textField('phone', $shipping_address->phone); ?></span>
                    </div>
                    <div class="cart_error"><?= Yii::t('base', 'You must enter your phone') ?></div>
                </div>
                <div class="uk-form-row">
                    <?php echo CHtml::label(Yii::t('base', 'Country'), 'country_pay',
                        array('required' => true, 'class' => 'uk-form-label')); ?>
                    <div class="uk-form-controls uk-form-select">
<!--                        --><?php //echo CHtml::dropDownList(
//                            'country_pay',
//                            $shipping_address->country_id,
//                            Country::getListIdCountry(),
//                            array('class'=>'selectsort js-select')); ?>
                        <!-- add class country_input for autoComplete and remove readonly-->
                        <input id="input_country_pay" class="country_input input-country-style" type="text" />
                        <input id="country_pay" name="country_pay" type="hidden" class="country_hidden"/>
                        <div class="cart_error" style="margin-top: 10px"><?= Yii::t('base', 'You must enter your country') ?></div>
                    </div>
                </div>
                <div class="form-group-checkbox uk-form-controls uk-margin-large-top">
                    <?php echo CHtml::checkBox('rememberAddress'); ?>
                    <label for="rememberAddress" class="label-checkbox"><span></span><b><?=Yii::t('base', 'Remember this address');?></b></label>
                </div>
                
                <div class="uk-text-center uk-margin-large-top">
                    <div><b><?=Yii::t('base', 'Payment method');?></b></div>
                    <a href="#" class="uk-button uk-button-payment uk-margin-top place_order_link">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ppcom.svg" alt="img" class="smaller-img">
                    </a>
                </div>                
            </div>
        </div>
        <div class="uk-grid uk-grid-width-1-1 uk-grid-width-large-2-2 uk-grid-width-medium-2-2 uk-grid-width-small-1-1 uk-form-row">
            <div>
                <div class="form-group-checkbox uk-form-controls uk-margin-large-top">
                    <?php echo CHtml::checkBox('agreeCookies'); ?>
                    <label for="agreeCookies" class="label-checkbox">
                        <span></span>
                        <?= Yii::t(
                                'base', 
                                'I have read and accept 23-15.com ' . 
                                    CHtml::link('Terms & Conditions', '#terms',
                                        array(
                                            'class' => 'uk-base-link',
                                            'data-uk-modal' => '{center:true}'
                                        )
                                    )
                            );?>
                    </label>                                               
                </div>
                <div class="cart_error" style="margin-top: 10px"><?= Yii::t('base', 'You must agree with terms and conditions') ?>
                </div>
            </div>
        </div>
        <div class="uk-margin-bottom-xlarge ">
            <div class="uk-grid uk-flex uk-flex-middle">
                <div class="uk-width-1-1 uk-width-large-3-3 uk-width-medium-3-3 uk-width-small-3-3 uk-text-right uk-text-center-small">
                    <?php echo CHtml::submitButton(Yii::t('base', 'place order'), array('class'=>'button place_order uk-button', 'id' => 'continueButton')); ?>
                </div>
            </div>
        </div>
    <?php echo CHtml::endForm(); ?>
</div>

<?php 
    list($title, $html) = UtilsHelper::getTermsAndConditionsHtml(); 
?>
<div id="terms" class="uk-modal uk-modal-make-offer">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="uk-container uk-container-left">
            <div class="uk-text-center uk-text-left-small uk-h2 uk-text-normal uk-margin-large-bottom big-line-height">
                <?php echo $title; ?>
            </div>
            <div
                class="uk-grid uk-grid-width-1-1 uk-grid-width-large-2-2 uk-grid-width-medium-2-2 uk-grid-width-small-1-1 uk-push-4-4">
                <div class="uk-margin-large-top uk-text-left uk-text-left-small big-line-height">
                    <?php echo $html; ?>
                </div>
            </div>
        </div>
    </div>
</div>