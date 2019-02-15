<!--PAGINATION AND VIEW-->
<div class="pagination-block">
    <div class="uk-grid uk-margin-large-top">
        <!--FILTER-->
        <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1 uk-margin-bottom">

        </div>
        <!--END FILTER-->
        <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
            <div class="uk-grid uk-padding-small-screen">
                <?php
                if($products) {
                    $this->renderPartial('_filter_nav',
                        array(
                            'products' => $products,
                            'pages' => $pages
                        )
                    );
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!--END PAGINATION AND VIEW-->

<!--GRID ITEMS-->
<div class="block-category">

    <?php
    $count = count($products);
    $countInRow = 0;

    if ($count > 0) : ?>

        <?php for ($i = 0;
                   $i < $count;
                   $i++) : ?>
            <?php
            $brand = Brand::model()->findByPk($products[$i]['brand_id']);
            $category = Category::model()->findByPk($products[$i]['category_id']);
            ?>
            <?php $isNewRow = (($i % 4) == 0 || $i == 0); ?>
            <?php $modalParameters = ""; ?>
            <div <?php echo $isNewRow ?
                // new row
                'class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-4 uk-grid-width-medium-1-4 uk-grid-width-small-1-2">' .
                '<div class="thumbnail uk-margin-bottom">' :
                // new item
                'class="thumbnail uk-margin-bottom">'; ?>
            <?php
                $url = $this->createAbsoluteUrl(Product::getProductUrl($products[$i]['id']));
                $target = "_self";
                $partner_site_name = $partner_site_url = '';
                if ($products[$i]['external_sale'] && !(empty($products[$i]['direct_url']))) {
                    $url = $products[$i]['direct_url'];
                    $target = "_blank";
                    $partner = Product::getExternalSiteName($url);
                    $partner_site_name = $partner['name'];
                    $partner_site_url = $partner['url'];
                }
            
            ?>
            
            <a href="<?php echo $url; ?>" <?=$modalParameters; ?> class="uk-display-block product-url" target="<?= $target ?>">
                <div class="thumbnail-image">
                    <?=CHtml :: image(
                        Yii :: app() -> request -> getBaseUrl(true) . ShopConst :: IMAGE_MEDIUM_DIR . $products[$i]['image1'],
                        ($products[$i]['title']) ? CHtml::encode($products[$i]['title']) : CHtml::encode(Category::model()->getAliasById($products[$i]['category_id'])),
                        array('onerror' => '$(this).prop({"class" : "no-image", "src" : "/images/prod-no-img.png"})')
                    )?>
                    <?php if (!Wishlist::in_wishlist($products[$i]['id']) && !Yii::app()->member->isGuest) : ?>
                        <p class="pagination-centered">
                            <?php echo CHtml::link('Add to wishlist', 'javascript:void(0)', array(
                                'class' => 'pagination-centered',
                                'onclick' => 'addItemToWishList(this, ' . $products[$i]['id'] . ')'
                            )); ?>
                        </p>
                    <?php endif; ?>
                </div>
                <div class="uk-h4 thumbnail-title uk-margin-small-top">
                    <?php echo Brand::getFormatedTitle($products[$i]->brand->name); ?>
                </div>
            </a>
            <div class="thumbnail-description uk-margin-top-mini uk-margin-large-left">
                <?php echo Product::getFormatedTitle(CHtml::encode($products[$i]['title'])); ?>
            </div>
            <div class="thumbnail-details uk-margin-large-left">

                <?php
                $old_price = $products[$i]['init_price'];
                $new_price = $products[$i]['price'];
                $equal = $old_price === $new_price;
                ?>

                <?php if($products[$i]['status'] != Product::PRODUCT_STATUS_SOLD) { ?>
                    <span class="<?php echo !$equal ? 'price price-old' : 'price' ?>">
                    &euro;<?php echo $old_price;; ?>
                </span>
                    <?php if (!$equal): ?>
                        <span class="price-new" style="color:red !important;">
                        &euro;<?php echo $new_price; ?>
                    </span>
                    <?php endif; ?>
                <?php } else { ?>
                    <span class="price-new" style="margin-right: 25px;">SOLD</span>
                <?php } ?>

            </div>
            <?php if (!empty($partner_site_name)): ?>
                <div class="partner-name">
                    <div class="partner-lnk">
<!--                        <a href="<?= $partner_site_url; ?>" <?= $modalParameters; ?> class="product-url" target="<?= $target ?>">Shop on <?= $partner_site_name ?></a>-->
                        <a href="<?= $url; ?>" <?= $modalParameters; ?> class="product-url" target="<?= $target ?>">Shop on <span><?= ucfirst($partner_site_name) ?></span></a>
                    </div>
                </div>
            <?php endif; ?>

            <?php
            $countInRow++;

            if ($countInRow == 4 || $i == ($count - 1)) {
                echo '</div></div>';
                $countInRow = 0; // reset counter for next row
            } else {
                echo '</div>';
            } ?>
        <?php endfor; ?>
    <?php else: ?>
        <?php echo Yii::t('base', 'No products yet'); ?>
    <?php endif; ?>

</div>
<!--END GRID ITEMS-->

<!--PAGINATION AND VIEW-->
<div class="pagination-block">
    <div class="uk-grid uk-margin-large-top">
        <!--FILTER-->
        <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1 uk-margin-bottom">

        </div>
        <!--END FILTER-->
        <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
            <div class="uk-grid uk-padding-small-screen">
                <?php
                if($products) {
                    $this->renderPartial('_filter_nav',
                        array(
                            'products' => $products,
                            'pages' => $pages
                        )
                    );
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!--END PAGINATION AND VIEW-->

<div id="sold-out" class="uk-modal">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="uk-container uk-container-center" id="report-div">

            <div class="offset3 span6 pull-left">
                <div class="uk-text-center uk-text-left-small uk-h1 uk-text-normal uk-margin-bottom" style="font-size:24px"><?=Yii::t('base', 'SOLD OUT')?></div>
            </div>

            <div class="offset3 span6 pull-left">
                <div class="uk-text-center uk-text-left-small uk-h4 uk-text-normal uk-margin-large-bottom" style="font-size:14px">
                    see more <a href="" class="uk-base-link" id="filter-link"><span id="filter-text"></span></a>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function(){
        $('.product-url').click(function(){
            var link_text = $(this).data('brand-name') + ' ' + $(this).data('category-name');
            var link_url = '/filter/br/'+$(this).data('brand-id')+'/ct/'+$(this).data('category-id');
            $('#filter-text').text(link_text);
            $('a#filter-link').attr('href',link_url);
        });
    });

</script>

