<!--COMMENT OF BUYER-->
<article class="uk-comment uk-comment-custom">
    <header class="uk-comment-header">
        <div class="uk-comment-avatar">
            <?php echo CHtml::link(
                '<i class="icon-ic_account"></i>',
                $this->createAbsoluteUrl('/profile-' . $comment->user_id)); ?>
        </div>
        <div class="uk-flex uk-flex-bottom">
            <div class="uk-comment-title">
                <?php echo CHtml::link(
                    CHtml::encode($comment->user->username),
                    $this->createAbsoluteUrl('/profile-' . $comment->user_id)); ?>
            </div>
        </div>
    </header>
    <div class="uk-comment-body">
        <?php echo CHtml::encode($comment->comment); ?>
    </div>
    <a href="#" id="reply-link-<?php echo $comment->id; ?>" class="uk-base-link comment-link">
        <?php echo Yii::t('base', 'reply'); ?>
    </a>
</article>
<!--END COMMENT OF BUYER-->
<!--RESPONSE OF SELLER-->
<?php if ($comment->response && $comment->response_status != 'banned') : ?>

    <article class="uk-comment uk-comment-custom">
        <header class="uk-comment-header">
            <div class="uk-comment-avatar">
                <i class="icon-ic_account"></i>
            </div>
            <div class="uk-flex uk-flex-bottom">
                <div class="uk-comment-title">
                    <?php echo CHtml::encode($user->username); ?>
                </div>
            </div>
        </header>
        <div class="uk-comment-body">
            <?php echo CHtml::encode($comment->response); ?>
        </div>
    </article>

<?php endif; ?>
<!--END RESPONSE OF SELLER-->

<script type="text/javascript">
    $('#reply-link-<?php echo $comment->id; ?>').off('click').on('click', function(){
        $.ajax({
            url: '<?php echo $this->createAbsoluteUrl(
                '/members/profile/replyComment/' . $comment->id); ?>',
            success: function(data){
                $('#reply-comment-content').html(data);
            }
        });

        return false;
    });
</script>