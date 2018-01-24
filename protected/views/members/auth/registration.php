<?php

/* @var $this LoginController */

$this->breadcrumbs = array(
    'Registration' => '',
);
?>

<!--LOGIN MODAL-->
<div id="signup" class="uk-modal uk-modal-signup" >
    <div class="uk-modal-dialog">
<!--        <a class="uk-modal-close uk-close"></a>-->
        <div class="uk-grid">
            <div class="uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-1">
                <div class="signup-hdr uk-h2 uk-margin-large-bottom">
                    <?php echo Yii::t('base', 'signup'); ?>
                </div>

                <?php $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'registration-form',
                    'htmlOptions' => array(
                        'autocomplete' => 'off',
                        'class' => 'uk-form uk-form-stacked uk-form-modal for-on-submit',
                    ),
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        //'validateOnChange' => true,
                        //'validateOnType' => true,
                    ),

                )); ?>

                <?php //echo $form->errorSummary($model); ?>
                <input type="hidden" name="withoutRedirect" value="<?= $withoutRedirect ?>">
                <input type="hidden" name="commentsForm" value="<?= $commentsForm ?>">
                <div id="div-register-reload">
                    <div class="uk-form-row">
                        <?php echo $form->labelEx($model, 'username', array(
                            'class' => 'uk-form-label'
                        )); ?>
                        <div class="uk-form-controls">
                            <?php echo $form->textField($model, 'username'); ?>
                            <?php echo $form->error($model, 'username'); ?>
                        </div>
                    </div>

                    <div class="uk-form-row">
                        <?php echo $form->labelEx($model, 'email', array(
                            'class' => 'uk-form-label'
                        )); ?>
                        <div class="uk-form-controls">
                            <?php echo $form->textField($model, 'email'); ?>
                            <?php echo $form->error($model, 'email'); ?>
                        </div>
                    </div>

                    <div class="uk-form-row">
                        <?php echo $form->labelEx($model, 'country_id', array(
                            'class' => 'uk-form-label'
                        )); ?>
                        <div class="uk-form-controls">
                            <!--                        --><?php //echo $form->dropDownList(
                            //                            $model,
                            //                            'country_id',
                            //                            Country::getListIdCountry(),
                            //                            array('class' => 'js-select')); ?>

                            <input class="country_input" type="text"/>
                            <input name="User[country_id]" type="hidden" class="country_hidden"/>
                            <?php echo $form->error($model, 'country_id'); ?>
                        </div>
                    </div>

                    <div class="uk-form-row uk-margin-top">
                        <label class="uk-form-label">
                            <?php echo Yii::t('base', 'Create a password') ?>
                        </label>
                        <div class="uk-form-controls">
                            <?php echo $form->passwordField($model, 'password', array('value' => '')); ?>
                            <?php echo $form->error($model, 'password'); ?>
                        </div>
                    </div>
                </div>

                <?php
                $termsLink = UtilsHelper::getTermsAndConditionsLink();
                $privacyLink = UtilsHelper::getPrivacyLink();
                $cookieLink = UtilsHelper::getCookieLink();
                ?>

                <div class="uk-form-row uk-margin-top">
                    <div>
                        <?php $base = $this->createAbsoluteUrl($termsLink); ?>
                        <?php echo Yii::t('base', 'By registering your details you agree to<br/>our'); ?>
                        <a href="<?php echo $base; ?>" class="uk-base-link">
                            <?php echo Yii::t('base', 'Terms and Conditions'); ?>
                        </a>
                        <?php echo Yii::t('base', 'and'); ?>
                        <?php $base = $this->createAbsoluteUrl($privacyLink); ?>
                        <a href="<?php echo $base; ?>" class="uk-base-link">
                            <?php echo Yii::t('base', 'Privacy Policy'); ?>
                        </a>
                        <br/>
                        <br/>
                    </div>
                </div>

                <div class="uk-text-right">
                    <?php echo CHtml::ajaxSubmitButton(
                        Yii::t('base', 'signup'),
                        $this->createUrl('login'),
                        array(
                            'success' => 'function(data){ authResponseHandler(data, "register"); }'
                        ),
                        array(
                            'id' => 'register-ajax-button',
                            'class' => 'uk-button uk-margin-top'
                        )); ?>
                </div>

                <?php $this->endWidget(); ?>
            </div>
            <div class="uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-1 uk-push-1-6">
                <div class="login-hdr uk-h2 uk-margin-large-bottom">
                    <?php echo Yii::t('base', 'login'); ?>
                </div>

                <?php $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'login-form',
                    'htmlOptions' => array(
                        'class' => 'uk-form uk-form-stacked uk-form-modal',
                    ),
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        //'validateOnChange' => true,
                        //'validateOnType' => true,
                    ),
                )); ?>
                <input type="hidden" name="withoutRedirect" value="<?= $withoutRedirect ?>">
                <input type="hidden" name="commentsForm" value="<?= $commentsForm ?>">

                <?php //echo $form->errorSummary($model_login); ?>

                <div id="div-login-reload">

                    <?php echo CHtml::hiddenField('return', (isset($return) ? $return : '')); ?>

                    <div class="uk-form-row">
                        <?php echo $form->labelEx($model_login, 'username', array(
                            'class' => 'uk-form-label'
                        )); ?>
                        <div class="uk-form-controls">
                            <?php echo $form->textField($model_login, 'username'); ?>
                            <?php echo $form->error($model_login, 'username'); ?>
                        </div>
                    </div>

                    <div class="uk-form-row">
                        <?php echo $form->labelEx($model_login, 'password', array(
                            'class' => 'uk-form-label'
                        )); ?>
                        <div class="uk-form-controls">
                            <?php echo $form->passwordField($model_login, 'password', array('value' => '')); ?>
                            <?php echo $form->error($model_login, 'password'); ?>
                        </div>
                    </div>

                </div>

                <div class="uk-margin-top uk-flex uk-flex-space-between">
                    <div>
                        <div class="form-group-checkbox uk-form-controls">
                            <input type="checkbox" id="check" name="LoginForm[rememberMe]"/>
                            <label for="check"
                                   class="label-checkbox"><span></span><?php echo Yii::t('base', 'Remember me') ?>
                            </label>
                        </div>
                    </div>
                    <div>
                        <a href="<?php echo '/members/auth/forgotPassword'; ?>"
                           class="uk-base-link" id="forgot-pass-link">
                            <?php echo Yii::t('base', 'Forgot password?'); ?>
                        </a>
                    </div>
                </div>

                <div class="uk-text-right">
                    <?php //echo CHtml::submitButton(Yii::t('base', 'login'), array('class' => 'uk-button uk-margin-top')); ?>
                    <!--AJAX VERSION-->
                    <?php echo CHtml::ajaxSubmitButton(
                        Yii::t('base', 'login'),
                        $this->createUrl('login'),
                        array(
                            'success' => 'function(data){ authResponseHandler(data, "login"); }'
                        ),
                        array(
                            'id' => 'login-ajax-button',
                            'class' => 'uk-button uk-margin-top'
                        )); ?>
                    <!--END AJAX VERSION-->
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>
<!--END LOGIN MODAL-->

