<div class="uk-margin-left uk-margin-right">
    <ul data-uk-switcher="{connect:'#account-inbox'}"
        class="uk-list-switcher uk-list-switcher-light uk-margin-bottom">
        <li>
            <a href="">
                <?php echo Yii::t('base', 'comments'); ?>
                <?php if ($unreadInfo[ProfileController::UNREAD_COMMENTS_COUNT] > 0): ?>
                    <span class="uk-text-danger uk-margin-left-mini">
                    <?php echo $unreadInfo[ProfileController::UNREAD_COMMENTS_COUNT]; ?>
                </span>
                <?php endif; ?>
            </a>
        </li>
        <?php if ($user->sellerProfile): ?>
        <li>
            <a href="">
                <?php echo Yii::t('base', 'offers'); ?>
                <?php if ($unreadInfo[ProfileController::UNREAD_OFFERS_COUNT] > 0): ?>
                    <span class="uk-text-danger uk-margin-left-mini">
                    <?=$unreadInfo[ProfileController::UNREAD_OFFERS_COUNT]; ?>
                </span>
                <?php endif; ?>
            </a>
        </li>
        <?php endif; ?>
        <li>
            <a href="">
                <?php echo Yii::t('base', 'my offers'); ?>
                <?php if($unreadInfo[ProfileController::UNREAD_RESPONSES_COUNT] > 0): ?>
                    <span class = "uk-text-danger uk-margin-left-mini">
                        <?=$unreadInfo[ProfileController::UNREAD_RESPONSES_COUNT]; ?>
                    </span>
                <?php endif; ?>
            </a>
        </li>
    </ul>
    <ul id="account-inbox" class="uk-switcher">
        <!--FIRST SWITCHER ELEMENT - INBOX-->
        <li>
            <?php $isCommentExist = count($commentsForVisibleBlock) || count($commentsForHiddenBlock); ?>

            <?php if (!empty($commentsForVisibleBlock)) : ?>
                <?php foreach ($commentsForVisibleBlock as $comment) : ?>
                    <?php
                        $this->renderPartial('_comments_wrapper', array(
                            'comment' => $comment,
                            'user' => $user
                        ));
                    ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if (!empty($commentsForHiddenBlock)) : ?>
                <div id="more-comments">
                    <a class="uk-base-link" href="#"><?= Yii::t('base', 'view more') ?></a>
                </div>
                <div class="hidden_comments">
                    <?php foreach ($commentsForHiddenBlock as $comment) : ?>
                        <?php
                            $this->renderPartial('_comments_wrapper', array(
                                'comment' => $comment,
                                'user' => $user
                            ));
                        ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!$isCommentExist): ?>
                <div class="comments-wrapper uk-margin-large-left">
                    <div>
                        <?php echo Yii::t('base', 'you don`t have comments yet'); ?>
                    </div>
                </div>
            <?php endif; ?>
        </li>
        <!--END FIRST SWITCHER ELEMENT - INBOX-->
        <!--SECOND SWITCHER ELEMENT - INBOX-->
        <?php if ($user->sellerProfile): ?>
        <li>
            <div class="comments-wrapper uk-margin-large-left">
                <?php if ($offers_responses) : ?>
                <?php foreach ($offers_responses as $offer_response) : ?>
                <?php
                if ($offer_response['name'] == 'offer') {
                $offer = $offer_response['value'];
                if (isset($offer->product)): ?>
                <div class="offer-wrapper">
                    <?php $offerPriceForSeller = $offer->offer *
                        (isset($offer->seller->sellerProfile->comission_rate) ?
                            1 - $offer->seller->sellerProfile->comission_rate :
                            1 - Yii::app()->params['payment']['default_comission_rate']);

                    $originalPriceForSeller = $offer->product->price *
                        (isset($offer->seller->sellerProfile->comission_rate) ?
                            1 - $offer->seller->sellerProfile->comission_rate :
                            1 - Yii::app()->params['payment']['default_comission_rate']);
                    ?>

                    <!--VISIBLE PART-->
                    <div>
                        <?=CHtml::image(Yii::app()->request->getBaseUrl(true) . "/images/exclam_mark.png");?>
                        <?=date("d.m.Y \| g:i a", strtotime($offer->added_date));?>
                        <p>Offer made on:</p>
                    </div>
                    <div class="uk-grid">
                        <?php
                        $encodedProductTitle = Product::getFormatedTitle(CHtml::encode($offer->product->title));
                        $encodedBrandTitle = Brand::getFormatedTitle(CHtml::encode($offer->product->brand->name));
                        $productUrl = $this->createAbsoluteUrl(Product::getProductUrl($offer->product->id, $offer->product));
                        $brandUrl = Brand::getBrandLink($offer->product->brand->name);
                        ?>
                        <div class="uk-width-1-4">
                            <div class="image-wrapper">
                                <a title="Product image - <?php echo $encodedProductTitle; ?>" href="<?php echo $productUrl; ?>">
                                    <?=CHtml::image(
                                        Yii::app()->request->getBaseUrl(true) . ShopConst::IMAGE_THUMBNAIL_DIR . $offer->product->image1,
                                        CHtml::encode($offer->product->title));?>
                                </a>
                            </div>
                        </div>
                        <div class="uk-width-3-4">
                            <div class="uk-margin-bottom">
                                <b>
                                    <a title="<?php echo $encodedBrandTitle; ?>" href="<?php echo $brandUrl; ?>">
                                        <?= $encodedBrandTitle ?>
                                    </a>
                                </b>
                                <div>
                                    <a title="<?php echo $encodedProductTitle; ?>" href="<?php echo $productUrl; ?>">
                                        <?= $encodedProductTitle; ?>
                                    </a>
                                </div>
                            </div>
                            <div class="uk-margin-bottom">
                                <div>
                                    <?php echo Yii::t('base', 'from'), ' ', $offer->user->username; ?>
                                </div>
                                <div><b>&euro;<?php echo $offer->offer; ?>
                                        (&nbsp;<?php echo Yii::t('base', 'you get') ?>
                                        &nbsp;&euro;<?php echo $offerPriceForSeller; ?>&nbsp;)</b></div>
                            </div>
                            <div class="uk-margin-bottom">
                                <?php if($offer->confirm === null) {
                                    echo "<p class='offer-show-context' data-uk-modal=\"{target: '#show-offer', center: true}\">"
                                        .Yii::t('base', 'click to respond')."</p>";
                                } elseif($offer->confirm == 1) {
                                    echo "<p>".Yii::t('base', 'accepted')."</p>";
                                } elseif($offer->confirm == 0) {
                                    echo "<p>".Yii::t('base', 'rejected')."</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <!--END VISIBLE PART-->

                    <!--UNVISIBLE DATA-->
                    <div class="offer-image-data uk-hidden">
                        <?php echo CHtml::image(
                            Yii::app()->request->getBaseUrl(true) . ShopConst::IMAGE_THUMBNAIL_DIR . $offer->product->image1,
                            CHtml::encode($offer->product->title)); ?>
                    </div>
                    <div class="offer-brand-data uk-hidden">
                        <?php echo Brand::getFormatedTitle(CHtml::encode($offer->product->brand->name)); ?>
                    </div>
                    <div class="offer-title-data uk-hidden">
                        <?php echo Product::getFormatedTitle(CHtml::encode($offer->product->title)); ?>
                    </div>
                    <div class="offer-price-data uk-hidden">
                        &euro;<?php echo $offer->product->price; ?>
                    </div>
                    <div class="offer-offer-data uk-hidden">
                        &euro;<?php echo $offer->offer; ?>
                    </div>
                    <div class="offer-confirm-data uk-hidden">
                        <?php echo $offer->confirm; ?>
                    </div>
                    <div class="offer-product_id-data uk-hidden">
                        <?php echo $offer->product->id; ?>
                    </div>
                    <div class="offer-id-data uk-hidden">
                        <?php echo $offer->id; ?>
                    </div>
                    <div class="offer-offerPriceForSeller-data uk-hidden">
                        &euro;<?php echo $offerPriceForSeller; ?>
                    </div>
                    <div class="offer-originalPriceForSeller-data uk-hidden">
                        &euro;<?php echo $originalPriceForSeller; ?>
                    </div>
                    <div class="offer-userName-data uk-hidden">
                        <?php echo $offer->user->username; ?>
                    </div>
                    <!--END UNVISIBLE DATA-->
                    <?php endif; ?>
                    <?php }
                    endforeach; ?>
                    <?php else : ?>
                        <div>
                            <?php echo Yii::t('base', 'you don`t have offers yet') ?>
                        </div>
                    <?php endif; ?>
                </div>
        </li>
        <?php endif; ?>
        <!--END SECOND SWITCHER ELEMENT - INBOX-->
        <!-- START THIRD SWITCHER ELEMENT - MY OFFERS -->
        <li>
            <div class="comments-wrapper uk-margin-large-left">
            <?php if ($my_offers) : ?>
                <?php foreach ($my_offers as $response) : ?>
                    <?php
                        if (isset($response->product)): ?>
                    <div class="response-wrapper">
                        <!--VISIBLE PART-->
                        <div>
                            <?=CHtml::image(Yii::app()->request->getBaseUrl(true) . "/images/exclam_mark.png");?>
                                <?=date("d.m.Y \| g:i a", strtotime($response->added_date));?>
                            <p>Offer made on:</p>
                        </div>
                        <div class="uk-grid">
                            <?php
                                $encodedProductTitle = Product::getFormatedTitle(CHtml::encode($response->product->title));
                                $encodedBrandTitle = Brand::getFormatedTitle(CHtml::encode($response->product->brand->name));
                                $productUrl = $this->createAbsoluteUrl(Product::getProductUrl($response->product->id, $response->product));
                                $brandUrl = Brand::getBrandLink($response->product->brand->name);
                            ?>
                            <div class="uk-width-1-4">
                                <div class="image-wrapper">
                                    <a title="Product image - <?php echo $encodedProductTitle; ?>" href="<?php echo $productUrl; ?>">
                                        <?=CHtml::image(
                                            Yii::app()->request->getBaseUrl(true) . ShopConst::IMAGE_THUMBNAIL_DIR . $response->product->image1,
                                            CHtml::encode($response->product->title));?>
                                    </a>
                                </div>
                            </div>
                            <div class="uk-width-3-4">
                                <div class="uk-margin-bottom">
                                    <b>
                                        <a title="<?php echo $encodedBrandTitle; ?>" href="<?php echo $brandUrl; ?>">
                                            <?= $encodedBrandTitle ?>
                                        </a>
                                    </b>
                                    <div>
                                        <a title="<?php echo $encodedProductTitle; ?>" href="<?php echo $productUrl; ?>">
                                            <?= $encodedProductTitle; ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="uk-margin-bottom">
                                    <div>
                                        <?php echo Yii::t('base', 'to'), ' ', $response->product->user->username; ?>
                                    </div>
                                    <div><b><?php echo Yii::t('base', 'Your offer') ?> &euro;<?php echo $response->offer; ?></b></div>
                                </div>
                                <div class="uk-margin-bottom">
                                    <p class="response-show-context"
                                       data-uk-modal="{target: '#show-response', center: true}">
                                        <?php echo Yii::t('base', 'click to view'); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <!--END VISIBLE PART-->

                        <!--UNVISIBLE DATA-->
                        <div class="response-image-data uk-hidden">
                            <?php echo CHtml::image(
                                Yii::app()->request->getBaseUrl(true) . ShopConst::IMAGE_THUMBNAIL_DIR . $response->product->image1,
                                CHtml::encode($response->product->title)); ?>
                        </div>
                        <div class="response-brand-data uk-hidden">
                            <?php echo Brand::getFormatedTitle(CHtml::encode($response->product->brand->name)); ?>
                        </div>
                        <div class="response-title-data uk-hidden">
                            <?php echo Product::getFormatedTitle(CHtml::encode($response->product->title)); ?>
                        </div>
                        <div class="response-price-data uk-hidden">
                            &euro;<?php echo $response->product->price; ?>
                        </div>
                        <div class="response-offer-data uk-hidden">
                            &euro;<?php echo $response->offer; ?>
                        </div>
                        <div class="response-message-data uk-hidden">
                            <?php if ($response->confirm === '0'): ?>
                                <span>
                                                        <?php echo Yii::t('base', 'Sorry, your offer was rejected. Make a new offer!'); ?>
                                                    </span>
                            <?php elseif ($response->confirm === '1'): ?>
                                <span>
                                                        <?php echo Yii::t('base', 'Congratulations! Your offer is accepted. New price:'); ?>
                                                    </span>
                                &euro;<?php echo $response->offer; ?>
                            <?php endif; ?>
                        </div>
                        <div class="response-confirm-data uk-hidden">
                            <?php echo $response->confirm; ?>
                        </div>
                        <div class="response-product_id-data uk-hidden">
                            <?php echo $response->product->id; ?>
                        </div>
                        <div class="response-id-data uk-hidden">
                            <?php echo $response->id; ?>
                        </div>
                        <!--END UNVISIBLE DATA-->
                    </div>
                    <?php endif; endforeach; ?>
                    <?php else : ?>
                    <div>
                        <?php echo Yii::t('base', 'you haven\'t made offers yet') ?>
                    </div>
                    <?php endif; ?>
                </div>
        </li>
    </ul>
</div>

<!--MODAL OFFER INFO FOR SELLER-->
<div id="show-offer" class="uk-modal uk-modal-make-offer">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="uk-container uk-container-center">
            <div class="uk-text-center uk-text-left-small uk-h2 uk-text-normal uk-margin-large-bottom">
                <?php echo Yii::t('base', 'accept offer?'); ?>
            </div>
            <div
                class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-2 uk-grid-width-medium-1-2 uk-grid-width-small-1-1 uk-push-1-4">
                <div>
                    <div class="uk-grid">
                        <div class="uk-width-1-4">
                            <div id="modal-offer-image-data" class="image-wrapper">
                                <!--IMAGE DATA-->
                            </div>
                        </div>
                        <div class="uk-width-3-4">
                            <div class="uk-margin-bottom">
                                <b id="modal-offer-brand-data"><!--BRAND DATA--></b>
                                <div id="modal-offer-title-data"><!--TITLE DATA--></div>
                            </div>
                            <div class="uk-margin-bottom">
                                <div>
                                    <?php echo Yii::t('base', 'Original price'); ?>
                                </div>
                                <div>
                                    <b id="modal-offer-price-data"><!--PRICE DATA--></b>
                                    (&nbsp;<?php echo Yii::t('base', 'you get'); ?>
                                    <span id="modal-offer-originalPriceForSeller-data">
                                        <!--ORIGINAL PRICE FOR SELLER DATA-->
                                    </span>&nbsp;)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-grid">
                <div class="uk-width-1-1 uk-text-center">
                    <b id="modal-offer-userName-data"><!--USERNAME DATA--></b>
                    <?php echo Yii::t('base', 'offered you'); ?>
                    <b id="modal-offer-offer-data"><!--OFFER DATA--></b>
                    (&nbsp;<?php echo Yii::t('base', 'you get'); ?>
                    <span id="modal-offer-offerPriceForSeller-data">
                            <!--OFFER PRICE FOR SELLER DATA-->
                        </span>&nbsp;)
                    <?php echo Yii::t('base', 'for this item'); ?>
                </div>
            </div>
            <div class="uk-grid uk-margin-large-top">
                <div class="uk-width-1-1 uk-text-center">
                    <button id="button-offer-confirm" class="uk-button uk-button-large">
                        <?php echo Yii::t('base', 'accept'); ?>
                    </button>
                    <button id="button-offer-cancel" class="uk-button uk-button-large uk-margin-left">
                        <?php echo Yii::t('base', 'reject'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END MODAL OFFER INFO FOR SELLER-->

<!--MODAL RESPONSE INFO FOR BUYER-->
<div id="show-response" class="uk-modal uk-modal-make-offer">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="uk-container uk-container-center">
            <div class="uk-text-center uk-text-left-small uk-h2 uk-text-normal uk-margin-large-bottom">
                <?php echo strtolower(Yii::t('base', 'Your offer')); ?>
            </div>
            <div
                class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-2 uk-grid-width-medium-1-2 uk-grid-width-small-1-1 uk-push-1-4">
                <div>
                    <div class="uk-grid">
                        <div class="uk-width-1-4">
                            <div id="modal-response-image-data" class="image-wrapper">
                                <!--IMAGE DATA-->
                            </div>
                        </div>
                        <div class="uk-width-3-4">
                            <div class="uk-margin-bottom">
                                <b id="modal-response-brand-data"><!--BRAND DATA--></b>
                                <div id="modal-response-title-data"><!--TITLE DATA--></div>
                            </div>
                            <div class="uk-margin-bottom">
                                <div>
                                    <?php echo Yii::t('base', 'Original price'); ?>
                                </div>
                                <div><b id="modal-response-price-data"><!--PRICE DATA--></b></div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-margin-bottom uk-text-center">
                        <?php echo Yii::t('base', 'Your offer'); ?>
                        <div id="modal-response-offer-data"><!--PRICE DATA--></div>
                    </div>
                    <div id="modal-response-message-data" class="uk-text-center"><!--MESSAGE DATA--></div>
                    <div id="modal-response-action-data" class="uk-text-center uk-hidden">
                        <button id="add_to_bag"
                                class="uk-button uk-margin-top open-bag"
                                product-id=""
                                offer-id="">
                            <?php echo Yii::t('base', 'add to bag'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END MODAL RESPONSE INFO FOR BUYER-->

<script type="text/javascript">
    var inbox_offer_obj = {
        offer_id: null,
        product_id: null,
        link: null,
        changedLinkText: '',
        CONFIRM: 'confirm',
        CANCEL: 'cancel',
        reset: function () {
            this.offer_id = null;
            this.product_id = null;
            this.link = null;
        },
        is_valid: function () {
            return (this.offer_id != null && this.product_id != null);
        },
        changeLink: function(){
            $(this.link).replaceWith('<p>' + this.changedLinkText + '</p>');
        }
    };

    var cacheReadedInfo;

    $(document).ready(function () {
        $('#more-comments a').click(function(event) {
            $(this).hide('slow');
            $('.hidden_comments').show('slow');
            return false;
        });
        // seller part
        //
        $('.offer-show-context').click(function () {
            var wrapper = $(this).closest('.offer-wrapper');

            // get data from hidden part of offer
            //
            var image = $(wrapper).children('.offer-image-data').html().trim();
            var brand = $(wrapper).children('.offer-brand-data').html().trim();
            var title = $(wrapper).children('.offer-title-data').html().trim();
            var price = $(wrapper).children('.offer-price-data').html().trim();
            var offer = $(wrapper).children('.offer-offer-data').html().trim();
            var offerPriceForSeller = $(wrapper).children('.offer-offerPriceForSeller-data').html().trim();
            var originalPriceForSeller = $(wrapper).children('.offer-originalPriceForSeller-data').html().trim();
            var userName = $(wrapper).children('.offer-userName-data').html().trim();

            var product_id = parseInt($(wrapper).children('.offer-product_id-data').html().trim());
            var offer_id = parseInt($(wrapper).children('.offer-id-data').html().trim());
            var confirm_data = parseInt($(wrapper).children('.offer-confirm-data').html().trim());

            var confirm = confirm_data === 1;

            // set data to modal
            //
            $('#modal-offer-image-data').html(image);
            $('#modal-offer-brand-data').html(brand);
            $('#modal-offer-title-data').html(title);
            $('#modal-offer-price-data').html(price);
            $('#modal-offer-offer-data').html(offer);
            $('#modal-offer-userName-data').html(userName);
            $('#modal-offer-offerPriceForSeller-data').html(offerPriceForSeller);
            $('#modal-offer-originalPriceForSeller-data').html(originalPriceForSeller);

            inbox_offer_obj.offer_id = offer_id;
            inbox_offer_obj.product_id = product_id;
            inbox_offer_obj.link = this;
        });

        $('#button-offer-cancel').click(function () {
            if (inbox_offer_obj.is_valid()) {
                $.ajax({
                    url: globals.url + '/members/profile/resolveOffer',
                    type: 'POST',
                    data: {
                        offer_id: inbox_offer_obj.offer_id,
                        product_id: inbox_offer_obj.product_id,
                        confirm: inbox_offer_obj.CANCEL
                    },
                    'dataType' : 'json',
                    success: function (data) {
                        if (data.status == 'success') {
                            UIkit.modal('#show-offer').hide();
                            inbox_offer_obj.changedLinkText = data.newText;
                            inbox_offer_obj.changeLink();
                            inbox_offer_obj.reset();
                        }
                    }
                });
            }
        });

        $('#button-offer-confirm').click(function () {
            if (inbox_offer_obj.is_valid()) {
                $.ajax({
                    url: globals.url + '/members/profile/resolveOffer',
                    type: 'POST',
                    data: {
                        offer_id: inbox_offer_obj.offer_id,
                        product_id: inbox_offer_obj.product_id,
                        confirm: inbox_offer_obj.CONFIRM
                    },
                    'dataType' : 'json',
                    success: function (data) {
                        if (data.status == 'success') {
                            UIkit.modal('#show-offer').hide();
                            inbox_offer_obj.changedLinkText = data.newText;
                            inbox_offer_obj.changeLink();
                            inbox_offer_obj.reset();
                        }
                    }
                });
            }
        });
        //
        // end seller part

        // buyer part
        //
        $('#add_to_bag').on('click', function () {
            var product_id = $(this).attr('product-id');
            var offer_id = $(this).attr('offer-id');
            var url = globals.url + '/members/shop/addToBagWithDiscount';

            var data = {
                product: product_id,
                offer: offer_id
            };

            UIkit.modal('#show-response').hide();

            $.post(url, data, function (response) {
                $('#cart').html(response);
            });


            // for mobile bag
            //
            var mobile_url = globals.url + '/members/shop/addToMobileBagWithDiscount';
            $.post(mobile_url, data, function(response){
                $('#cart-mobile-link').html(response);

                if(window.innerWidth < 960){
                    UIkit.modal('#cart-mobile-window').show();
                    $('.uk-navbar-toggle').trigger('click');
                }
            });
        });

        $('.response-show-context').click(function () {
            var wrapper = $(this).closest('.response-wrapper');
            // get data from hidden part of response
            //
            var image = $(wrapper).children('.response-image-data').html().trim();
            var brand = $(wrapper).children('.response-brand-data').html().trim();
            var title = $(wrapper).children('.response-title-data').html().trim();
            var price = $(wrapper).children('.response-price-data').html().trim();
            var offer = $(wrapper).children('.response-offer-data').html().trim();
            var message = $(wrapper).children('.response-message-data').html().trim();

            var product_id = parseInt($(wrapper).children('.response-product_id-data').html().trim());
            var offer_id = parseInt($(wrapper).children('.response-id-data').html().trim());
            var confirm_data = parseInt($(wrapper).children('.response-confirm-data').html().trim());

            var confirm = confirm_data === 1;
            // set data to modal
            //
            $('#modal-response-image-data').html(image);
            $('#modal-response-brand-data').html(brand);
            $('#modal-response-title-data').html(title);
            $('#modal-response-price-data').html(price);
            $('#modal-response-offer-data').html(offer);
            $('#modal-response-message-data').html(message);
            $('#add_to_bag').attr('product-id', product_id);
            $('#add_to_bag').attr('offer-id', offer_id);

            // set visibility for add_to_bug button
            //
            if (confirm) {
                $('#modal-response-action-data').removeClass('uk-hidden');
            } else {
                $('#modal-response-action-data').addClass('uk-hidden');
            }
        });
        //
        // end buyer part

        $('[data-uk-switcher]').on('show.uk.switcher', function(event, area){
            if ($(area).index() == 1) { //offers
                var offersCntInfo = $(area).find('.uk-text-danger');
                offersCntInfo.remove();
                $('ul.uk-list-switcher li:first .uk-text-danger').remove();
                $('#inbox-menu-item').html('');
                if (typeof cacheReadedInfo == 'undefined') {
                    var url    = globals.url + '/members/profile/setOffersAsRead';
                    $.ajax({
                        url: url,
                        type: 'POST',
                        'dataType' : 'html',
                        success: function (response) {
                            cacheReadedInfo = response;
                            $('#inbox-menu-item').html(response);
                        }
                    });
                }
            }

            if ($(area).index() == 2) { //my (unused) offers
                var offersCntInfo = $(area).find('.uk-text-danger');
                if (offersCntInfo.length > 0) {
                    var url    = globals.url + '/members/profile/setConfirmedOffersAsRead';
                    $.ajax({
                        url: url,
                        type: 'POST',
                        'dataType' : 'html',
                        success: function (response) {
                            offersCntInfo.remove();
                            $('#inbox-menu-item').html(response);
                        }
                    });
                }
            }
        });
    });
</script>















