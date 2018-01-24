<?php if (isset($comment->product->user)): ?>
<article class="uk-comment uk-comment-custom uk-margin-left">
    <header class="uk-comment-header">
        <div class="uk-comment-avatar"><i class="icon-ic_account"></i></div>
        <?php $profileLink = ($comment->seller_id == Yii::app()->member->id) ? '/my-account' : '/profile-'.$comment->seller_id; ?>
        <div class="uk-flex uk-flex-bottom">
            <div class="uk-comment-title"><?php echo CHtml::link(
                    CHtml::encode($comment->product->user->username),
                    $this->createAbsoluteUrl($profileLink))?>
            </div>
        </div>
    </header>
    <div class="uk-comment-body">
        <?php echo CHtml::encode($comment->response); ?>
    </div>
</article>
<?php endif; ?>