<!--PAGE-->
<div id="page-login-visible" style="visibility: hidden; padding: 10px;">
    <div class="uk-grid">
        <div class="uk-width-medium-1-5"></div>
        <div class="uk-width-medium-3-5">
            <div class="uk-grid uk-grid-medium">
                <div class="uk-width-medium-5-10">
                    <div class="uk-h2 uk-margin-large-bottom">
                        <?php echo Yii::t('base', 'signup'); ?>
                    </div>

                    <?php $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'registration-form',
                        'htmlOptions' => array(
                            'autocomplete' => 'off',
                            'class' => 'uk-form uk-form-stacked uk-form-modal for-on-submit',
                        ),
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            //'validateOnChange' => true,
                            //'validateOnType' => true,
                        ),

                    )); ?>

                    <?php //echo $form->errorSummary($model); ?>                    

                    <div class="uk-form-row">
                        <?php echo $form->labelEx($model, 'username', array(
                            'class' => 'uk-form-label'
                        )); ?>
                        <div class="uk-form-controls">
                            <?php echo $form->textField($model, 'username'); ?>
                            <?php echo $form->error($model, 'username'); ?>
                        </div>
                    </div>

                    <div class="uk-form-row">
                        <?php echo $form->labelEx($model, 'email', array(
                            'class' => 'uk-form-label'
                        )); ?>
                        <div class="uk-form-controls">
                            <?php echo $form->textField($model, 'email'); ?>
                            <?php echo $form->error($model, 'email'); ?>
                        </div>
                    </div>

                    <div class="uk-form-row">
                        <?php echo $form->labelEx($model, 'country_id', array(
                            'class' => 'uk-form-label'
                        )); ?>
                        <div class="uk-form-controls">
                            <input class="country_input" type="text"/>
                            <input name="User[country_id]" type="hidden" class="country_hidden"/>
                            <?php echo $form->error($model, 'country_id'); ?>
                        </div>
                    </div>

                    <div class="uk-form-row uk-margin-top">
                        <label class="uk-form-label">
                            <?php echo Yii::t('base', 'Create a password') ?>
                        </label>
                        <div class="uk-form-controls">
                            <?php echo $form->passwordField($model, 'password', array('value' => '')); ?>
                            <?php echo $form->error($model, 'password'); ?>
                        </div>
                    </div>                    

                    <div class="uk-form-row uk-margin-top">
                        <div>
                            <?php
                            $base = $this->createAbsoluteUrl(Yii:: app()->getLanguage() . '/site/page/view');
                            $baseTerms = $this->createAbsoluteUrl($termsLink);
                            ?>
                            <?php echo Yii::t('base', 'By registering your details you agree to<br/>our'); ?>
                            <a href="<?php echo $baseTerms; ?>" class="uk-base-link">
                                <?php echo Yii::t('base', 'Terms and Conditions'); ?>
                            </a>,
                            <?php $basePrivacy = $this->createAbsoluteUrl($privacyLink); ?>
                            <a href="<?php echo $basePrivacy; ?>" class="uk-base-link">
                                <?php echo Yii::t('base', 'Privacy'); ?>
                            </a>
                            <?php $baseCookie = $this->createAbsoluteUrl($cookieLink); ?>
                            <?php echo Yii::t('base', 'and'); ?>
                            <br/><a href="<?php echo $baseCookie; ?>">
                                <?php echo Yii::t('base', 'Cookie Policy'); ?>
                            </a>
                            <br/>
                            <br/>
                        </div>
                    </div>

                    <div class="uk-text-right">
                        <?php echo CHtml::submitButton(Yii::t('base', 'signup'), array(
                            'class' => 'uk-button uk-margin-top'
                        )); ?>
                    </div>

                    <?php $this->endWidget(); ?>
                </div>
                <div class="uk-width-medium-5-10">
                    <div class="uk-h2 uk-margin-large-bottom">
                        <?php echo Yii::t('base', 'login'); ?>
                    </div>

                    <?php $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'login-form',
                        'htmlOptions' => array(
                            'class' => 'uk-form uk-form-stacked uk-form-modal',
                        ),
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            //'validateOnChange' => true,
                            //'validateOnType' => true,
                        ),
                    )); ?>

                    <?php //echo $form->errorSummary($model_login); ?>

                    <?php echo CHtml::hiddenField('return', (isset($return) ? $return : '')); ?>
                    <?php echo CHtml::hiddenField('without_ajax', 1); ?>

                    <div class="uk-form-row">
                        <?php echo $form->labelEx($model_login, 'username', array(
                            'class' => 'uk-form-label'
                        )); ?>
                        <div class="uk-form-controls">
                            <?php echo $form->textField($model_login, 'username'); ?>
                            <?php echo $form->error($model_login, 'username'); ?>
                        </div>
                    </div>

                    <div class="uk-form-row">
                        <?php echo $form->labelEx($model_login, 'password', array(
                            'class' => 'uk-form-label'
                        )); ?>
                        <div class="uk-form-controls">
                            <?php echo $form->passwordField($model_login, 'password', array('value' => '')); ?>
                            <?php echo $form->error($model_login, 'password'); ?>
                        </div>
                    </div>

                    <div class="uk-margin-top uk-flex uk-flex-space-between">
                        <div>
                            <div class="form-group-checkbox uk-form-controls">
                                <input type="checkbox" id="check1" name="LoginForm[rememberMe]"/>
                                <label for="check1"
                                       class="label-checkbox"><span></span><?php echo Yii::t('base', 'Remember me') ?>
                                </label>
                            </div>
                        </div>
                        <div>
                            <a href="<?php echo '/members/auth/forgotPassword'; ?>"
                               class="uk-base-link" id="forgot-pass-link">
                                <?php echo Yii::t('base', 'Forgot password?'); ?>
                            </a>
                        </div>
                    </div>

                    <div class="uk-text-right">
                        <?php echo CHtml::submitButton(Yii::t('base', 'login'), array(
                            'class' => 'uk-button uk-margin-top',
                            'id' => 'reg_submit'
                        )); ?>                        
                    </div>

                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END PAGE-->

