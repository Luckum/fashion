<!--PAGINATION AND VIEW-->
<div class="pagination-block">
    <div class="uk-grid uk-margin-large-top">
        <!--FILTER-->
        <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1 uk-margin-bottom">
            
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

<?php if (Category::getParentByCategory($model->id) != Category::getIdByAlias('featured')): ?>
    <?php $menu = UtilsHelper::getCategoryMenu($s_brand); ?>
    <?php $brands = Brand::getBrandsSorted($s_category, $s_subcategory); ?>
    <div style="display: inline-block; width: 15%;" id="side-menu">
        <ul style="list-style: none; padding-left: 0;">
            <li><span><b>CATEGORIES</b></span></li>
            <?php foreach ($menu as $menu_item): ?>
                <?php if ($menu_item['id'] != Category::getIdByAlias('featured')): ?>
                    <?php if (count($menu_item['items'])): ?>
                        <li style="text-transform: capitalize; padding-top: 5px;">
                            <a href='#'><span><?= $menu_item['name'] ?></span></a>
                            <ul style="list-style: none; padding-left: 20px;" <?= empty($s_subcategory) ? 'class="non-enbl-sb-open"' : (strtolower($menu_item['name']) == $s_category ? 'class="enbl-sb-open"' : 'class="non-enbl-sb-open"') ?>>
                                <?php foreach ($menu_item['items'] as $child): ?>
                                    <li style="padding-top: 5px;">
                                        <a href='<?= !empty($s_brand) ? '/designers/' . $s_brand . $child['url'] : $child['url'] ?>' <?= trim($s_subcategory) == str_replace(' ', '-', strtolower($child['name'])) || trim($s_subcategory) == strtolower($child['name']) ? 'style="text-decoration: underline;"' : '' ?>><span><?= $child['name'] ?></span></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li style="text-transform: capitalize; padding-top: 5px;">
                            <a href='<?= $menu_item['url'] ?><?= !empty($s_brand) ? '/' . $s_brand : '' ?>'><span><?= $menu_item['name'] ?></span></a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            <li style="padding-top: 20px;"><span><b>DESIGNERS</b></span>
                <ul style="list-style: none; padding-left: 0;" class="design">
                    <li style="padding-top: 5px;">
                        <a href="#all-brands" id="all-brands-lnk" data-uk-modal><span>View all</span></a>
                    </li>
                    <?php foreach ($brands as $brand): ?>
                        <?php if ($brand->show_in_filter): ?>
                            <li style="padding-top: 5px;">
                                <a href="/<?= !empty($s_subcategory) ? $s_category . '/' . str_replace(' ', '-', trim($s_subcategory)) . '/designers' : 'designers' ?>/<?= $brand->url ?>" <?= $s_brand == $brand->url ? 'style="text-decoration: underline;"' : '' ?>><span><?= $brand->name ?></span></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </li>
        </ul>
    </div>
