<?php
$bag_count = Yii::app()->shoppingCart->getCount();
$cartUrl = Yii::app()->createUrl('members/shop/cart');
?>
<a class="main_menu_link" id="cart-anchor" title="<?php echo Yii::t('base', 'Bag'); ?>" href="<?= $cartUrl ?>">
    <i class="icon-ic_shoppingbag uk-margin-right-mini"></i>
    <span><?php echo Yii::t('base', 'Bag'); ?> (<?= $bag_count ?>)</span>
</a>

<?php if($bag_count > 0): ?>

<div class="uk-dropdown uk-dropdown-bag cart-pos">
    <?= CHtml::hiddenField('count_in_bag', $bag_count) ?>
    <a href="#" class="uk-dropdown-close uk-close"></a>
    <div class="uk-grid">
        <div class="uk-width-3-5 uk-push-1-5">
            <div class="uk-h2 uk-margin-small-bottom"><?php echo Yii::t('base', 'bag'); ?></div>
            <div style="padding-bottom:20px">
                <?php echo Yii::t('base','you have {count} items in your bag', array('{count}' => $bag_count)); ?>
            </div>
        </div>
    </div>
    <?php if ($bag_count) : ?>
        <div class="scroll-pane">
            <?php $total = 0; ?>
            <?php foreach (Yii::app()->shoppingCart->getPositions() as $product) : ?>
                <?php $total += $product->getPrice(); ?>
                <div class="uk-grid">
                    <div class="uk-width-1-5">
                        <div class="image-wrapper">
                            <?= CHtml::image(Yii::app()->request->getBaseUrl(true) . ShopConst::IMAGE_THUMBNAIL_DIR . $product->image1, CHtml::encode($product->title)) ?>
                        </div>
                    </div>
                    <div class="uk-width-1-2 uk-padding-right">
                        <div class="uk-margin-bottom">
                            <b><?= Brand::getFormatedTitle(CHtml::encode($product->brand->name)) ?></b>
                            <div
                                class="uk-margin-small-bottom bag-description"><?= CHtml::encode($product->description) ?></div>
                            <div class="uk-flex uk-flex-space-between">
                                <span class="size"><?php echo Yii::t('base', 'size'); ?>: <?=empty($product -> size_chart) ? Yii :: t('base', 'No size') : $product -> size_chart -> size ?></span>
                                <span class="size"><?php echo Yii::t('base', 'color'); ?>: <?= $product->color ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-4 uk-clearfix">
                        <div class="uk-float-right">
                            <span class="price uk-margin-small-right">&euro;<?= $product->price ?></span>
							<span class="rem-cart-item delete-item delete-item-light"
                                  data-id="<?= $product->getId() ?>">
								<span class="uk-close uk-close-bag"></span>
							</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div
            class="uk-block-divider-top uk-block-divider-top-light uk-block-divider-top-width uk-padding-large-right"></div>
        <div class="uk-grid uk-margin-top">
            <div class="uk-width-3-4 uk-push-1-4 uk-flex uk-flex-middle uk-flex-space-around">
                <div>
                    <b><?php echo Yii::t('base', 'Subtotal'); ?>:</b> &euro;<?= $total ?>
                </div>
                <div>
                    <?php
                    if (Yii::app()->member->isGuest) {
                        ?>

                        <a href="#" id="login_cart"
                           class="uk-button uk-button-inverse"
                           onclick="loginCart('/members/auth/login', '/cart');">
                            <?php echo Yii::t('base', 'checkout') ?>
                        </a>

                        <?php
                    } else {
                        echo CHtml::link(Yii::t('base', 'checkout'), $this->createAbsoluteUrl('/cart'), array(
                            'id' => 'checkout',
                            'class' => 'uk-button uk-button-inverse'));
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php endif; ?>

<script>
    /**
     * Удаление товара из корзины.
     */
    jQuery(document).ready(function ($) {
        $('.rem-cart-item').on('click', function () {
            var url = globals.url + '/members/shop/removeFromBag';
            var data = {'id': $(this).data('id')};
            $.post(url, data, function (response) {
                $('#cart').html(response);
                scrollbar();
            });
        });
    });

</script>