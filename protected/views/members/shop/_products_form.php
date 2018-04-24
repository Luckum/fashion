<!--PAGINATION AND VIEW-->
<div class="pagination-block">
    <div class="uk-grid uk-margin-large-top">
        <!--FILTER-->
        <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1 uk-margin-bottom">
            <?php if(((isset($model->parent)) && (isset($model->parent->external_sale) && $model->parent->external_sale != 1)) || (!isset($model->parent) && (isset($model->external_sale) && $model->external_sale == 0))): ?>
            <div class="filter-wrapper" style="display:none" data-uk-dropdown="{mode:'click', justify:'#dropdown-nav'}">
                <a href="#" class="uk-button uk-button-filter uk-text-right"><?php echo Yii::t('base', 'filter'); ?> <span
                        class="filter-icon"></span></a>
                <div class="uk-dropdown" id="filter-drop-down">
                    <div class="uk-grid uk-dropdown-grid uk-margin-top-xlarge" id="filter">
                        <div class="uk-width-2-10 uk-margin-large-bottom">
                            <div class="uk-margin-bottom"><?php echo Yii::t('base', 'Category'); ?></div>
                            <ul class="filter-list">
                                <?php
                                if (!empty($model)) {
                                    if (isset($model->parent) && $model->parent) {
                                        $objectId = (strtolower(get_class($model)) == 'category') ? $model->parent->id : null;
                                    } else {
                                        $objectId = (strtolower(get_class($model)) == 'category') ? $model->id : null;
                                    }
                                } else {
                                    $objectId = null;
                                }
                                

                                foreach (Category::getSubCategoryList($objectId, false) as $id => $cat) : ?>

                                    <li <?php echo(($id && in_array($id, explode(',', $filters->category))) ?
                                        'class="filter-list-active"' :
                                        ""); ?>><!--END OPEN TAG li-->

                                        <?php echo CHtml::link(
                                            CHtml::encode($cat),
                                            '#',
                                            array(
                                                'data-filter' => 'category',
                                                'data-id' => $id,
                                                'class' => (($id && in_array($id, explode(',', $filters->category))) ? 'checked' : "")
                                            )
                                        ) ?>

                                    </li>

                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="uk-width-2-10 uk-margin-large-bottom">
                            <div class="uk-margin-bottom"><?php echo Yii::t('base', 'Brand'); ?></div>
                            <div class="scroll-pane">
                                <ul class="filter-list">
                                    <?php foreach (Brand::getAllBrands() as $id => $brand_name) : ?>

                                        <li <?php echo(($id && in_array($id, explode(',', $filters->brand))) ?
                                            'class="filter-list-active"' : ""); ?>><!--END OPEN TAG li-->

                                            <?php echo CHtml::link(
                                                CHtml::encode($brand_name),
                                                '#',
                                                array(
                                                    'data-filter' => 'brand',
                                                    'data-id' => $id,
                                                    'class' => (($id && in_array($id, explode(',', $filters->brand))) ? 'checked' : "")
                                                )
                                            ) ?>
                                        </li>

                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="uk-width-2-10 uk-margin-large-bottom">
                            <?php
                            $size_cat = null;

                            if (isset($model->size_chart_cat_id)) {
                                $size_cat = $model->size_chart_cat_id;
                            } elseif (isset($model->size_chart)) {
                                $size_cat = $model->size_chart->size_chart_cat_id;
                            }
                            ?>

                            <?php $sizes = SizeChart:: model()->getSizes($size_cat, false, $model); ?>
                            <?php if ($sizes): ?>
                                <div class="uk-margin-bottom"><?php echo $sizes[0]; ?> size</div>
                                <div class="scroll-pane">
                                    <?php foreach ($sizes[1] as $k => $v): ?>
                                        <ul class="filter-list">
                                            <li><span class="size-filter-group-value"><?php echo $k; ?></span></li>
                                            <?php foreach ($v as $item): ?>
                                                <li <?php echo(($item[0] && in_array($item[0], explode(',', $filters->size_type))) ?
                                                    'class="filter-list-active uk-margin-left"' : 'class="uk-margin-left"'); ?>>
                                                    <!--END OPEN TAG li-->

                                                    <?php echo CHtml::link($item[1], '#', array(
                                                        'data-filter' => 'size_type',
                                                        'data-id' => $item[0],
                                                        'class' => (($item[0] && in_array($item[0], explode(',', $filters->size_type))) ? 'checked' : ''),
                                                    )) ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                        </div>
                        <div class="uk-width-2-10 uk-margin-large-bottom">
                            <div class="uk-margin-bottom"><?php echo Yii::t('base', 'Country'); ?></div>
                            <div class="scroll-pane">
                                <ul class="filter-list">
                                    <?php foreach (Country::getListIdCountry() as $id => $country) : ?>
                                        <li<?php echo(($id && in_array($id, explode(',', $filters->country))) ?
                                            'class="filter-list-active"' : ""); ?>><!--END OPEN TAG li-->

                                            <?php echo CHtml::link(
                                                CHtml::encode($country),
                                                '#',
                                                array(
                                                    'data-filter' => 'country',
                                                    'data-id' => $id,
                                                    'class' => (($id && in_array($id, explode(',', $filters->country))) ? 'checked' : ""),
                                                )
                                            ) ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="uk-width-1-10 uk-margin-large-bottom">
                            <div class="uk-margin-bottom"><?php echo Yii::t('base', 'Condition'); ?></div>
                            <ul class="filter-list">
                                <?php foreach (Product::getConditions() as $id => $cond) : ?>
                                    <li <?php echo(($id && in_array($id, explode(',', $filters->condition))) ?
                                        'class="filter-list-active"' : ""); ?>><!--END OPEN TAG li-->

                                        <?php echo CHtml::link(
                                            CHtml::encode($cond),
                                            '#',
                                            array(
                                                'data-filter' => 'condition',
                                                'data-id' => $id,
                                                'class' => (($id && in_array($id, explode(',', $filters->condition))) ? 'checked' : ""),
                                            )
                                        ) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="uk-width-1-10 uk-margin-large-bottom">
                            <div class="uk-margin-bottom"><?php echo Yii::t('base', 'Seller type'); ?></div>
                            <ul class="filter-list">
                                <?php
                                $filteredTypes = array();
                                if ($filters->seller_type != '') {
                                    $filteredTypes = explode(',', $filters->seller_type);
                                }
                                foreach (SellerProfile::getConditions() as $id => $cond) : ?>
                                    <li <?php echo((in_array($id, $filteredTypes)) ?
                                        'class="filter-list-active"' : ""); ?>><!--END OPEN TAG li-->

                                        <?php echo CHtml::link(
                                            $cond,
                                            '#',
                                            array(
                                                'data-filter' => 'seller_type',
                                                'data-id' => $id,
                                                'class' => ((in_array($id, $filteredTypes)) ? 'checked' : ""),
                                            )
                                        ) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="uk-grid uk-dropdown-grid">
                        <div class="uk-width-7-10 uk-flex uk-flex-bottom"></div>
                        <div class="uk-width-3-10 uk-flex uk-flex-bottom">
                            <div id="clear_filter"
                                 class="uk-base-link uk-margin-bottom uk-margin-small-right clear_filter">
                                <?php echo strtolower(Yii::t('base', 'Clear all')); ?>
                            </div>
                            <div id="save_filter"
                                 class="uk-base-link uk-margin-bottom uk-margin-small-right save_filter">
                                <?php echo strtolower(Yii::t('base', 'Save current filters')); ?>
                            </div>
                            <div id="apply_filter" class="uk-base-link uk-margin-bottom uk-margin-small-left apply_filter">
                                <?php echo strtolower(Yii::t('base', 'Apply')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <!--END FILTER-->

        <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
            <div class="uk-grid uk-padding-small-screen">
                <?php $this->renderPartial('_products_nav',
                    array(
                        'products' => $products,
                        'pages' => $pages
                    )
                ); ?>
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

            <?php $isNewRow = (($i % 3) == 0 || $i == 0); ?>
            <?php $modalParameters = ""; ?>
            <div <?php echo $isNewRow ?
                // new row
                'class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-3 uk-grid-width-medium-1-3 uk-grid-width-small-1-2">' .
                '<div itemscope itemtype="http://schema.org/Product" class="thumbnail uk-margin-bottom pf">' :
                // new item
                'itemscope itemtype="http://schema.org/Product" class="thumbnail uk-margin-bottom pf">'; ?>
            <?php $url = $this->createAbsoluteUrl(Product::getProductUrl($products[$i]['id'])); ?>
            <a href="<?php
            echo $url; ?>" <?=$modalParameters; ?>
               class="uk-display-block product-url">
                <div class="thumbnail-image" style="text-align:center;">
                    <?php
                        $base     = Yii::app()->request->getBaseUrl(true);
                        if (!empty($products[$i]['image1'])) {
                            $img_url  = $base . ShopConst::IMAGE_MEDIUM_DIR . $products[$i]['image1'];
                            $img_path = Yii::getpathOfAlias('webroot') . ShopConst::IMAGE_MEDIUM_DIR . $products[$i]['image1'];
                        } else {
                            $img_url = $products[$i]['image_url1'];
                        }
                        
                        $no_img   = $base . '/images/prod-no-img.png';
                        
                    ?>
                    <?=CHtml::image(
                        !empty($products[$i]['image1']) ? (file_exists($img_path) ? '' : $no_img) : $img_url,
                        ($products[$i]['title']) ? CHtml::encode($products[$i]['title']) : CHtml::encode(Category::model()->getAliasById($products[$i]['category_id'])),
                        array(
                            'data-plugin'   => 'lazy-load',
                            'data-original' => $img_url,
                            'itemprop' => "image",
                            'style' => 'width: calc(14 * (100% / 18));',
                        )
                    )?>
                </div>
                <div itemprop="name" class="uk-h4 thumbnail-title uk-margin-small-top" style="margin-left: 50px;">
                    <?php echo Brand::getFormatedTitle($products[$i]['brand_name']); ?>
                </div>
            </a>
            <div itemprop="description" class="thumbnail-description uk-margin-top-mini uk-margin-large-left" style="margin-left: 90px !important;">
                <?php echo Product::getFormatedTitle(CHtml::encode($products[$i]['title'])); ?>
            </div>
            <div itemprop="offers" itemscope itemtype="http://schema.org/Offer"  class="thumbnail-details uk-margin-large-left" style="margin-left: 90px !important;">

                <?php
                $old_price = $products[$i]['init_price'];
                $new_price = $products[$i]['price'];
                $equal = $old_price === $new_price;
                ?>
                <?php if($products[$i]['status'] != Product::PRODUCT_STATUS_SOLD) { ?>
                <span itemprop="price" class="<?php echo !$equal ? 'price price-old' : 'price' ?>">
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
                <?php if($products[$i]['external_sale'] == 0): ?>
                <span class="size"><?php echo Yii::t('base', 'size'); ?>: <?php echo $products[$i]['full_size']; ?></span>
                <?php endif; ?>
            </div>

            <?php
            $countInRow++;

            if ($countInRow == 3 || $i == ($count - 1)) {
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
        <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1 uk-push-1-2">
            <div class="uk-grid">
                <?php
                if (!empty($products)) {
                    $this->renderPartial('_products_nav',
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

<script>
    $(document).ready(function() {
        var isMobile;
        try {
            document.createEvent('TouchEvent');
            isMobile = true;
        } catch (e) {
            isMobile = false;
        }
        var isSafari = navigator.userAgent.indexOf('Safari')  != -1 &&
                       navigator.userAgent.indexOf('Chrome')  == -1 &&
                       navigator.userAgent.indexOf('Android') == -1;
        $('img[data-plugin="lazy-load"]')
            .lazyload({
                'threshold' : 200,
                'effect'    : 'fadeIn'
            })
            .on('load', function() {
                $(this)
                    .closest('.thumbnail.pf')
                    .css('visibility', 'visible');
                /**
                 * Корректировка размеров изображения.
                 */
                /*if (typeof alignImageSize != 'undefined') {
                    alignImageSize(this,
                        476,
                        600,
                        globals.imgbc
                    );
                }*/
                /**
                 * Корректировка декстопного Safari.
                 */
                if (isSafari && !isMobile) {
                    $('body').height($('#products').height() + 'px');
                }
            });
    });
</script>

<script>

    function scrollPaneReinitialize() {
        var settings = {autoReinitialise: true};

        var pane = $('.scroll-pane');

        if (typeof pane.jScrollPane != 'undefined') {
            pane.jScrollPane(settings);
        }
    }

    scrollPaneReinitialize();

    $(document).ready(function(){
        $('.product-url').click(function(){
            var link_text = $(this).data('brand-name') + ' ' + $(this).data('category-name');
            var link_url = '/filter/br/'+$(this).data('brand-id')+'/ct/'+$(this).data('category-id');
            $('#filter-text').text(link_text);
            $('a#filter-link').attr('href',link_url);
        });
    });

</script>

