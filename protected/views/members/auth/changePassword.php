<?php
/* @var $this LoginController */

$this->breadcrumbs = array(
    'Change Password' => '',
);
?>


<!--MAIN BLOCK-->
<div class="uk-container uk-container-center">
    <div class="uk-grid">
        <div class=" uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1 uk-push-1-4">
            <div class="uk-block uk-margin-large-top">
                <div class="uk-text-center">
                    <div
                        class="uk-h1 uk-margin-small-bottom"><?php echo Yii::t('base', 'Change your password'); ?></div>
                    <div
                        class="uk-h3 uk-margin-small-bottom"><?php echo Yii::t('base', 'Enter your new password for My account'); ?></div>
                </div>

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'change-password-form',
                    'htmlOptions' => array(
                        'class' => 'uk-form uk-form-stacked uk-form-modal uk-margin-large-top'
                    ),
                    'enableAjaxValidation' => false
                ));
                ?>

                <p><?php echo $form->errorSummary($model); ?></p>

                <div class="uk-grid">
                    <div class=" uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                        <div class="uk-form-row uk-margin-top">
                            <label class="uk-form-label" for="id-4"><?php echo Yii::t('base', 'New password'); ?>
                                <sup>*</sup>:</label>
                            <div class="uk-form-controls">
                                <?php echo $form->passwordField($model, 'password', array('value' => '')); ?>
                                <?php echo $form->error($model, 'password'); ?>
                            </div>
                        </div>
                    </div>
                    <div class=" uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                        <div class="uk-form-row uk-margin-top">
                            <label class="uk-form-label"
                                   for="id-4_1"><?php echo Yii::t('base', 'Confirm new password'); ?>
                                <sup>*</sup>:</label>
                            <div class="uk-form-controls">
                                <?php echo $form->passwordField($model, 'password2', array('value' => '')); ?>
                                <?php echo $form->error($model, 'password2'); ?>
                            </div>
                        </div>
                        <div class="uk-text-right uk-margin-top">
                            <?php echo CHtml:: submitButton(strtolower(Yii::t('base', 'Save')), array(
                                'class' => 'uk-button uk-margin-top'
                            )); ?>
                        </div>
                    </div>
                </div>

                <?php $this->endWidget(); ?>

            </div>
        </div>
    </div>
</div>
<!--END MAIN BLOCK-->
