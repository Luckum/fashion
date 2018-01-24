<article class="uk-comment uk-comment-custom">
    <header class="uk-comment-header">
        <div class="uk-comment-avatar"><i class="icon-ic_account"></i></div>
        <div class="uk-flex uk-flex-bottom">
            <?php $profileLink = ($comment->user_id == Yii::app()->member->id) ? '/my-account' : '/profile-'.$comment->user_id; ?>
            <div class="uk-comment-title"><?=CHtml::link(
                    CHtml::encode(isset($comment->user->username) ? $comment->user->username : Yii::t('base', 'Unnamed')),
                    isset($comment->user->username) ? $this->createAbsoluteUrl($profileLink) : "#")?></div>
            <?php $date = explode('|', date('d.m.Y|g:i a', strtotime($comment->added_date)))?>
            <ul class="uk-comment-meta uk-subnav uk-subnav-line">
                <li><?=$date[0]?></li>
                <li><?=$date[1]?></li>
            </ul>
        </div>
    </header>
    <div class="uk-comment-body">
        <?php echo CHtml::encode($comment->comment); ?>
    </div>
</article>