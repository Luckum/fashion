<div class="uk-block uk-margin-large-top">
    <div class="uk-container uk-container-center">
        <div class="uk-h1 uk-text-center"><?=Yii::t('base', 'Search results for') . ' ' . "'$q'" ?></div>
    </div>
</div>
<hr style="border-top: 2px solid #000;">
<div class="uk-block uk-text-line-height">
    <!--<div class="uk-grid uk-grid-width-large-1-3">
        <div>
            <ul style="list-style: none; font-size: 16px;">
                <li style="text-transform: uppercase; margin-bottom: 15px;">Products</li>
                <?php foreach ($products as $product): ?>
                    <?php
                        $parent = Category::model()->findByPk($product->category->parent_id);
                        $cat_name = $parent ? $parent->alias . '/' . $product->category->alias : $product->category->alias;
                    ?>
                    <li><a href="<?= strtolower(str_replace(' ', '-', '/' . $cat_name . '/' . trim($product->title) . '-' . $product->id)) ?>"><?= $product->title ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div>
            <ul style="list-style: none; font-size: 16px;">
                <li style="text-transform: uppercase; margin-bottom: 15px;">Designers</li>
                <?php foreach ($brands as $brand): ?>
                    <li><a href="<?= '/designers/' . $brand->url ?>"><?= $brand->name ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div>
            <ul style="list-style: none; font-size: 16px;">
                <li style="text-transform: uppercase; margin-bottom: 15px;">Categories</li>
                <?php foreach ($categories as $category): ?>
                    <?php $parent = Category::model()->findByPk($category->parent_id); ?>
                    <li><a href="<?= $parent ? strtolower(str_replace(' ', '-', '/' . $parent->alias . '/' . $category->alias)) : strtolower(str_replace(' ', '-', '/' . $category->alias)) ?>"><?= $category->alias . ($parent ? ' (' . $parent->alias . ')' : '') ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>-->
    
    <?php if (count($brands)): ?>
        <ul style="list-style: none; font-size: 16px;">
            <li style="text-transform: uppercase; margin-bottom: 15px;">Designers</li>
            <?php foreach ($brands as $rec): ?>
                <?php if (is_array($rec) && count($rec)): ?>
                    <?php foreach ($rec as $brand): ?>
                        <li><a href="<?= '/designers/' . $brand->url ?>"><?= $brand->name ?></a></li>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    
    <?php if (count($categories)): ?>
        <ul style="list-style: none; font-size: 16px;">
            <li style="text-transform: uppercase; margin-bottom: 15px;">Categories</li>
            <?php foreach ($categories as $category): ?>
                <?php if (isset($category['title'])): ?>
                    <li><a href="<?= $category['link'] ?>"><?= $category['title'] ?></a></li>
                <?php else: ?>
                    <?php foreach ($category as $rec): ?>
                        <?php $parent = Category::model()->findByPk($rec->parent_id); ?>
                        <li><a href="<?= $parent ? strtolower(str_replace(' ', '-', '/' . $parent->alias . '/' . $rec->alias)) : strtolower(str_replace(' ', '-', '/' . $rec->alias)) ?>"><?= $rec->alias . ($parent ? ' (' . $parent->alias . ')' : '') ?></a></li>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    
    <?php if (count($products)): ?>
        <?php
            $count = count($products);
            $countInRow = 0;
        ?>
    
        <ul style="list-style: none; font-size: 16px;">
            <li style="text-transform: uppercase; margin-bottom: 15px;">Products</li>
        </ul>
        
        <?php foreach ($products as $k => $product) : ?>
            <?php if (isset($product->title)): ?>
                <?php $isNewRow = (($k % 3) == 0 || $k == 0); ?>
                <div <?php echo $isNewRow ? 'class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-3 uk-grid-width-medium-1-3 uk-grid-width-small-1-2">' .
                    '<div itemscope itemtype="http://schema.org/Product" class="thumbnail uk-margin-bottom pf">'
                    : 'itemscope itemtype="http://schema.org/Product" class="thumbnail uk-margin-bottom pf">'; ?>
                    
                    <?php 
                        $url = $this->createAbsoluteUrl(Product::getProductUrl($product->id));
                        $target = "_self";
                        $partner_site_name = $partner_site_url = '';
                        if ($product->external_sale && !(empty($product->direct_url))) {
                            $url = $product->direct_url;
                            $target = "_blank";
                            if (Category::getParentByCategory($product->category_id) != Category::getIdByAlias('featured')) {
                                $partner = Product::getExternalSiteName($url);
                                $partner_site_name = $partner['name'];
                                $partner_site_url = $partner['url'];
                            }
                        }
                    ?>
                    <a href="<?php echo $url; ?>" class="uk-display-block product-url" target="<?= $target ?>">
                        <div class="thumbnail-image" style="text-align:center;">
                            <?php
                                $base     = Yii::app()->request->getBaseUrl(true);
                                if (!empty($product->image1)) {
                                    $img_url  = $base . ShopConst::IMAGE_MEDIUM_DIR . $product->image1;
                                    $img_path = Yii::getpathOfAlias('webroot') . ShopConst::IMAGE_MEDIUM_DIR . $product->image1;
                                }
                                
                                $no_img   = $base . '/images/prod-no-img.png';
                            ?>
                                
                            <?= CHtml::image(
                                !empty($product->image1) ? (file_exists($img_path) ? '' : $no_img) : $img_url,
                                ($product->title) ? CHtml::encode($product->title) : CHtml::encode(Category::model()->getAliasById($product->category_id)),
                                array(
                                    'data-plugin'   => 'lazy-load',
                                    'data-original' => $img_url,
                                    'itemprop' => "image",
                                    'style' => 'width: calc(16 * (100% / 18));',
                                )
                            )?>
                        </div>
                        <div itemprop="name" class="uk-h4 thumbnail-title uk-margin-small-top" style="margin-left: 5.5556%;">
                            <?php echo Brand::getFormatedTitle($product->brand->name); ?>
                        </div>
                    </a>
                    
                    <div itemprop="description" class="thumbnail-description uk-margin-top-mini uk-margin-large-left" style="margin-left: 90px !important;">
                        <?php echo Product::getFormatedTitle(CHtml::encode($product->title)); ?>
                    </div>
                    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer"  class="thumbnail-details uk-margin-large-left" style="margin-left: 90px !important;">
                        <?php
                            $old_price = $product->init_price;
                            $new_price = $product->price;
                            $equal = $old_price === $new_price;
                        ?>
                        <?php if ($product->status != Product::PRODUCT_STATUS_SOLD) { ?>
                            <span itemprop="price" class="<?php echo !$equal ? 'price price-old' : 'price' ?>">&euro;<?php echo $old_price; ?></span>
                            <?php if (!$equal): ?>
                                <span class="price-new" style="color:red !important;">&euro;<?php echo $new_price; ?></span>
                            <?php endif; ?>
                        <?php } else { ?>
                            <span class="price-new" style="margin-right: 25px;">SOLD</span>
                        <?php } ?>
                        <?php if ($product->external_sale == 0): ?>
                            <span class="size"><?php echo Yii::t('base', 'size'); ?>: <?php echo $product->size_chart->size; ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($partner_site_name)): ?>
                        <div class="partner-name" style="margin-left: 5.5556%;">
                            <div class="partner-lnk">
                                <a href="<?= $url; ?>" class="product-url" target="<?= $target ?>">shop on <span><?= $partner_site_name ?></span></a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php
                    $countInRow++;

                if ($countInRow == 3 || $k == ($count - 1)) {
                    echo '</div></div>';
                    $countInRow = 0;
                } else {
                    echo '</div>';
                } ?>
            <?php else: ?>
                <?php $count += count($product); ?>
                <?php foreach ($product as $i => $rec): ?>
                    <?php $r = $k + $i; ?>
                    <?php $isNewRow = (($r % 3) == 0 || $r == 0); ?>
                    <div <?php echo $isNewRow ? 'class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-3 uk-grid-width-medium-1-3 uk-grid-width-small-1-2">' .
                        '<div itemscope itemtype="http://schema.org/Product" class="thumbnail uk-margin-bottom pf">'
                        : 'itemscope itemtype="http://schema.org/Product" class="thumbnail uk-margin-bottom pf">'; ?>
                        
                        <?php 
                            $url = $this->createAbsoluteUrl(Product::getProductUrl($rec->id));
                            $target = "_self";
                            $partner_site_name = $partner_site_url = '';
                            if ($rec->external_sale && !(empty($rec->direct_url))) {
                                $url = $rec->direct_url;
                                $target = "_blank";
                                if (Category::getParentByCategory($rec->category_id) != Category::getIdByAlias('featured')) {
                                    $partner = Product::getExternalSiteName($url);
                                    $partner_site_name = $partner['name'];
                                    $partner_site_url = $partner['url'];
                                }
                            }
                        ?>
                        <a href="<?php echo $url; ?>" class="uk-display-block product-url" target="<?= $target ?>">
                            <div class="thumbnail-image" style="text-align:center;">
                                <?php
                                    $base     = Yii::app()->request->getBaseUrl(true);
                                    if (!empty($rec->image1)) {
                                        $img_url  = $base . ShopConst::IMAGE_MEDIUM_DIR . $rec->image1;
                                        $img_path = Yii::getpathOfAlias('webroot') . ShopConst::IMAGE_MEDIUM_DIR . $rec->image1;
                                    }
                                    
                                    $no_img   = $base . '/images/prod-no-img.png';
                                ?>
                                    
                                <?= CHtml::image(
                                    !empty($rec->image1) ? (file_exists($img_path) ? '' : $no_img) : $img_url,
                                    ($rec->title) ? CHtml::encode($rec->title) : CHtml::encode(Category::model()->getAliasById($rec->category_id)),
                                    array(
                                        'data-plugin'   => 'lazy-load',
                                        'data-original' => $img_url,
                                        'itemprop' => "image",
                                        'style' => 'width: calc(16 * (100% / 18));',
                                    )
                                )?>
                            </div>
                            <div itemprop="name" class="uk-h4 thumbnail-title uk-margin-small-top" style="margin-left: 5.5556%;">
                                <?php echo Brand::getFormatedTitle($rec->brand->name); ?>
                            </div>
                        </a>
                        
                        <div itemprop="description" class="thumbnail-description uk-margin-top-mini uk-margin-large-left" style="margin-left: 90px !important;">
                            <?php echo Product::getFormatedTitle(CHtml::encode($rec->title)); ?>
                        </div>
                        <div itemprop="offers" itemscope itemtype="http://schema.org/Offer"  class="thumbnail-details uk-margin-large-left" style="margin-left: 90px !important;">
                            <?php
                                $old_price = $rec->init_price;
                                $new_price = $rec->price;
                                $equal = $old_price === $new_price;
                            ?>
                            <?php if ($rec->status != Product::PRODUCT_STATUS_SOLD) { ?>
                                <span itemprop="price" class="<?php echo !$equal ? 'price price-old' : 'price' ?>">&euro;<?php echo $old_price; ?></span>
                                <?php if (!$equal): ?>
                                    <span class="price-new" style="color:red !important;">&euro;<?php echo $new_price; ?></span>
                                <?php endif; ?>
                            <?php } else { ?>
                                <span class="price-new" style="margin-right: 25px;">SOLD</span>
                            <?php } ?>
                            <?php if ($rec->external_sale == 0): ?>
                                <span class="size"><?php echo Yii::t('base', 'size'); ?>: <?php echo $rec->size_chart->size; ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($partner_site_name)): ?>
                            <div class="partner-name" style="margin-left: 5.5556%;">
                                <div class="partner-lnk">
                                    <a href="<?= $url; ?>" class="product-url" target="<?= $target ?>">shop on <span><?= $partner_site_name ?></span></a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php
                        $countInRow++;

                    if ($countInRow == 3 || $r == ($count - 1)) {
                        echo '</div></div>';
                        $countInRow = 0;
                    } else {
                        echo '</div>';
                    } ?>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script src="<?=Yii::app()->request->baseUrl?>/js/jquery/jquery.lazyload.min.js"></script>
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

