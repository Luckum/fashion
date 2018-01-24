<?php if (isset($comment->product)): ?>
    <div class="comments-wrapper uk-margin-large-left <?php if ($comment['read'] !== '1') echo 'unread_comment'?>">
        <!--PRODUCT INFO-->
        <article class="uk-comment uk-margin-bottom">
            <header class="uk-comment-header comment-header">
                <div class="uk-flex uk-flex-bottom">
                    <div class="uk-margin-small-left">
                        <?php if ($comment['read'] !== '1'): ?>
                            <i class="icon-unread"></i>
                        <?php else: ?>
                            <i class="uk-icon-eye"></i>
                        <?php endif; ?>
                    </div>
                    <ul class="uk-comment-meta uk-subnav uk-subnav-line uk-margin-left-mini">
                        <li><?php echo date("d.m.Y | g:i a", strtotime($comment->added_date)); ?></li>
                    </ul>
                </div>
            </header>
            <div class="uk-comment-body">
                <div
                    class="uk-margin-small-bottom"><?php echo Yii::t('base', 'Comment posted on'); ?>
                    :
                </div>
                <div class="uk-flex">
                    <div class="uk-margin-small-right uk-width-1-4">
                    <?php
                        $encodedProductTitle = Product::getFormatedTitle(CHtml::encode($comment->product->title));
                        $encodedBrandTitle = Brand::getFormatedTitle(CHtml::encode($comment->product->brand->name));
                        $productUrl = $this->createAbsoluteUrl(Product::getProductUrl($comment->product->id, $comment->product));
                        $brandUrl = Brand::getBrandLink($comment->product->brand->name);
                    ?>
                        <a href="<?php echo $productUrl; ?>" title="Product image - <?php echo $encodedProductTitle; ?>">
                            <?php echo CHtml::image(
                                Yii::app()->request->getBaseUrl(true) . ShopConst::IMAGE_THUMBNAIL_DIR . $comment->product->image1,
                                $encodedProductTitle); ?>
                        </a>
                    </div>
                    <div class="uk-width-3-4">
                        <b>
                            <a href="<?php echo $brandUrl; ?>" title="<?php echo $encodedBrandTitle; ?>">
                                <?php echo $encodedBrandTitle; ?>
                            </a>
                        </b>
                        <div
                            class="uk-margin-bottom">
                            <a href="<?php echo $productUrl; ?>" title="<?php echo $encodedProductTitle; ?>">
                                <?php echo $encodedProductTitle; ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <!--END PRODUCT INFO-->
        <!--PRODUCT COMMENTS-->
        <div id="comments_<?php echo $comment->id ?>">
            <?php
            $this->renderPartial('_comments', array(
                'comment' => $comment,
                'user' => $user
            ));
            ?>
        </div>
        <!--END PRODUCT COMMENTS-->
    </div>
    <hr />
<?php endif; ?>