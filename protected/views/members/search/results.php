<div class="uk-container uk-container-center" style="max-width: 95%;">
    <div class="uk-block uk-margin-large-top">
        <div class="uk-container uk-container-center">
            <div class="uk-h1 uk-text-center"><?=Yii::t('base', 'Showing results for') . ' ' . "'$q'" ?></div>
        </div>
    </div>
    <?php $menu = UtilsHelper::getCategoryMenu(); ?>
    <?php $brands = Brand::getBrandsSorted(); ?>
    <div style="display: inline-block; width: 15%;" id="side-menu">
        <ul style="list-style: none; padding-left: 0;">
            <li><span><b>CATEGORIES</b></span></li>
                <?php foreach ($menu as $menu_item): ?>
                    <?php if ($menu_item['id'] != Category::getIdByAlias('featured')): ?>
                        <?php if (count($menu_item['items'])): ?>
                            <li style="text-transform: capitalize; padding-top: 5px;">
                                <a href='#'><span><?= $menu_item['name'] ?></span></a>
                                <ul style="list-style: none; padding-left: 20px;" class="non-enbl-sb-open">
                                    <?php foreach ($menu_item['items'] as $child): ?>
                                        <li style="padding-top: 5px;">
                                            <a href='<?= $child['url'] ?>'><span><?= $child['name'] ?></span></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li style="text-transform: capitalize; padding-top: 5px;">
                                <a href='<?= $menu_item['url'] ?>'><span><?= $menu_item['name'] ?></span></a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </li>
            <li style="padding-top: 20px;"><span><b>DESIGNERS</b></span>
                <ul style="list-style: none; padding-left: 0;" class="design">
                    <?php foreach ($brands as $brand): ?>
                        <li style="padding-top: 5px;">
                            <a href="/designers/<?= $brand->url ?>"><span><?= $brand->name ?></span></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
        </ul>
    </div>
    <div class="block-category" style="display: inline-block; vertical-align: top; width: 80%; float: right;">
        <?php if ($count): ?>
            <?php $i = 0; ?>
            <?php $countInRow = 0 ?>
            <?php foreach ($products as $k => $product) : ?>
                <?php foreach ($product as $rec): ?>
                    <?php $isNewRow = (($i % 3) == 0 || $i == 0); ?>
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
                        $countInRow ++;

                    if ($countInRow == 3 || $i == ($count - 1)) {
                        echo '</div></div>';
                        $countInRow = 0;
                    } else {
                        echo '</div>';
                    } ?>
                    <?php $i ++ ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
            <div id="more-results-cnt">
            </div>
            <?php if ($products_cnt > ($limit + $offset)): ?>
                <div class="show-more-results-btn-cnt">
                    <input type="button" id="show-more-results-btn" data-query="<?= $q ?>" data-limit="<?= $limit ?>" data-offset="<?= $offset + $limit ?>" onclick="showMoreResults(this)" value="<?= Yii::t('base', 'Show more results') ?>" class="uk-button uk-button-small" style="line-height: 26px; min-height: 26px;">
                    <div id="loading_results" class="loading_results" style="display: none;">
                        <img src="/images/ajax.gif">
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
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
    
    function showMoreResults(obj)
    {
        $('#show-more-results-btn').hide();
        $('#loading_results').show();
        $.ajax({
            type: 'POST',
            data: {limit: $(obj).attr('data-limit'), offset: $(obj).attr('data-offset'), query: $(obj).attr('data-query')},
            url: globals.url + '/search/more-results',
            success: function (data) {
                var response = JSON.parse(data);
                $("#more-results-cnt").append(response.html);
                $("#show-more-results-btn").attr("data-limit", response.limit);
                $("#show-more-results-btn").attr("data-offset", parseInt(response.offset) + parseInt(response.limit));
                
                if (parseInt(response.products_cnt) > (parseInt(response.limit) + parseInt(response.offset))) {
                    $('#show-more-results-btn').show();
                }
                $('#loading_results').hide();
                
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
            }
        });
    }
</script>

