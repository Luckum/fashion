<?php
    $productTitle = Product::getFormatedTitle(CHtml::encode($model->title));
    $brandName = Brand::getFormatedTitle(CHtml::encode($model->brand->name));
?>
<div class="uk-block uk-margin-large-top">
    <div id="photo-zoom-container" class="uk-container uk-container-center">
        <div class="uk-text-center" style="margin-top: -60px;">
            <div>
                <ul class="uk-breadcrumb">
                    <li>
                        <?php
                            if($model->category->parent == NULL) {
                                $parent = $model->category->getNameByLanguage();
                                echo "<a href='/$parent->name-all'>".strtolower($parent->header_text ? CHtml::encode($parent->header_text) : CHtml::encode($parent->name))."</a>";
                            } else {
                                $parent = $model->category->parent->getNameByLanguage();
                                echo "<a href='/$parent->name-all'>".strtolower($parent->header_text ? CHtml::encode($parent->header_text) : CHtml::encode($parent->name))."</a>";
                            }
                            
                        ?>
                    </li>
                    <?php if($model->category->parent != NULL): ?>
                        <li><?= "<a href='/$parent->name-" . strtolower(CHtml::encode($model->category->getNameByLanguage()->name))."'>".strtolower(CHtml::encode($model->category->getNameByLanguage()->name))."</a>"; ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="uk-block" style="margin-top: -20px;">
            <div class="uk-grid">
                <div
                    class="uk-width-1-1 uk-width-large-1-10 uk-width-medium-1-10 uk-text-right uk-text-left-small uk-margin-bottom">
                    <a href="javascript:void(0);" onclick="goBack()">&lt; <?=Yii::t('base', 'back')?></a>
                </div>
                <?php
                $baseUrl = Yii:: app()->request->getBaseUrl(true);
                $medium_dir = $baseUrl . ShopConst::IMAGE_MEDIUM_DIR;
                $big_dir = $baseUrl . ShopConst::IMAGE_MAX_DIR;
                ?>
                <div id="photo-zoom-wrapper" class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 photo-zoom-in">
                    <div class="product-image-wrapper wishlist-wrapper">
                        <?php if (!empty($model['image1'])): ?>
                            <?= CHtml::image($medium_dir . $model['image1'], $productTitle, array(
                                'id' => 'image1',
                                'small' => $medium_dir . $model['image1'],
                                'big' => $big_dir . $model['image1']
                            )) ?>
                        <?php endif; ?>
                        <?php if (!empty($model['image2'])): ?>
                            <?= CHtml::image($medium_dir . $model['image2'], $productTitle, array(
                                'id' => 'image2',
                                'small' => $medium_dir . $model['image2'],
                                'big' => $big_dir . $model['image2'],
                                'onerror' => '$(this).remove()'
                            )) ?>
                        
                        <?php endif; ?>
                        <?php if (!empty($model['image3'])): ?>
                            <?= CHtml::image($medium_dir . $model['image3'], $productTitle, array(
                                'id' => 'image3',
                                'small' => $medium_dir . $model['image3'],
                                'big' => $big_dir . $model['image3'],
                                'onerror' => '$(this).remove()'
                            )) ?>
                        <?php endif; ?>
                        <?php
                            if (!empty($model['image4'])) {
                                echo CHtml::image($medium_dir . $model['image4'], $productTitle, array(
                                    'id' => 'image4',
                                    'small' => $medium_dir . $model['image4'],
                                    'big' => $big_dir . $model['image4'],
                                    'onerror' => '$(this).remove()'
                                ));
                            }
                            if (!empty($model['image5'])) {
                                echo CHtml::image($medium_dir . $model['image5'], $productTitle, array(
                                    'id' => 'image5',
                                    'small' => $medium_dir . $model['image5'],
                                    'big' => $big_dir . $model['image5'],
                                    'onerror' => '$(this).remove()'
                                ));
                            }
                         ?>
                        <?php if (!Yii::app()->member->isGuest): ?>
                            <a id="add_to_wish" href="#"
                               class="<?= Wishlist::in_wishlist($model->id) ? 'uk-icon-star' : 'uk-icon-star-o' ?> wishlist-icon wishlist-additional-style"
                               data-uk-tooltip="{pos:'right'}" title="<?=Yii::t('base', 'add to wishlist')?>"></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="uk-width-1-1 uk-width-large-3-10 uk-width-medium-3-10 outer-product-info">
                    <h2 class="uk-margin-right product-title"><?= '<a href="/brands/'.strtolower($model->brand->url).'">'.$brandName.'</a>' ?></h2>
                    <br>
                    <h1 style="font-size:14px !important;" class="uk-margin-right product-title"><?php echo $productTitle; ?></h1>
                    <div class="product-description uk-padding-top-large">
                        <div class="product-detail">
                            <?php if($model->isVisible): ?>
                                <?php if($model->price == $model->init_price): ?>
                                    <div class="uk-h3-lg">&euro;<?= $model->price ?></div>
                                <?php else: ?>
                                    <div class="uk-h3-lg price"><span style="margin-right:10px;text-decoration: line-through;">&euro;<?= $model->init_price ?></span> <span class="uk-h3-lg price price-new" style="color: red !important;">&euro;<?=$model->price?></span></div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="uk-h3-lg price"><span style="margin-right:10px;">&euro;<?= $model->price ?></span> <span class="uk-h3-lg price price-new">SOLD</span></div>
                            <?php endif; ?>
                        </div>
                        <?php if(!$model->external_sale): ?>
                            <?php if($model->isVisible): ?>
                                <div class="uk-margin-large-top">
                                    <a id="add_to_bag" href="#" class="uk-button open-bag">
                                        <b><?= Yii::t('base', 'add to bag') ?></b>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($isCanAddCommentsAndMakeOffers && $model->isVisible): ?>
                                <div class="uk-margin-large-top">
                                    <a href="#make-offer" data-uk-modal="{center:true}"
                                       class="uk-button"><?= Yii::t('base', 'make an offer') ?></a>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php 
                                $url = $model->direct_url;
                                $partner = Product::getExternalSiteName($url);
                                $partner_site_name = $partner['name'];
                                $partner_site_url = $partner['url'];
                            ?>
                            <div class="uk-margin-large-top" style="display: inline-block;">
                                <a href="<?=$model->direct_url?>" target="_blank" style="width:200px;" class="uk-button open-bag">
                                    shop on <span><?= $partner_site_name ?></span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="product-information">
                        <div>
                            <span class="uk-margin-small-right"><?=Yii::t('base', 'share')?>:</span>
                            <?php $p_link = $this->createAbsoluteUrl(Product::getProductUrl($model->id, $model))?>
                            <ul class="social-list">
                                <li><a href="#"
                                       onclick="Share.facebook('<?=$p_link?>', 'n2315.COM', '<?= $this->createAbsoluteUrl('/images/upload/' . $model->image1) ?>', '<?= $model->brand->name . ', ' . CHtml::encode($model->title) ?>', '')"><i
                                            class="uk-icon-facebook"></i></a></li>
                                <li><a href="#"
                                       onclick="Share.twitter('<?=$p_link?>', '<?= $model->brand->name . ' ' . CHtml::encode($model->title) ?>', 'n2315.com')"><i
                                            class="uk-icon-twitter"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="make-offer" class="uk-modal uk-modal-make-offer">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="uk-container uk-container-center">
            <div class="uk-text-center uk-text-left-small uk-h2 uk-text-normal uk-margin-large-bottom">
                <?=Yii::t('base', 'make an offer')?>
            </div>
            <div class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-2 uk-grid-width-medium-1-2 uk-grid-width-small-1-1 uk-push-1-4">
                <div>
                    <div class="uk-grid">
                        <div class="uk-width-1-4">
                            <div class="image-wrapper">
                                <?php if (!empty($model['image1'])): ?>
                                    <?= CHtml::image($baseUrl . ShopConst::IMAGE_THUMBNAIL_DIR . $model['image1'], $productTitle) ?>
                                <?php else: ?>
                                    <?= CHtml::image($model['image_url1'], $productTitle) ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="uk-width-3-4">
                            <div class="uk-margin-bottom">
                                <b><?= $brandName ?></b>
                                <div><?= $productTitle ?></div>
                            </div>
                            <div><?=Yii::t('base', 'Original price')?>:</div>
                            <div><b>&euro;<?= $model->price ?></b></div>
                        </div>
                    </div>
                    <div class="uk-margin-large-top uk-text-center uk-text-left-small">
                        <div class="uk-margin-large-bottom"><?= Yii::t('base', 'Your offer') ?></div>
                        <form action="#" class="uk-form">
                            <div class="uk-form-row">
                                <div class="uk-margin-large-bottom">
                                    <span class="euro uk-margin-small-right">&euro;</span>
                                    <?= CHtml::textField('offer_price', '', array('class' => 'uk-form-small')) ?>
                                </div>
                                <button id="submit_offer" type="button"
                                        class="uk-button"><?= Yii::t('base', 'submit') ?></button>
                            </div>
                        </form>
                    </div>
                    <div
                        class="uk-margin-large-top font-size-smaller uk-text-center uk-text-left-small"><?= Yii::t('base', 'You’ll get an email once the seller accepts or denies your offer.') ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="size_chart" class="uk-modal uk-modal-size">
    <?php $sizes = SizeChart:: model()->getSizes($model->category->size_chart_cat_id, false); ?>
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div id="szchart-page-wrapper" class="uk-container uk-container-center">
            <!--Заголовок-->
            <div class="uk-h1" style="text-align: center; padding: 20px 0;"><?=Yii::t('base', 'size chart')?></div>

            <!--Таблица соответствия размеров-->
            <div class="uk-overflow-container">
                <table>
                    <caption><?=$sizes[0]?></caption>
                    <?php if (count($sizes[1])): ?>
                        <?php
                        $head = $body = '';
                        foreach ($sizes[1] as $k => $v) {
                            $head .= '<th>' . $k . '</th>';
                            $body .= '<td>';
                            foreach ($v as $item) {
                                $body .= $item[1] . '<br/>';
                            }
                            $body .= '</td>';
                        }
                        $content = '<tr>' . $head . '</tr>' .
                            '<tr>' . $body . '</tr>' ;
                        echo $content;
                        ?>
                    <?php else: ?>
                        <tr>
                            <td><?=Yii::t('base', 'There is no chart for this product.')?></td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>

            <h5 style="text-align:center"><?=Yii::t('base', 'This sizing chart is approximate. Please see item\'s description or contact the seller for more information')?></h5>
        </div>
    </div>
