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
        <!--BLOCK WITH PHOTO-->
        <div class="uk-container uk-container-center uk-padding-top-large">
            <!--BLOCK WITH PHOTO-->
            <?php if(!empty($menuImages)): ?>
                <?php if($menuImages->block_type == MainMenuImages::NO_IMAGES): ?>
                    <div class="uk-grid uk-grid-collapse" style="min-height: 500px;">
                        <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                            <div class="uk-padding-top-xxlarge">
                                <div class="image-wrapper" style="visibility: hidden;">
                                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/uikit/images/content/main-2.jpg" alt="image">
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1 uk-hidden-large uk-hidden-medium">
                            <div class="image-wrapper" style="visibility: hidden;">
                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/uikit/images/content/main-1.jpg" alt="image">
                            </div>
                        </div>
                    </div>
                <?php elseif($menuImages->block_type == MainMenuImages::TWO_IMAGES): ?>
                    <div class="uk-grid two-images-grid uk-grid-collapse">
                        <div class="uk-width-1-1 left-image uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                            <div class="uk-padding-top-xxlarge">
                                <div class="image-wrapper">
                                    <?php $url1 = ($menuImages->url1 != NULL) ? $menuImages->url1 : '#'; ?>
                                    <a href="<?=$url1?>">
                                        <img class="left-wrapper" src="<?php echo Yii::app()->request->baseUrl;?>/images/upload/blocks/<?=$menuImages->image1?>" alt="image">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1">
                            <div class="image-wrapper">
                                <?php $url2 = ($menuImages->url2 != NULL) ? $menuImages->url2 : '#'; ?>
                                <a href="<?=$url2?>">
                                    <img class="right-image" src="<?php echo Yii::app()->request->baseUrl;?>/images/upload/blocks/<?=$menuImages->image2?>" alt="image">
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="uk-grid uk-grid-collapse">
                        <div class="uk-width-1-1 uk-width-large-1-1 uk-width-medium-1-1 uk-width-small-1-1">
                            <div class="uk-padding-top-xxlarge">
                                <div class="image-wrapper">
                                    <?php $url = ($menuImages->url1 != NULL) ? $menuImages->url1 : '#'; ?>
                                    <a href="<?=$url?>">
                                        <img src="<?php echo Yii::app()->request->baseUrl;?>/images/upload/blocks/medium/<?=$menuImages->image1?>" alt="image">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <!--END BLOCK WITH PHOTO-->
        <!--BLOCK WITH THUMB-LINK-->
        <?php $class = ($menuImages->block_type != MainMenuImages::NO_IMAGES) ? 'uk-padding-top-xxxlarge' : 'uk-padding-top-large'; ?>
        <div class="<?=$class?>">
            <div class="uk-grid">
                <div class="uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-1 uk-push-1-2">
                    <div class="uk-grid">
                        <div class="uk-width-3-4 uk-push-1-4">
                            <a href="<?=$blocks[1]->url?>" class="uk-text-light">
                                <?php echo Yii::t('base', 'about us'); ?>
                            </a>
                        </div>
                    </div>
                    <div class="uk-text-content uk-margin-top"><?=$blocks[1]->homepageBlockContents[0]->content?></div>
                    <div class="uk-grid">
                        <div class="uk-width-3-4 uk-push-1-4">
                            <a href="<?=$blocks[1]->url?>" class="uk-base-link uk-text-light uk-margin-top">
                                <?php echo Yii::t('base', 'read more'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-3 uk-grid-width-medium-1-3 uk-grid-width-small-1-1">
                <div class="thumbnail uk-margin-top-remove">
                    <div class="thumbnail-link-wrapper uk-text-right uk-margin-bottom">
                        <a href="<?=$blocks[0]->url?>" class="thumbnail-link"><?=$blocks[0]->homepageBlockContents[0]->title?> <i class="uk-icon-angle-right"></i> </a>
                    </div>
                    <a href="<?=$blocks[0]->url?>" class="uk-display-block">
                        <div class="thumbnail-image">
                            <img src="<?php echo ImageHelper::get($blocks[0]->image, $mediumPath, $bigPath); ?>" alt="image" />
                        </div>
                        <div class="uk-h4 thumbnail-title uk-margin-top">
                            <?=$blocks[0]->homepageBlockContents[0]->content?>
                        </div>
                    </a>
                    <div class="uk-grid uk-grid-width-1-2 uk-margin-large-top">
                        <div class="thumbnail">
                            <a href="<?=$blocks[2]->url?>" class="uk-display-block">
                                <div class="thumbnail-image">
                                    <img src="<?php echo ImageHelper::get($blocks[2]->image, $thumbnailPath, $bigPath); ?>" alt="image" />
                                </div>
                                <div class="uk-h4 thumbnail-title uk-margin-top">
                                    <?=$blocks[2]->homepageBlockContents[0]->content?>
                                </div>
                            </a>
                        </div>
                        <div class="thumbnail">
                            <a href="<?=$blocks[3]->url?>" class="uk-display-block">
                                <div class="thumbnail-image">
                                    <img src="<?php echo ImageHelper::get($blocks[3]->image, $thumbnailPath, $bigPath); ?>" alt="image" />
                                </div>
                                <div class="uk-h4 thumbnail-title uk-margin-top">
                                    <?=$blocks[3]->homepageBlockContents[0]->content?>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="thumbnail uk-padding-top-homepage-large">
                    <div class="thumbnail-link-wrapper uk-text-right uk-margin-bottom">
                        <a href="<?=$blocks[4]->url?>" class="thumbnail-link"><?=$blocks[4]->homepageBlockContents[0]->title?> <i class="uk-icon-angle-right"></i> </a>
                    </div>
                    <a href="<?=$blocks[4]->url?>" class="uk-display-block">
                        <div class="thumbnail-image">
                            <img src="<?php echo ImageHelper::get($blocks[4]->image, $mediumPath, $bigPath); ?>" alt="image" />
                        </div>
                        <div class="uk-h4 thumbnail-title uk-margin-top">
                            <?=$blocks[4]->homepageBlockContents[0]->content?>
                        </div>
                    </a>
                    <div class="uk-grid uk-grid-width-1-2 uk-margin-large-top">
                        <div class="thumbnail">
                            <a href="<?=$blocks[5]->url?>" class="uk-display-block">
                                <div class="thumbnail-image">
                                    <img src="<?php echo ImageHelper::get($blocks[5]->image, $thumbnailPath, $bigPath); ?>" alt="image" />
                                </div>
                                <div class="uk-h4 thumbnail-title uk-margin-top">
                                    <?=$blocks[5]->homepageBlockContents[0]->content?>
                                </div>
                            </a>
                        </div>
                        <div class="thumbnail">
                            <a href="<?=$blocks[6]->url?>" class="uk-display-block">
                                <div class="thumbnail-image">
                                    <img src="<?php echo ImageHelper::get($blocks[6]->image, $thumbnailPath, $bigPath); ?>" alt="image" />
                                </div>
                                <div class="uk-h4 thumbnail-title uk-margin-top">
                                    <?=$blocks[6]->homepageBlockContents[0]->content?>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="thumbnail uk-padding-top-homepage-medium">
                    <div class="thumbnail-link-wrapper uk-text-right uk-margin-bottom">
                        <a href="<?=$blocks[7]->url?>" class="thumbnail-link"><?=$blocks[7]->homepageBlockContents[0]->title?> <i class="uk-icon-angle-right"></i> </a>
                    </div>
                    <a href="<?=$blocks[7]->url?>" class="uk-display-block">
                        <div class="thumbnail-image">
                            <img src="<?php echo ImageHelper::get($blocks[7]->image, $mediumPath, $bigPath); ?>" alt="image" />
                        </div>
                        <div class="uk-h4 thumbnail-title uk-margin-top">
                            <?=$blocks[7]->homepageBlockContents[0]->content?>
                        </div>
                    </a>
                    <div class="uk-grid uk-grid-width-1-2 uk-margin-large-top">
                        <div class="thumbnail">
                            <a href="<?=$blocks[8]->url?>" class="uk-display-block">
                                <div class="thumbnail-image">
                                    <img src="<?php echo ImageHelper::get($blocks[8]->image, $thumbnailPath, $bigPath); ?>" alt="image" />
                                </div>
                                <div class="uk-h4 thumbnail-title uk-margin-top">
                                    <?=$blocks[8]->homepageBlockContents[0]->content?>
                                </div>
                            </a>
                        </div>
                        <div class="thumbnail">
                            <a href="<?=$blocks[9]->url?>" class="uk-display-block">
                                <div class="thumbnail-image">
                                    <img src="<?php echo ImageHelper::get($blocks[9]->image, $thumbnailPath, $bigPath); ?>" alt="image" />
                                </div>
                                <div class="uk-h4 thumbnail-title uk-margin-top">
                                    <?=$blocks[9]->homepageBlockContents[0]->content?>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-block uk-block-large">
                <!--THUMBNAIL KIDS SHOP-->
                <div class="uk-grid uk-flex uk-flex-space-around">
                    <div class="uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-1 uk-padding-top-xxlarge">
                        <div class="uk-grid">
                            <div class="uk-width-3-4 uk-push-1-4">
                                <a href="<?=$blocks[10]->url?>" class="uk-text-light"><?=$blocks[10]->homepageBlockContents[0]->title?></a>
                            </div>
                        </div>
                        <div class="uk-text-content uk-margin-top"><?=$blocks[10]->homepageBlockContents[0]->content?></div>
                        <div class="uk-grid">
                            <div class="uk-width-3-4 uk-push-1-4">
                                <!-- a href="<?=$blocks[10]->url?>" class="uk-base-link uk-text-light uk-margin-top uk-margin-bottom">
                                    <?php echo Yii::t('base', 'read more'); ?>
                                </a -->
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-1">
                        <div class="thumbnail">
                            <div class="thumbnail-link-wrapper uk-text-right uk-margin-bottom">
                                <a href="<?=$blocks[11]->url?>" class="thumbnail-link"><?=$blocks[11]->homepageBlockContents[0]->title?> <i class="uk-icon-angle-right"></i> </a>
                            </div>
                            <a href="<?=$blocks[11]->url?>" class="uk-display-block">
                                <div class="thumbnail-image">
                                    <img src="<?php echo ImageHelper::get($blocks[11]->image, $mediumPath, $bigPath); ?>" alt="image" />
                                </div>
                                <div class="uk-h4 thumbnail-title uk-margin-top">
                                    <?=$blocks[11]->homepageBlockContents[0]->content?>
                                </div>
                            </a>
                            <div class="uk-grid uk-grid-width-1-2 uk-margin-large-top">
                                <div class="thumbnail">
                                    <a href="<?=$blocks[13]->url?>" class="uk-display-block">
                                        <div class="thumbnail-image">
                                            <img src="<?php echo ImageHelper::get($blocks[13]->image, $thumbnailPath, $bigPath); ?>" alt="image" />
                                        </div>
                                        <div class="uk-h4 thumbnail-title uk-margin-top">
                                            <?=$blocks[13]->homepageBlockContents[0]->content?>
                                        </div>
                                    </a>
                                </div>
                                <div class="thumbnail">
                                    <a href="<?=$blocks[14]->url?>" class="uk-display-block">
                                        <div class="thumbnail-image">
                                            <img src="<?php echo ImageHelper::get($blocks[14]->image, $thumbnailPath, $bigPath); ?>" alt="image" />
                                        </div>
                                        <div class="uk-h4 thumbnail-title uk-margin-top">
                                            <?=$blocks[14]->homepageBlockContents[0]->content?>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--END THUMBNAIL KIDS SHOP-->
                <!--THUMBNAIL BLOG-->
                <div class="uk-grid">
                    <div class="uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-1">
                        <div class="thumbnail uk-margin-top-remove blog-block">
                            <div class="thumbnail-link-wrapper uk-text-right uk-margin-bottom">
                                <a href="<?=$blocks[12]->url?>" target="_blank" class="thumbnail-link"><?=$blocks[12]->homepageBlockContents[0]->title?> <i class="uk-icon-angle-right"></i> </a>
                            </div>
                            <a href="<?=$blocks[12]->url?>" target="_blank" class="uk-display-block">
                                <div class="thumbnail-image">
                                    <img src="<?php echo ImageHelper::get($blocks[12]->image, $mediumPath, $bigPath); ?>" alt="image" />
                                </div>
                            </a>
                            <div class="uk-grid uk-grid-width-1-2 uk-push-1-2">
                                <div class="uk-h3 thumbnail-title uk-margin-top">
                                    <?=$blocks[12]->homepageBlockContents[0]->content?>
                                </div>
                                <!-- a href="<?=$blocks[12]->url?>" target="_blank" class="uk-base-link uk-text-light uk-margin-top uk-margin-large-left">
                                    <?php echo Yii::t('base', 'read more'); ?>
                                </a -->
                            </div>
                        </div>
                    </div>
                </div>
                <!--END THUMBNAIL BLOG-->
            </div>
        </div>
        <!--END BLOCK WITH THUMB-LINK-->
        <!--INSTA BLOCK PHOTO-->
        <div class="uk-block uk-block-large uk-padding-top-remove">
            <?php if(isset($blocks[16])): ?>
            <div class="uk-grid">
                <div class="uk-width-1-1 uk-width-large-1-6 uk-width-medium-1-6 uk-width-small-1-3 uk-push-1-2">
                    <a href="<?=$blocks[16]->url?>" class="uk-display-block">
                        <div class="insta-image-wrapper">
                            <img src="<?php echo ImageHelper::get($blocks[16]->image, $thumbnailPath, $bigPath); ?>" alt="instagram" />
                        </div>
                    </a>
                </div>
            </div>
            <?php endif; ?>
            <?php if(isset($blocks[17])): ?>
            <div class="uk-grid">
                <div class="uk-width-1-1 uk-width-large-1-6 uk-width-medium-1-6 uk-width-small-1-3 uk-push-1-6">
                    <div class="uk-text-center uk-margin-top-xlarge"><a href="<?=$blocks[16]->url?>" target="_blank" class="uk-text-light uk-base-link uk-margin-bottom"><?=Yii::t('base', 'instagram')?></a></div>
                    <div class="uk-margin-large-top"><a href="<?=$blocks[17]->url?>" target="_blank" class="uk-text-light uk-base-link uk-margin-bottom"><?=Yii::t('base', 'follow us')?></a></div>
                </div>
                <div class="uk-width-1-1 uk-width-large-1-3 uk-width-medium-1-3 uk-width-small-1-3 uk-push-1-6">
                    <a href="<?=$blocks[17]->url?>" target="_blank" class="uk-display-block">
                        <div class="insta-image-wrapper uk-margin-bottom">
                            <img src="<?php echo ImageHelper::get($blocks[17]->image, $mediumPath, $bigPath); ?>" alt="instagram" />
                        </div>
                    </a>
                </div>
                <div class="uk-width-1-1 uk-width-large-1-6 uk-width-medium-1-6 uk-width-small-1-6 uk-push-1-6">
                    <a href="<?=$blocks[18]->url?>" target="_blank" class="uk-display-block">
                        <div class="insta-image-wrapper uk-margin-top-remove uk-margin-bottom">
                            <img src="<?php echo ImageHelper::get($blocks[18]->image, $thumbnailPath, $bigPath); ?>" alt="instagram" />
                        </div>
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <!--END INSTA BLOCK PHOTO-->
    </div>
    <!--END MAIN BLOCK-->
