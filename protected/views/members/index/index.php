<?php
$blocks = HomepageBlock::getHomePageBlocks();
$menuImages = MainMenuImages::model()->find();
// print_r($menuImages);
// die();
$bigPath = ShopConst::HOME_BLOCK_IMAGE_MAX_DIR;
$mediumPath = ShopConst::HOME_BLOCK_IMAGE_MEDIUM_DIR;
$thumbnailPath = ShopConst::HOME_BLOCK_IMAGE_THUMBNAIL_DIR;
?>

<!--MAIN BLOCK-->
<div class="uk-container uk-container-center uk-padding-top-large">
    <div class="uk-padding-top-xxlarge">
        <div class="main-search-box-cnt">
            <span><?= Yii::t('base', 'Search by designer, category or product') ?>:</span>
            <div id="search-box" class="main-search-box">
                <input autofocus type="text" id="search-text" name="search-text" class="search-input-normal" maxlength="50"/>
            </div>
        </div>
        <div class="uk-grid main-page-blocks">
            <?php foreach ($blocks as $k => $block): ?>
                <div class="uk-width-large-1-2 <?= $k == 0 ? 'padding-right-1 padding-left-0' : 'padding-left-1' ?>">
                    <a href="<?=$block->url?>" class="uk-display-block">
                        <div class="thumbnail-image">
                            <img class="main-block-img" data-plugin="lazy-load" data-original="<?= ImageHelper::get($block->image, $mediumPath, $bigPath); ?>" itemprop="image" src="<?= ImageHelper::get($block->image, $mediumPath, $bigPath); ?>" alt="<?= $k ?>" />
                        </div>
                        <div class="uk-h4 thumbnail-title uk-margin-top">
                            <?=$block->homepageBlockContents[0]->content?>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!--END MAIN BLOCK-->

<script>
    $(document).ready(function() {
        $('#search-text').focus();
    });
</script>