<?php endif; ?>
<div class="block-category" <?= Category::getParentByCategory($model->id) != Category::getIdByAlias('featured') ? 'style="display: inline-block; vertical-align: top; width: 80%; float: right;"' : '' ?>>
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
            
            <?php 
                $url = $this->createAbsoluteUrl(Product::getProductUrl($products[$i]['id']));
                $target = "_self";
                $partner_site_name = $partner_site_url = '';
                if ($products[$i]['external_sale'] && !(empty($products[$i]['direct_url']))) {
                    $url = $products[$i]['direct_url'];
                    $target = "_blank";
                    //if (Category::getParentByCategory($products[$i]['category_id']) != Category::getIdByAlias('featured')) {
                        $partner = Product::getExternalSiteName($url);
                        $partner_site_name = $partner['name'];
                        $partner_site_url = $partner['url'];
                    //}
                }
            ?>
            <a href="<?php echo $url; ?>" <?=$modalParameters; ?> class="uk-display-block product-url" target="<?= $target ?>">
                <div class="thumbnail-image" style="text-align:center;">
                    <?php
                        $base     = Yii::app()->request->getBaseUrl(true);
                        if (!empty($products[$i]['image1'])) {
                            //$img_url  = $base . ShopConst::IMAGE_MEDIUM_DIR . $products[$i]['image1'];
                            $img_url  = 'https://fra1.digitaloceanspaces.com/n2315/' . $products[$i]['image1'];
                            //$img_path = Yii::getpathOfAlias('webroot') . ShopConst::IMAGE_MEDIUM_DIR . $products[$i]['image1'];
                        } else if (!empty($products[$i]['image2'])) {
                            $img_url  = $base . ShopConst::IMAGE_MEDIUM_DIR . $products[$i]['image2'];
                            $img_path = Yii::getpathOfAlias('webroot') . ShopConst::IMAGE_MEDIUM_DIR . $products[$i]['image2'];
                        } else if (!empty($products[$i]['image3'])) {
                            $img_url  = $base . ShopConst::IMAGE_MEDIUM_DIR . $products[$i]['image3'];
                            $img_path = Yii::getpathOfAlias('webroot') . ShopConst::IMAGE_MEDIUM_DIR . $products[$i]['image3'];
                        }
                        
                        $no_img   = $base . '/images/prod-no-img.png';
                        
                    ?>
                    
                        
                    <?=CHtml::image(
                        //!empty($products[$i]['image1']) ? (file_exists($img_path) ? '' : $no_img) : $img_url,
                        !empty($products[$i]['image1']) ? $img_url : $no_img,
                        ($products[$i]['title']) ? strtolower(Brand::getFormatedTitle($products[$i]['brand_name'])) . ' ' . CHtml::encode($products[$i]['title']) : CHtml::encode(Category::model()->getAliasById($products[$i]['category_id'])),
                        array(
                            'data-plugin'   => 'lazy-load',
                            'data-original' => $img_url,
                            'itemprop' => "image",
                            'title' => "Click to view more detailed imagery on our partner's website",
                            'style' => Category::getParentByCategory($model->id) != Category::getIdByAlias('featured') ? 'width: calc(16 * (100% / 18));' : 'width: calc(14 * (100% / 18));',
                        )
                    )?>
                </div>
                <div itemprop="name" class="uk-h4 thumbnail-title uk-margin-small-top" style="margin-left: <?= Category::getParentByCategory($model->id) != Category::getIdByAlias('featured') ? '5.5556%' : '11.1111%' ?>;">
                    <?php echo Brand::getFormatedTitle($products[$i]['brand_name']); ?>
                </div>
            </a>
            <div itemprop="description" class="thumbnail-description uk-margin-top-mini uk-margin-large-left" style="margin-left: 90px !important;">
                <h2><?php echo Product::getFormatedTitle(CHtml::encode($products[$i]['title'])); ?></h2>
            </div>
            <div itemprop="offers" itemscope itemtype="http://schema.org/Offer"  class="thumbnail-details uk-margin-large-left" style="margin-left: 90px !important;">

                <?php
                $old_price = $products[$i]['init_price'];
                $new_price = $products[$i]['price'];
                $equal = $old_price === $new_price;
                ?>
                <?php if($products[$i]['status'] != Product::PRODUCT_STATUS_SOLD) { ?>
                <span itemprop="price" class="<?php echo !$equal ? 'price price-old' : 'price' ?>">
                    <?= $currency->sign . number_format(sprintf("%01.2f", $old_price * $currency->currencyRate->rate), 2, '.', ''); ?>
                </span>
                <?php if (!$equal): ?>
                    <span class="price-new" style="color:red !important;">
                        <?= $currency->sign . number_format(sprintf("%01.2f", $new_price * $currency->currencyRate->rate), 2, '.', ''); ?>
                    </span>
                <?php endif; ?>
                <?php } else { ?>
                    <span class="price-new" style="margin-right: 25px;">SOLD</span>
                <?php } ?>
                <?php if($products[$i]['external_sale'] == 0): ?>
                    <span class="size"><?php echo Yii::t('base', 'size'); ?>: <?php echo $products[$i]['full_size']; ?></span>
                <?php endif; ?>
            </div>
            <?php if (!empty($partner_site_name)): ?>
                <div class="partner-name" style="margin-left: 5.5556%;">
                    <div class="partner-lnk">
