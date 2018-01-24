<?php
/* @var $this ProfileController */

$this->breadcrumbs = array(
    'Client Area' => array('members/index'),
    'Account Settings' => '',
);
$allCountries = Country::getListIdCountry();
?>

<!--ACCOUNT BLOCK-->
<div id="div-account-block" class="uk-block uk-block-large uk-margin-top">
    <div class="uk-container uk-container-center">
        <div class="uk-accordion account-wrapper" data-uk-accordion='{showfirst: true, animate: false}'>
            <div class="uk-grid">
                <div class="uk-width-large-7-10 uk-width-medium-7-10 uk-width-small-1-1">
                    <div class="uk-grid">
                        <!--PROFILE NAV-->
                        <?php $this->renderPartial('_profile_nav', array('showProfile' => (isset($showProfile) ? true : false))); ?>
                        <!--END PROFILE NAV-->
                        <!--SETTINGS-->
                        <div class="uk-width-1-1 uk-width-large-3-4 uk-width-medium-1-1 uk-width-small-1-1">
                            <div class="uk-margin-left uk-margin-right">
                                <div class="uk-h4 uk-margin-bottom uk-margin-neg-top-small">
                                    <b><?php echo Yii::t('base', 'Settings'); ?></b>
                                </div>

                                <?php $form = $this->beginWidget('CActiveForm', array(
                                    'id' => 'settings-form',
                                    'htmlOptions' => array(
                                        'class' => 'uk-form uk-form-modal'
                                    ),
                                    'enableClientValidation' => true
                                )); ?>

                                <?php //echo $form->errorSummary(array($model, $sellerProfile, $shippingAddresses)); ?>

                                <div class="uk-grid uk-margin-large-top">
                                    <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="uk-form-row">
                                            <?php echo CHtml::activeLabel($model, 'username', array(
                                                'class' => 'uk-form-label',
                                            )); ?>
                                            <div class="uk-form-controls uk-margin-small-top">
                                                <?php echo $form->textField($model, 'username'); ?>
                                                <?php echo $form->error($model, 'username'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="uk-from-row margin-top-small-screen">
                                            <?php echo CHtml::activeLabel($model, 'email', array(
                                                'class' => 'uk-form-label'
                                            )); ?>
                                            <div class="uk-form-controls uk-margin-small-top">
                                                <?php echo $form->textField($model, 'email'); ?>
                                                <?php echo $form->error($model, 'email'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-grid uk-margin-large-top">
                                    <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="uk-form-row">
                                            <?php echo CHtml::activeLabel($model, 'country_id', array(
                                                'class' => 'uk-form-label'
                                            )); ?>
                                            <div class="uk-form-conrols uk-form-select">
                                                <!--                                                --><?php //echo $form->dropDownList($model, 'country_id', $allCountries, array(
                                                //                                                    'class' => 'js-select uk-margin-small-top'
                                                //                                                )); ?>
                                                <input id="input-user-country" class="country_input" type="text"/>
                                                <input id="hidden-user-country" name="User[country_id]" type="hidden"
                                                       class="country_hidden"/>
                                                <?php echo $form->error($model, 'country_id'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-grid uk-margin-large-top">
                                    <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="uk-form-row">
                                            <?php echo CHtml::activeLabel($model, 'password', array(
                                                'class' => 'uk-form-label'
                                            )); ?>
                                            <div class="uk-form-controls uk-margin-small-top">
                                                <?php echo $form->passwordField($model, 'password', array(
                                                    'value' => '',
                                                    //'placeholder' => Yii::t('base', 'type new password')
                                                )); ?>
                                                <?php echo $form->error($model, 'password'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="uk-form-row margin-top-small-screen">
                                            <?php echo CHtml::activeLabel($model, 'password2', array(
                                                'class' => 'uk-form-label')); ?>
                                            <div class="uk-form-controls uk-margin-small-top">
                                                <?php echo $form->passwordField($model, 'password2', array(
                                                    'class' => 'span12',
                                                    'value' => '',
                                                    //'placeholder' => Yii::t('base', 're-type new password')
                                                )); ?>
                                                <?php echo $form->error($model, 'password2'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="uk-grid uk-margin-large-top">
                                    <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="uk-form-row">
                                            <?php echo CHtml::activeLabel($sellerProfile, 'paypal_email', array(
                                                'class' => 'uk-form-label'
                                            )); ?>
                                            <div class="uk-form-controls uk-margin-small-top">
                                                <?php echo $form->textField($sellerProfile, 'paypal_email', array(
                                                    'class' => 'hidden_error',
                                                )); ?>
                                                <?php //echo $form->error($shippingAddresses, 'phone'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="uk-grid uk-margin-large-top">
                                    <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="uk-text-center uk-margin-bottom"><b>Your shipping information</b>
                                        </div>
                                    </div>
                                </div>

                                <div class="uk-grid uk-margin-large-top">
                                    <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="uk-form-row">
                                            <?php echo CHtml::activeLabel($shippingAddresses, 'first_name', array(
                                                'class' => 'uk-form-label'
                                            )); ?>
                                            <div class="uk-form-controls uk-margin-small-top">
                                                <?php echo $form->textField($shippingAddresses, 'first_name', array(
                                                    'class' => 'hidden_error'
                                                )); ?>
                                                <?php //echo $form->error($shippingAddresses, 'first_name'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-grid uk-margin-large-top">
                                    <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="uk-form-row">
                                            <?php echo CHtml::activeLabel($shippingAddresses, 'surname', array(
                                                'class' => 'uk-form-label'
                                            )); ?>
                                            <div class="uk-form-controls uk-margin-small-top">
                                                <?php echo $form->textField($shippingAddresses, 'surname', array(
                                                    'class' => 'hidden_error'
                                                )); ?>
                                                <?php //echo $form->error($shippingAddresses, 'surname'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="uk-grid uk-margin-large-top">
                                    <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="uk-form-row">
                                            <?php echo CHtml::activeLabel($shippingAddresses, 'address', array(
                                                'class' => 'uk-form-label'
                                            )); ?>
                                            <div class="uk-form-controls uk-margin-small-top">
                                                <?php echo $form->textField($shippingAddresses, 'address', array(
                                                    'class' => 'hidden_error',
                                                )); ?>
                                                <?php //echo $form->error($shippingAddresses, 'address'); ?>
                                                <?php echo $form->textField($shippingAddresses, 'address_2', array(
                                                    'class' => 'hidden_error',
                                                )); ?>
                                                <?php //echo $form->error($shippingAddresses, 'address_2'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="uk-form-row margin-top-small-screen">
                                            <?php echo CHtml::activeLabel($shippingAddresses, 'zip', array(
                                                'class' => 'uk-form-label'
                                            )); ?>
                                            <div class="uk-form-controls uk-margin-small-top">
                                                <?php echo $form->textField($shippingAddresses, 'zip', array(
                                                    'class' => 'hidden_error',
                                                )); ?>
                                                <?php //echo $form->error($shippingAddresses, 'zip'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="uk-grid uk-margin-large-top">
                                    <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="uk-form-row">
                                            <?php echo CHtml::activeLabel($shippingAddresses, 'country_id', array(
                                                'class' => 'uk-form-label hidden_error'
                                            )); ?>
                                            <div class="uk-form-controls uk-form-select">
                                                <!--                                                --><?php //echo $form->dropDownList(
                                                //                                                    $shippingAddresses,
                                                //                                                    'country_id',
                                                //                                                    $allCountries,
                                                //                                                    array(
                                                //                                                        'class' => 'js-select uk-margin-small-top hidden_error'
                                                //                                                    )); ?>
                                                <input id="input-shipping-country" class="country_input" type="text"/>
                                                <input id="hidden-shipping-country" name="ShippingAddress[country_id]"
                                                       type="hidden"
                                                       class="country_hidden"/>
                                                <?php //echo $form->error($shippingAddresses, 'country_id'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="uk-grid uk-margin-large-top">
                                    <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="uk-form-row">
                                            <?php echo $form->labelEx($shippingAddresses, 'state', array(
                                                'class' => 'uk-form-label'
                                            )); ?>
                                            <div class="uk-form-controls uk-margin-small-top">
                                                <?php echo $form->textField($shippingAddresses, 'state', array(
                                                    'class' => 'hidden_error'
                                                )); ?>
                                                <?php //echo $form->error($shippingAddresses, 'state'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="uk-grid uk-margin-large-top">
                                    <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="uk-form-row">
                                            <?php echo CHtml::activeLabel($shippingAddresses, 'city', array(
                                                'class' => 'uk-form-label'
                                            )); ?>
                                            <div class="uk-form-controls uk-margin-small-top">
                                                <?php echo $form->textField($shippingAddresses, 'city', array(
                                                    'class' => 'hidden_error',
                                                )); ?>
                                                <?php //echo $form->error($shippingAddresses, 'city'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="uk-grid uk-margin-large-top">
                                    <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                                        <div class="uk-form-row">
                                            <?php echo CHtml::activeLabel($shippingAddresses, 'phone', array(
                                                'class' => 'uk-form-label'
                                            )); ?>
                                            <div class="uk-form-controls uk-margin-small-top">
                                                <span class="tel">
                                                +&nbsp;
                                                <?php echo $form->textField($shippingAddresses, 'phone', array(
                                                    'class' => 'hidden_error'
                                                )); ?></span>
                                                <?php //echo $form->error($shippingAddresses, 'phone'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="uk-grid uk-margin-large-top">
                                    <div class="uk-width-1-1">
                                        <div class="uk-text-right uk-margin-bottom">
                                            <?php echo CHtml::submitButton(Yii::t('base', 'submit'), array(
                                                'class' => 'uk-button'
                                            )); ?>
                                        </div>
                                    </div>
                                </div>

                                <?php $this->endWidget(); ?>

                            </div>
                        </div>
                        <!--END SETTINGS-->
                    </div>
                </div>
                <!--PROFILE INFO-->
                <div
                    class="uk-width-1-1 uk-width-large-3-10 uk-width-medium-3-10 uk-width-small-1-1 margin-top-small-screen">
                    <?php $this->renderPartial('_nav_info', array('user' => $model)); ?>
                </div>
                <!--END PROFILE INFO-->
            </div>
        </div>
    </div>
</div>
<!--END ACCOUNT BLOCK-->

<!--MODAL SETTINGS MESSAGE-->
<div id="modal-settings-message" class="uk-modal uk-modal-reply">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="container">
            <div class="uk-margin-large-top"></div>
            <div id="modal-settings-message-content" class="uk-text-center uk-margin-large-bottom"></div>
        </div>
    </div>
</div>

<?php if (isset($message)): ?>

    <script type="text/javascript">
        $(document).ready(function () {
            var modal = UIkit.modal('#modal-settings-message', {center: true});
            modal.show();

            $('#modal-settings-message-content').html('<?php echo $message; ?>');
        });
    </script>

<?php endif; ?>
<!--END MODAL SETTINGS MESSAGE-->

<script type="text/javascript">
    $(document).ready(function () {
        <?php if(isset($model->country)): ?>

        $('#input-user-country').val('<?php echo $model->country->name; ?>');
        $('#hidden-user-country').val('<?php echo $model->country_id; ?>');

        <?php endif; ?>
        <?php if(isset($shippingAddresses->country)): ?>

        $('#input-shipping-country').val('<?php echo $shippingAddresses->country->name; ?>');
        $('#hidden-shipping-country').val(<?php echo $shippingAddresses->country_id; ?>);

        <?php endif; ?>

        $('.hidden_error').removeClass('error');
        $('#ShippingAddress_phone').keyup(function (e) {
            this.value = this.value.replace(/^\.|[^\d\.]|\.(?=.*\.)|^0+(?=\d)/g, '');
        });

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
                return false;
            }
        });
    });
</script>