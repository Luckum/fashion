<?php

/* @var $this ProfileController */

$this->breadcrumbs = array(
    'Client Area' => array('members/index'),
    'Inbox Profile' => '',
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
                        <?php $this->renderPartial('_profile_nav', array(
                            'showProfile' => (isset($showProfile) ? true : false))); ?>
                        <!--END PROFILE NAV-->
                        <!--INBOX-->
                        <div class="uk-width-1-1 uk-width-large-3-4 uk-width-medium-1-1 uk-width-small-1-1">
                            <div id="inbox">
                                <?php $this->renderPartial('_inbox', array(
                                    'user' => $user,
                                    'model' => $model,
                                    'unreadInfo' => $unreadInfo,
                                    'commentsForVisibleBlock' => $commentsForVisibleBlock,
                                    'commentsForHiddenBlock' => $commentsForHiddenBlock,
                                    'offers_responses' => $offers_responses,
                                    'my_offers' => $my_offers_responses
                                )); ?>
                            </div>
                        </div>
                        <!--END INBOX-->
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

<div id="reply-comment-content"></div>
<?php
    ProfileController::setCommentsAsRead($model);
?>