<script type="text/javascript">

    var register_object = {
        modal: null,
        initiate: function () {
            if (typeof UIkit != 'undefined' && this.modal === null) {
                this.modal = UIkit.modal('#signup');
            }
        },
        showLogin: function () {
            this.initiate();
            if (this.modal) {
                this.modal.show();
            } else {
                $('#page-login-visible').css('visibility', 'visible');
                $('#signup').hide();
            }
        },
        registerForgotPasswordClick: function () {
            $('#forgot-pass-link').click(function () {
                var url = $(this).attr('href');
                var wrapper = $('#forgot_pass_content');

                $.ajax({
                    'url': url,
                    success: function (data) {
                        $(wrapper).html(data);
                    }
                });

                return false; // without redirect
            });
        }
    };

    register_object.showLogin();
    register_object.registerForgotPasswordClick();
</script>

<script type="text/javascript"
        src="<?php echo Yii::app()->request->baseUrl; ?>/uikit/js/custom/select2.js"></script>

<script type="text/javascript"
        src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery/jquery-ui.js"></script>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/uikit/js/errorInput.js"></script>


<script type="text/javascript">
    if (typeof registration_select_init !== 'undefined') {
        registration_select_init();
    }

    function setCountryAutocomplete(argument) {
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
    }

    setCountryAutocomplete();
    
</script>

























