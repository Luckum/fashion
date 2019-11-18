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
                    $directUrl = $rec->direct_url;
                    $url = $this->createAbsoluteUrl('/lead?id=' . $rec->id);
                    $target = "_blank";
                    if (Category::getParentByCategory($rec->category_id) != Category::getIdByAlias('featured')) {
                        $partner = Product::getExternalSiteName($directUrl);
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
                            //$img_url  = $base . ShopConst::IMAGE_MEDIUM_DIR . $rec->image1;
                            $img_url  = 'https://n2315.fra1.cdn.digitaloceanspaces.com/' . $rec->image1;
                            $img_path = Yii::getpathOfAlias('webroot') . ShopConst::IMAGE_MEDIUM_DIR . $rec->image1;
                        }
                        
                        $no_img   = $base . '/images/prod-no-img.png';
                    ?>
                        
                    <?= CHtml::image(
                        //!empty($rec->image1) ? (file_exists($img_path) ? '' : $no_img) : $img_url,
                        !empty($rec->image1) ? $img_url : $no_img,
                        ($rec->title) ? strtolower(Brand::getFormatedTitle($rec->brand->name)) . ' ' . CHtml::encode($rec->title) : CHtml::encode(Category::model()->getAliasById($rec->category_id)),
                        array(
                            'data-plugin'   => 'lazy-load',
                            'data-original' => $img_url,
                            'itemprop' => "image",
                            'title' => "Click to view more detailed imagery on our partner's website",
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