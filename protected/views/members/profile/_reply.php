
<div id="comment-reply-modal" class="uk-modal uk-modal-reply">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="uk-container uk-container-center">
            <div class="uk-text-center uk-text-left-small uk-h2 uk-text-normal uk-margin-large-bottom">
                <?php echo Yii::t('base', 'reply'); ?>
            </div>
            <div
                class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-2 uk-grid-width-medium-1-2 uk-grid-width-small-1-1 uk-push-1-10">
                <div>
                    <div class="uk-grid">
                        <div>
                            <?php echo CHtml::beginForm('', 'post', array(
                                'class' => 'uk-form'
                            )); ?>

                            <div class="uk-form-row">
                                <?php echo CHtml::hiddenField('rating_id', $id); ?>
                                <?php echo CHtml::TextArea('comment', '', array(
                                    'rows' => 7,
                                    'cols' => 40)); ?>
                            </div>

                            <div class="uk-form-row">
                                <?php echo CHtml::submitButton(Yii::t('base', 'submit'), array('class' => 'uk-button add_comment')); ?>
                            </div>
                            <?php echo CHtml::endForm(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var comment_reply_modal = UIkit.modal('#comment-reply-modal', {center: true});
    comment_reply_modal.show();

    $(document).off('click').on("click", '.add_comment', function () {
        var id = $('#rating_id').val();
        $.ajax({
            type: 'POST',
            data: {comment: $('#comment').val(), id: id},
            url: globals.url + '/members/profile/replyComment',
            success: function (data, textStatus, jqXHR) {
                if (data && data != '0') {
                    $('#comments_' + id).html(data);
                    comment_reply_modal.hide();
                }
            }
        });
        return false;
    });
</script>