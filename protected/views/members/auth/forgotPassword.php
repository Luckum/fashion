<?php
/* @var $this LoginController */

$this->breadcrumbs = array(
    'Forgot Password' => '',
);
?>

<!--PASSWORD MODAL-->
<div id="forgot-password" class="uk-modal uk-modal-password">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="uk-grid">
            <div class="uk-width-large-1-1 uk-width-medium-1-1 uk-width-small-1-1">
                <?php if (!Yii:: app()->member->hasFlash('success')): ?>
                    <div class="uk-h2 uk-margin-bottom">
                        <?php echo strtolower(Yii::t('base', 'Password recovery')); ?>
                    </div>
                <?php endif; ?>
                <?php if (Yii:: app()->member->hasFlash('timeIsOver')): ?>
                    <?php echo Yii:: app()->member->getFlash('timeIsOver'); ?>
                <?php elseif (Yii:: app()->member->hasFlash('wrongHash')): ?>
                    <?php echo Yii:: app()->member->getFlash('wrongHash'); ?><
                <?php elseif (Yii:: app()->member->hasFlash('success')): ?>
                    <?php echo Yii:: app()->member->getFlash('success'); ?>
                <?php else: ?>

                    <?php $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'forgot-password-form',
                        'htmlOptions' => array(
                            'class' => 'uk-form uk-form-stacked uk-form-modal',
                        ),
                        'enableClientValidation' => true,
                    )); ?>

                    <?php //echo $form->errorSummary($model); ?>

                    <div class="uk-margin-bottom">
                        <?php echo Yii::t('base',
                            'Enter the e-mail address you use for My Account and you will receive an e-mail containing a link for changing your password'); ?>
                    </div>

                    <form action="#" class="uk-form uk-form-stacked uk-form-modal">
                        <div class="uk-form-row">
                            <?php echo $form->labelEx($model, 'email', array(
                                'class' => 'uk-form-label'
                            )); ?>
                            <div class="uk-form-controls">
                                <?php echo $form->textField($model, 'email'); ?>
                                <?php echo $form->error($model, 'email'); ?>
                            </div>
                        </div>
                        <div class="uk-text-right">
                            <input type="button" value="<?= Yii::t('base', 'submit') ?>" class="uk-button uk-margin-top" id="forgot-password-ajax-button">
                        </div>
                    </form>

                    <?php $this->endWidget(); ?>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!--END PASSWORD MODAL-->

<div id="page-forgot-password" style="visibility: hidden; padding: 10px;">
    <div class="uk-grid">
        <div class="uk-width-medium-2-6"></div>
        <div class="uk-width-medium-2-6">
            <div class="uk-grid">
                <div class="uk-width-large-1-1 uk-width-medium-1-1 uk-width-small-1-1">
                    <div class="uk-h2 uk-margin-bottom">
                        <?php echo strtolower(Yii::t('base', 'Password recovery')); ?>
                    </div>

                    <?php if (Yii:: app()->member->hasFlash('timeIsOver')): ?>
                        <?php echo Yii:: app()->member->getFlash('timeIsOver'); ?>
                    <?php elseif (Yii:: app()->member->hasFlash('wrongHash')): ?>
                        <?php echo Yii:: app()->member->getFlash('wrongHash'); ?><
                    <?php elseif (Yii:: app()->member->hasFlash('success')): ?>
                        <?php echo Yii:: app()->member->getFlash('success'); ?>
                    <?php else: ?>

                        <?php $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'forgot-password-form',
                            'htmlOptions' => array(
                                'class' => 'uk-form uk-form-stacked uk-form-modal',
                            ),
                            'enableClientValidation' => true,
                        )); ?>

                        <?php //echo $form->errorSummary($model); ?>

                        <div class="uk-margin-bottom">
                            <?php echo Yii::t('base',
                                'Enter the e-mail address you use for My Account and you will receive an e-mail containing a link for changing your password'); ?>
                        </div>

                        <form action="#" class="uk-form uk-form-stacked uk-form-modal">
                            <div class="uk-form-row">
                                <?php echo $form->labelEx($model, 'email', array(
                                    'class' => 'uk-form-label'
                                )); ?>
                                <div class="uk-form-controls">
                                    <?php echo $form->textField($model, 'email'); ?>
                                    <?php echo $form->error($model, 'email'); ?>
                                </div>
                            </div>
                            <div class="uk-text-right">
                                <?php echo CHtml::submitButton(Yii::t('base', 'submit'), array(
                                    'class' => 'uk-button uk-margin-top'
                                )); ?>
                            </div>
                        </form>

                        <?php $this->endWidget(); ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // show login window
    //
    jQuery(document).ready(function($) {
        $('#forgot-password-ajax-button').off('click').on('click', function(event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '/members/auth/forgotPassword',
                data: $('#forgot-password-form').serialize(),
                success:function(data){
                    if (data.result == 'ok') {
                        $('#forgot-password .uk-modal-dialog .uk-grid>div').html(data.text)
                    } else {
                        $('#forgot-password-form #User_email').attr('placeholder', data.text);
                        $('#forgot-password-form #User_email').addClass('error');
                        $('#forgot-password-form #User_email_em_').html(data.text);
                    }
                }
            });
        });
        $('#forgot-password-form').on('submit', function(event) {
            return false;
        });
        var forgot_password_object = {
            modal: typeof UIkit != 'undefined' ? UIkit.modal('#forgot-password', {center: true}) : null,
            showLogin: function () {
                if (this.modal) {
                    this.modal.show();
                } else {
                    $('#page-forgot-password').css('visibility', 'visible');
                    $('#forgot-password').hide();
                }

            },
            bindCloseEvent: function(){
                $('#forgot-password').on({
                    'hide.uk.modal': function(){
                        if (window.location.href.indexOf('sell-') == -1 && window.location.href.indexOf('blog/') == -1) {
                            window.location = '/';
                        }
                    }
                });
            }
        };

        forgot_password_object.showLogin();
        forgot_password_object.bindCloseEvent();
    });

</script>

<?php
$noCacheParameter = '';

if(YII_DEBUG){
    $noCacheParameter = '?nocache=' . rand(1, 1000);
}
?>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/uikit/js/errorInput.js<?php echo $noCacheParameter; ?>"></script>









