<article class="uk-comment uk-comment-custom">
    <header class="uk-comment-header">
        <div class="uk-comment-avatar"><i class="icon-ic_account"></i></div>
        <div class="uk-flex uk-flex-bottom">
            <?php $profileLink = ($comment->author_id == Yii::app()->member->id) ? '/my-account' : '/profile-'.$comment->author_id; ?>
            <div class="uk-comment-title"><?=CHtml::link(
                    CHtml::encode(isset($comment->author->username) ? $comment->author->username : Yii::t('base', 'Unnamed')),
                    isset($comment->author->username) ? $this->createAbsoluteUrl($profileLink) : "#")?></div>
            <?php $date = explode('|', date('d.m.Y|g:i a', strtotime($comment->create_time)))?>
            <ul class="uk-comment-meta uk-subnav uk-subnav-line">
                <li><?=$date[0]?></li>
                <li><?=$date[1]?></li>
            </ul>
        </div>
    </header>
    <div class="uk-comment-body uk-text-left">
        <?php echo CHtml::encode($comment->content); ?>
    </div>
</article>