<?php
/* @var $this ProfileController */

$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'Account Alerts' => array('my-account/alerts'),
	'Edit Alerts' => '',
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
                        <!--EDIT ALERT-->
                        <div class="uk-width-1-1 uk-width-large-3-4 uk-width-medium-1-1 uk-width-small-1-1">
                            <div class="uk-margin-left uk-margin-right">
                                <div class="uk-h4 uk-margin-bottom uk-margin-top">
                                    <b><?php echo Yii::t('base', 'edit alert'); ?></b>
                                </div>
                                <?php $this->renderPartial('_alerts_form', array('model'=>$model)); ?>
                            </div>
                        </div>
                        <!--END EDIT ALERTS-->
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