</div>

<div id="shipping-info" class="uk-modal uk-modal-shipping">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="uk-container uk-container-center">
            <div class="uk-text-center uk-text-left-small uk-h2 uk-text-normal uk-margin-large-bottom">
                <?= Yii::t('base', 'shipping info') ?>
            </div>
            <div>
                <p><?=Yii::t('base', 'Shipping is calculated at checkout and will be charged extra at the time of purchase. We offer a flat delivery fee which is based on the lowest price shipping option available for the item in your order.')?></p>
                <b><?=Yii::t('base', 'National')?></b>: &euro;10
                <br/>
                <b><?=Yii::t('base', 'European countries (EU)')?></b>: &euro;15
                <br/>
                <b><?=Yii::t('base', 'World')?></b>: &euro;30
                <p><?=Yii::t('base', 'You may have to pay import duties or any other local taxes upon receipt of your order or at a later date depending on customs authority in your country.')?></p>
            </div>
        </div>
    </div>
</div>

<div id="report-product" class="uk-modal uk-modal-report">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="uk-container uk-container-center" id="report-div">

            <div class="offset3 span6 pull-left">
                <div class="uk-text-center uk-text-left-small uk-h2 uk-text-normal uk-margin-large-bottom"><?=Yii::t('base', 'Report Item')?></div>
            </div>

            <!--Form-->
            <?php echo CHtml :: beginForm(); ?>

            <?php $profile = $this -> createAbsoluteUrl('members/profile-' . $model -> user -> id)?>
            <?php $page    = $this -> createAbsoluteUrl(Yii :: app() -> request -> url)?>

            <div class="uk-grid uk-grid-width-1-3 uk-grid-width-large-1-4 uk-grid-width-medium-1-4 uk-grid-width-small-1-3 uk-push-1-5">
                <div><b><?=CHtml :: label(Yii :: t('base', 'User Profile'), 'user-profile')?></b></div>
                <div><?=$profile?></div>
            </div>

            <div class="uk-grid uk-grid-width-1-3 uk-grid-width-large-1-4 uk-grid-width-medium-1-4 uk-grid-width-small-1-3 uk-push-1-5">
                <div><b><?=CHtml :: label(Yii :: t('base', 'Product Page'), 'product-page')?></b></div>
                <div><?=$page?></div>
            </div>

            <div class="uk-grid uk-grid-width-1-3 uk-grid-width-large-1-4 uk-grid-width-medium-1-4 uk-grid-width-small-1-3 uk-push-1-5">
                <div><b><?=CHtml :: label(Yii :: t('base', 'Your comment'), 'comment')?></b></div>
                <div><b><?=CHtml :: TextArea('complaint', '', array('class' => 'comment-textarea', 'style' => 'width:200% !important;font-size:14px'))?></b></div>
            </div>

            <div class="uk-grid uk-grid-width-1-2 uk-grid-width-large-1-4 uk-grid-width-medium-1-4 uk-grid-width-small-1-2 uk-push-1-5">
                <div><b></b></div>
                <div>
                    <b><?=CHtml :: button(Yii :: t('base', 'submit'), array(
                            'class' => 'uk-button report-item',
                            'data-pid' => $model -> id,
                            'data-prf' => $profile,
                            'data-pge' => $page
                        )); ?>
                    </b>
                </div>
            </div>

            <?php echo CHtml::endForm(); ?>
            <!--Form end-->

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        /*var url = '<?= Yii:: app()->createUrl("/members/auth/login") ?>';
        var wrapper = $('#login_content');

       $.ajax({
            'url': url,
            success: function (data) {
                console.log(data);
                if (data == '0') {
                    $("#submit-form").trigger('click');
                } else {
                    $(wrapper).html(data);
                }
            }
        });*/
        /**
         * Пожаловаться (Report Item).
         */
        $('.report-item').on('click', function() {
            // Текст жалобы.
            var complaint = $('#complaint').val();
            if (!complaint.length) {
                alert('<?=Yii::t('base', 'Text of complaint is empty!')?>');
            }
            var url = globals.url + '/members/shop/report';
            var data = {
                'pid' : $(this).data('pid'),
                'prf' : $(this).data('prf'),
                'pge' : $(this).data('pge'),
                'cmp' : complaint
            };
            $.post(url, data, function(response) {
                location.reload();
            });
        });
        /**
         * Добавление товара в wishlist.
         */
        $('#add_to_wish').on('click', function () {
            var url = globals.url + '/members/shop/toggleWishlist';
            var data = {'id': <?=$model->id?>};
            var a = $(this);
            $.post(url, data, function () {
                if (a.hasClass('uk-icon-star')) {
                    a.removeClass('uk-icon-star').addClass('uk-icon-star-o');
                } else {
                    a.removeClass('uk-icon-star-o').addClass('uk-icon-star');
                }
            });
        });
        /**
         * Добавление товара в корзину.
         */
        $('#add_to_bag').on('click', function () {
            var url = globals.url + '/members/shop/addToBag';
            var data = {'id': <?=$model->id?>};

            $.post(url, data, function (response) {
                $('#cart').html(response);
                scrollbar();
            });

            // for mobile bag
            //
            var mobile_url = globals.url + '/members/shop/addToMobileBag';
            $.post(mobile_url, data, function(response){
                $('#cart-mobile-link').html(response);

                if(window.innerWidth < 960){
                    UIkit.modal('#cart-mobile-window').show();
                    $('.uk-navbar-toggle').trigger('click');
                }
            });
        });
        /**
         * Предложение новой цены за товар.
         */
        $('#submit_offer').on('click', function () {
            var url = globals.url + '/members/shop/makeOffer';
            var data = {'id': <?=$model->id?>, 'new_price': $('#offer_price').val()};
            $.post(url, data, function () {
                $('#make-offer .uk-modal-close').click();
            });
        });
        /**
         * Проверка новой цены за товар на корректность.
         */
        $('#offer_price').keyup(function (e) {
            this.value = this.value.replace(/^\.|[^\d\.]|\.(?=.*\.)|^0+(?=\d)/g, '');
        });
        /**
         * Добавление нового комментария.
         */
        $('#add-new-comment').on('click', function () {
            var comment = $('#comment').val();
            if (!comment.length) {
                return false;
            }
            var url = globals.url + '/members/shop/newComment';
            var data = {'id': <?=$model->id?>, 'comment': comment};
            $.post(url, data, function (response) {
                var response = JSON.parse(response);
                if (response.result == 'ok') {
                    $('#comments').prepend(response.html);
                    $('#comment').val('');
                    $('#no_comments').remove();
                }
            });
        });

        // Object for zoom of product image
        //
        var zoom_obj = {
            zoom_enable: true, // ------ active or inactive zoom
            width: 0, // --------------- store start width of image wrapper
            mobile_size: 700, // ------- max width, when must be changed behavior of zoom
            mobile_rate: 1.5, // ------- rate of mobile zoom
            doc_width: document.body.clientWidth, // -- width of document in browser

            enable: function () {
                this.zoom_enable = true;
            },

            disable: function () {
                this.zoom_enable = false;
            },

            rememberSmallWidth: function (wrapper) {
                this.width = $(wrapper).css('width');
            },

            set_big_image_source: function(image){
                $(image).attr('src', $(image).attr('big'));
            },

            set_small_image_source: function(image){
                $(image).attr('src', $(image).attr('small'));
            },

            big: function (container, wrapper) {
                $(container).removeClass('uk-container-center');

                $(wrapper).attr('style', (
                'width: ' +
                ((this.doc_width > this.mobile_size) ? this.doc_width : (this.doc_width * this.mobile_rate)) +
                'px;'));
                $(wrapper).removeClass('photo-zoom-in');
                $(wrapper).addClass('photo-zoom-out');

                $(wrapper).children().children('img').each(function(index, image){
                    zoom_obj.set_big_image_source(image);
                });

            },

            small: function (container, wrapper) {
                $(container).addClass('uk-container-center');

                $(wrapper).attr('style', ('width: ' + this.width + 'px;'));
                $(wrapper).removeClass('photo-zoom-out');
                $(wrapper).addClass('photo-zoom-in');

                $(wrapper).children().children('img').each(function(index, image){
                    zoom_obj.set_small_image_source(image);
                });
            }
        };

        $('#photo-zoom-wrapper img').click(function () {
            var container = $('#photo-zoom-container');
            var wrapper = $('#photo-zoom-wrapper');

            if (zoom_obj.zoom_enable) {
                zoom_obj.rememberSmallWidth(wrapper);
                zoom_obj.disable();
                zoom_obj.big(container, wrapper);
            } else {
                zoom_obj.enable();
                zoom_obj.small(container, wrapper);
            }
        });
    });

    /**
     * Щелчок по кнопке 'back'.
     */
    function goBack() {
        location.href = document.referrer ?
            document.referrer : document.origin;
    }
</script>