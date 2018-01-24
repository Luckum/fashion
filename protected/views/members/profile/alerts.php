<?php
/* @var $this ProfileController */

$this->breadcrumbs = array(
    'Client Area' => array('members/index'),
    'Account Alerts' => '',
);
?>

<!--ACCOUNT BLOCK-->
<div class="uk-block uk-block-large uk-margin-top">
    <div class="uk-container uk-container-center">
        <div class="uk-accordion account-wrapper" data-uk-accordion='{showfirst: true, animate: false}'>
            <div class="uk-grid">
                <div class="uk-width-large-7-10 uk-width-medium-7-10 uk-width-small-1-1">
                    <div class="uk-grid">
                        <!--PROFILE NAV-->
                        <?php $this->renderPartial('_profile_nav', array('showProfile' => (isset($showProfile) ? true : false))); ?>
                        <!--END PROFILE NAV-->
                        <!--ALERTS-->
                        <div class="uk-width-1-1 uk-width-large-3-4 uk-width-medium-1-1 uk-width-small-1-1">
                            <div class="uk-margin-left uk-margin-right">
                                <div class="uk-h4 uk-margin-bottom uk-margin-neg-top-small">
                                    <b><?php echo Yii::t('base', 'active alerts'); ?></b>
                                </div>

                                <!--FLASH MESSAGES-->
                                <?php $this->widget('application.components.ModalFlash'); ?>
                                <!--END FLASH MESSAGES-->

                                <?php if(!empty($alerts)) : ?>
                                    <?php foreach ($alerts as $alert) : ?>
                                        <div id="alerts<?=$alert->id?>" class="uk-alert uk-alert-row" data-uk-alert>
                                            <div class="uk-grid">
                                                <div class="uk-width-1-2 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-2">
                                                    <?= CHtml::encode(strtolower($alert->category->alias)) ?>
                                                    <?= CHtml::encode(strtolower($alert->subcategory->alias)) ?>
                                                    <?= Yii::t('base', 'size') ?>
                                                </div>
                                                <div class="uk-width-1-6 uk-width-large-1-6 uk-width-medium-1-6 uk-width-small-1-6">
                                                    <?=empty($alert -> size_chart) ? Yii :: t('base', 'No size') : $alert -> size_chart -> size?>
                                                </div>
                                                <div class="uk-width-1-6 uk-width-large-1-6 uk-width-medium-1-6 uk-width-small-1-6">
                                                    <?= CHtml::link(
                                                            'edit alert',
                                                            $this->createUrl(
                                                                '/my-account/alertsUpdate',
                                                                array(
                                                                    'alert_id' => $alert->id
                                                                )
                                                            ),
                                                            array('class' => 'uk-base-lin underlined')
                                                        )
                                                    ?>
                                                </div>
                                                <div class="uk-width-1-6 uk-width-large-1-6 uk-width-medium-1-6 uk-width-small-1-6">
                                                    <div class="uk-float-right">
                                                        <?=CHtml::ajaxLink(
                                                            '',
                                                            Yii::app()->createUrl('/members/profile/deleteAlert'),
                                                            array(
                                                                'data'=> 'js:{"alert_id":'.$alert->id.', "ajax":true}',
                                                                'success'=>'js:function(string){ document.getElementById("alerts'.$alert->id.'").remove(); }',
                                                            ),
                                                            array(
                                                                'confirm'=>'Are you sure you want to delete this alert?',
                                                                'class' => 'uk-alert-close delete-item'
                                                            )
                                                        );?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach;?>
                                <?php else : ?>
                                    <div class="uk-margin-large-bottom">
                                        <div class="uk-grid">
                                            <div class="uk-width-1-1">
                                                <div class="uk-alert uk-alert-row"><?php echo Yii::t('base', 'no active alerts'); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif;?>
                                <?php if (!empty(Yii::app()->member->id)): ?>
                                    <div class="uk-h4 uk-margin-bottom uk-margin-top-xlarge">
                                        <b>
                                            <?php echo Yii::t('base', 'create a new alert'); ?>
                                        </b>
                                    </div>
                                    <?php $this->renderPartial('_alerts_form', array('model'=>$model)); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!--END ALERTS-->
                    </div>
                </div>
                <!--PROFILE INFO-->
                <div
                    class="uk-width-1-1 uk-width-large-3-10 uk-width-medium-3-10 uk-width-small-1-1 margin-top-small-screen">
                    <?php $this->renderPartial('_nav_info', array('user' => $user)); ?>
                </div>
                <!--END PROFILE INFO-->
            </div>
        </div>
    </div>
</div>
<!--END ACCOUNT BLOCK-->