<!--ITEMS-->
<div class="uk-margin-left uk-margin-right">
    <div class="uk-h4 uk-margin-bottom uk-margin-neg-top-small">
        <b><?php echo Yii::t('base', 'items for sale'); ?>:</b>
    </div>

    <?php if ($model) : ?>
        <?php $count = count($model); ?>
        <?php foreach ($model as $key => $product) : ?>
            <?php echo ($key == 0 || $key % 2 == 0) ?
                '<div class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-2 uk-grid-width-medium-1-2 uk-grid-width-small-1-1"><div>' :
                '<div>'; ?>

            <div class="thumbnail-wrapper">
                <div class="thumbnail uk-margin-bottom">
                    <a href="<?php echo $this->createAbsoluteUrl(
                        Product::getProductUrl($product->id)); ?>" class="uk-display-block">
                        <div class="thumbnail-image">
                            <?=CHtml::image(
                                Yii::app()->request->getBaseUrl(true) . ShopConst::IMAGE_MEDIUM_DIR . $product->image1,
                                ($product->title) ? CHtml::encode($product->title) : CHtml::encode(Category::model()->getAliasById($product->category_id)),
                                array('onerror' => '$(this).prop({"class" : "no-image", "src" : "/images/prod-no-img.png"})')
                            )?>
                        </div>
                        <div class="uk-h4 thumbnail-title uk-margin-top">
                            <?php echo Brand::getFormatedTitle(CHtml::encode($product->brand->name)); ?>
                        </div>
                    </a>
                    <div
                        class="thumbnail-description uk-margin-large-left uk-margin-top-mini">
                        <?php echo Product::getFormatedTitle(CHtml::encode($product->title)); ?>
                    </div>
                    <div class="thumbnail-details uk-margin-large-left">

                        <?php
                        $old_price = $product->init_price;
                        $new_price = $product->price;
                        $equal = $old_price === $new_price;
                        ?>

                        <span class="<?php echo !$equal ? 'price price-old' : 'price' ?>">
                                    &euro;<?php echo $old_price;; ?>
                                 </span>
                        <?php if (!$equal): ?>
                            <span class="price-new">
                                        &euro;<?php echo $new_price; ?>
                                    </span>
                        <?php endif; ?>
                        <span class="size"><?php echo Yii::t('base', 'size'); ?>: <?=empty($product -> size_chart) ? Yii :: t('base', 'No size') : $product -> size_chart -> size?></span>
                    </div>
                </div>
            </div>

            <?php echo (($key + 1) % 2 == 0 || $key == ($count - 1)) ? '</div></div>' : '</div>'; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <?php if (!$showProfile): ?>
            <div class="row-fluid">
                <div class='span6 add_item'>
                    <div id="add_item_icon"></div>
                    <div id="add_item_text"><?= Yii::t('base', 'add new item for sale'); ?></div>
                </div>
            </div>
        <?php else: ?>
            <?php echo Yii::t('base', 'No items found'); ?>
        <?php endif; ?>
    <?php endif; ?>

</div>
<!--END ITEMS-->