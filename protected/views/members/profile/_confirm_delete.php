<div id="delete-item" class="uk-modal uk-modal-delete">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="uk-container uk-container-center">
            <div class="uk-text-center uk-text-left-small uk-h2 uk-text-normal uk-margin-large-bottom">
                <?php echo Yii::t('base', 'delete item?'); ?>
            </div>
            <div
                class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-2 uk-grid-width-medium-1-2 uk-grid-width-small-1-1 uk-push-1-4">
                <div>
                    <div class="uk-grid">
                        <div class="uk-width-1-4">
                            <div class="image-wrapper">
                                <?php echo CHtml::image(
                                    Yii::app()->request->getBaseUrl(true) . ShopConst::IMAGE_THUMBNAIL_DIR . $product->image1,
                                    CHtml::encode($product->title)); ?>
                            </div>
                        </div>
                        <div class="uk-width-3-4">
                            <div class="uk-margin-bottom">
                                <b><?php echo Brand::getFormatedTitle(CHtml::encode($product->brand->name)); ?></b>
                                <div><?php echo CHtml::encode($product->description); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-text-center uk-text-left-small uk-margin-large-top">
                <!--                <a href="#" class="uk-button uk-margin-right">confirm</a>-->

                <?php echo CHtml::link(
                    Yii::t('base', 'confirm'),
                    '',
                    array(
                        'class' => 'uk-button uk-margin-right',
                        'id' => 'confirm_delete',
                        'data-id' => $product->id)); ?>

                <a href="#" class="uk-modal-close uk-button"><?php echo Yii::t('base', 'cancel'); ?></a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var profile_delete_item_modal = UIkit.modal('#delete-item', {center: true});
    profile_delete_item_modal.show();

    $('#confirm_delete').off('click').on('click', function () {
        $.ajax({
            type: 'POST',
            data: {id: $(this).data('id')},
            url: globals.url + '/members/profile/removeItem',
            success: function (data, textStatus, jqXHR) {
                $("#sale_items").html(data);
                profile_delete_item_modal.hide();
            }
        });

        return false;
    });
</script>
























