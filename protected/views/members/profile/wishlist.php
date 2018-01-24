<?php
/* @var $this ProfileController */

// Хлебные крошки.
$this->breadcrumbs = array(
    'Client Area' => array('members/index'),
    'Account Settings' => '',
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
                        <!--WISHLIST-->
                        <div class="uk-width-1-1 uk-width-large-3-4 uk-width-medium-1-1 uk-width-small-1-1">

                            <div class="uk-margin-left uk-margin-right">
                                <div class="uk-h4 uk-margin-bottom uk-margin-neg-top-small">
                                    <b><?php echo Yii::t('base', 'Wishlist'); ?></b>
                                </div>

                                <?php $count = count($wishlist);

                                if ($count): ?>
                                    <?php
                                    $baseUrl = Yii:: app()->request->getBaseUrl(true);
                                    $medium_dir = $baseUrl . ShopConst::IMAGE_MEDIUM_DIR;
                                    ?>
                                    <?php for ($i = 0; $i < $count; $i++): ?>
                                        <?php if ($i == 0 || ($i % 2) == 0): ?>
                                            <div class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-2 uk-grid-width-medium-1-2 uk-grid-width-small-1-1">
                                            <div>
                                        <?php else: ?>
                                            <div>
                                        <?php endif; ?>

                                        <div id="product-wrapper-<?php echo $wishlist[$i]['product']['id']; ?>" class="thumbnail uk-margin-bottom">
                                            <div class="list-link">
                                                <a href="#delete-item"
                                                   class="delete-item uk-margin-left-mini"
                                                   data-uk-modal="{center: true}"></a>
                                            </div>
                                            <a href="#" class="uk-display-block">
                                                <div class="thumbnail-image">
                                                    <?=CHtml::image(
                                                        $medium_dir . $wishlist[$i]['product']['image1'],
                                                        '',
                                                        array('onerror' => '$(this).prop({"class" : "no-image", "src" : "/images/prod-no-img.png"})')
                                                    )?>
                                                </div>
                                                <div class="uk-h4 thumbnail-title uk-margin-top">
                                                    <?php echo Brand::getFormatedTitle(CHtml::encode($wishlist[$i]['brand']['name'])); ?>
                                                </div>
                                            </a>
                                            <div class="thumbnail-description uk-margin-large-left uk-margin-top-mini">
                                                <?php echo Product::getFormatedTitle(CHtml::encode($wishlist[$i]['product']['title'])); ?>
                                                <input type="hidden" class="wishlist-item-hidden"
                                                       value="<?php echo $wishlist[$i]['product']['id']; ?>"/>
                                            </div>
                                            <div class="thumbnail-details uk-margin-large-left">
                                                        <?php if ($wishlist[$i]['product']['price'] < $wishlist[$i]['product']['init_price']): ?>
                                                            <span class="price price-old">
                                                                <?php echo CHtml::encode($wishlist[$i]['product']['init_price']); ?>
                                                            </span>
                                                            <span class="price-new">
                                                                &euro;<?php echo CHtml::encode($wishlist[$i]['product']['price']); ?>
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="price">
                                                                &euro;<?php echo CHtml::encode($wishlist[$i]['product']['price']); ?>
                                                            </span>
                                                        <?php endif; ?>
                                                        <span class="size">
                                                            size: <?php echo CHtml::encode($wishlist[$i]['size']['size']); ?>
                                                        </span>
                                            </div>
                                        </div>

                                        <?php if (($i == 0 || ($i % 2) == 0) && $i < ($count - 1)): ?>
                                            </div>
                                        <?php else: ?>
                                            </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                <?php else : ?>
                                    <br/>
                                    <p><?php echo Yii::t('base', 'you have no items in your wishlist'); ?></p>
                                <?php endif; ?>

                            </div>

                        </div>
                        <!--END WISHLIST-->
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

<!--MODAL DELETE ITEM-->
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
                            <div id="wishlist-modal-image" class="image-wrapper">
                            </div>
                        </div>
                        <div class="uk-width-3-4">
                            <div class="uk-margin-bottom">
                                <b id="wishlist-modal-brand"></b>
                                <div id="wishlist-modal-title"></div>
                                <input id="wishlist-modal-id" type="hidden" value=""/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-text-center uk-text-left-small uk-margin-large-top">
                <a href="#" id="wishlist-modal-button" class="uk-button uk-margin-right">
                    <?php echo Yii::t('base', 'confirm'); ?>
                </a>
                <a href="#" class="uk-modal-close uk-button">
                    <?php echo Yii::t('base', 'cancel'); ?>
                </a>
            </div>
        </div>
    </div>
</div>
<!--END MODAL DELETE ITEM-->

<script>
    $(document).ready(function () {
        // prepare modal window
        //
        $('.delete-item').click(function () {
            // get wrapper
            //
            var wrapper = $(this).parents('.thumbnail');

            // get data for modal window
            //
            var image = $(wrapper).find('.thumbnail-image').html();
            var brand = $(wrapper).find('.thumbnail-title').html();
            var title = $(wrapper).find('.thumbnail-description').html();
            var product_id = $(wrapper).find('.wishlist-item-hidden').val();

            // set data to modal window
            //
            $('#wishlist-modal-image').html(image);
            $('#wishlist-modal-brand').html(brand);
            $('#wishlist-modal-title').html(title);
            $('#wishlist-modal-id').val(product_id);
        });

        // delete item
        $('#wishlist-modal-button').click(function () {
            var url = globals.url + '/members/profile/ajaxRemoveItemFromWishlist/';
            var product_id = $('#wishlist-modal-id').val();

            $.post(url, {'wid' : product_id}).always(function() {
                location.reload(true);
            });
       });
    });
</script>





