<!--                        <a href="<?= $partner_site_url; ?>" <?= $modalParameters; ?> class="product-url" target="<?= $target ?>">Shop on <?= $partner_site_name ?></a>-->
                            <a href="<?= $url; ?>" <?= $modalParameters; ?> class="product-url" target="<?= $target ?>">shop on <span><?= $partner_site_name ?></span></a>
                    </div>
                </div>
            <?php endif; ?>

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
<div class="pagination-block" style="clear: both; top: 50px;">
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

<div id="all-brands" class="uk-modal all-brands-modal">
     <div class="uk-modal-dialog uk-modal-dialog-large uk-modal-body">
        <a class="uk-modal-close uk-close"></a>
        <div class="uk-block uk-margin-large-top">
            <div class="uk-container uk-container-center">
                <div class="uk-h1 uk-text-center"><?=Yii :: t('base', 'Brands')?></div>
            </div>
        </div>
        <div class="uk-block-border-horizontal">
            <div class="uk-container uk-container-center">
                <div class="uk-text-center">
                    <ul id="brands-alphabet" class="uk-list list-inline">
                        <?php foreach ($alphabet as $item): ?>
                            <li><a href="#<?=$item?>"><?=$item?></a></li>
                        <?php endforeach; ?>
                        <li><a href="#all">(ALL)</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="uk-overflow-container">
            <div class="uk-block uk-text-line-height">
                <div class="uk-container uk-container-center">
                    <div id="brands-list" class="column">
                        <?php foreach ($brands_all as $key => $data): ?>
                            <ul class="uk-list uk-list-brand uk-margin-top-remove uk-margin-large-bottom" data-category="<?=$key?>">
                                <li><div class="uk-h3"><b><?=$key?></b></div></li>
                                <?php foreach ($data as $item): ?>
                                    <?php 
                                        $brandName = Brand::getFormatedTitle(CHtml::encode($item));
                                     ?>
                                    <li><a href="<?php echo Brand::getBrandLink($item); ?>" title="brand '<?= $brandName ?>'"><?= $brandName ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#brands-alphabet a').on('click', function() {
                    var container = $('#brands-list');
                    var brands    = container.find('ul');
                    var href      = $(this).prop('href');
                    var cat       = href.substr(href.indexOf('#') + 1);
                    var e         = $('ul[data-category="' + cat + '"]');

                    if (cat == 'all') {
                        brands.show();
                    } else {
                        brands.hide();
                        if (e.length) {
                            e.show();
                        } else {
                            // There are no brands associated to category "' + (cat.toUpperCase()) + '"'
                        }
                    }
                });
            });
        </script>
    </div>
</div>

<div class="loader"></div>

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
                
                /*var arr = {};
                $(".thumbnail-image").each(function() {
                    arr[$(this).height()] = arr[$(this).height()] + 1 || 1;
                })
                var max = 0;
                var height;
                for (var key in arr) {
                    if (arr[key] > max) {
                        max = arr[key];
                        height = key;
                    }
                }
                $(".thumbnail-image-url").each(function() {
                    $(this).height(height);
                    $(this).css({'overflow': 'hidden'});
                });*/

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
        
        $('#side-menu > ul > li > a').click(function () {
            var checkElement = $(this).next();
            if ((checkElement.is('ul')) && (checkElement.is(':visible'))) {
                checkElement.slideUp('normal');
            }
            if ((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
                $('#side-menu ul ul:visible:not(.design)').slideUp('normal');
                checkElement.slideDown('normal');
            }
            if ($(this).closest('li').find('ul').children().length == 0) {
                return true;
            } else {
                return false;    
            }        
        });
    });

</script>

