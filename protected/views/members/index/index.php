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
        <div class="uk-padding-top-xxlarge uk-grid margin-top-30-m">
            <?php foreach ($blocks as $k => $block): ?>
                <div class="uk-width-large-1-2 <?= $k == 0 ? 'padding-right-20' : 'padding-left-40' ?>">
                    <a href="<?=$block->url?>" class="uk-display-block">
                        <div class="thumbnail-image">
                            <img class="main-block-img" src="<?php echo ImageHelper::get($block->image, $mediumPath, $bigPath); ?>" alt="" style="height: 550px;" />
                        </div>
                        <div class="uk-h4 thumbnail-title uk-margin-top">
                            <?=$block->homepageBlockContents[0]->content?>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!--END MAIN BLOCK-->
