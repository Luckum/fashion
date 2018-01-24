<?php if (count($posts)): ?>
    <!--Описание постов блога-->
    <div class="uk-block blog-index uk-margin-top">
        <div class="uk-container uk-container-center uk-text-center">
            <?php $first = true; ?>
            <?php foreach ($posts as $post): ?>
                <?php $encodedPostTitle = CHtml::encode($post->title)?>
                <?php $encodedShortDescription = CHtml::encode($post->short_description)?>
                <div class="post-item">
                    <div class="uk-grid">
                        <div class="uk-width-small-1-1 uk-width-medium-6-10 uk-push-2-10">
                            <!--Заголовок поста-->
                            <h1><?=$encodedPostTitle?></h1>
                            <p class="post-short-desc"><?=$encodedShortDescription?></p>
                            <p class="post_info">
                                <!--Дата создания-->
                                <span><?=date('Y-m-d', strtotime($post->create_time))?></span>
                                <?php
                                    $categories = $post->getNormalizedCategories(true);
                                    if (!empty($categories)):
                                ?>
                                    <span class="info-divider">|</span>
                                    <br class="nl" />
                                    <?php foreach ($categories as $categoryId => $categoryName): ?>
                                        <?= '<span>' .
                                            CHtml::link(CHtml::encode($categoryName), $this->createUrl('members/blog/category', array('id' => $categoryId))) .
                                            '</span>'
                                        ?>
                                    <?php break; endforeach; ?>
                                <?php
                                    endif;
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="post-img uk-grid">
                        <div class="uk-width-small-1-1 uk-width-medium-6-10 uk-push-2-10">
                            <?=CHtml::link(
                                $post->getMediumImageTag(array('class' => 'post_img')),
                                $this->createUrl('/blog/'.strtolower(str_replace(' ', '-', $post->title)))
                            )?>
                        </div>
                        <?php if ($first): ?>
                            <?php $first = !$first; ?>
                            <div class="uk-width-2-10 uk-push-2-10 uk-hidden-small">
                                <ul class="blog-all-cats">
                                    <li><?=Yii::t('base', 'Categories:')?></li>
                                    <?php foreach (BlogCategory::getAllCategories() as $id => $category): ?>
                                        <li><?=CHtml::link(
                                                CHtml::encode($category),
                                                $this->createUrl('members/blog/category', array('id' => $id)))?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="post-socials uk-grid">
                        <div class="uk-width-small-1-1 uk-width-medium-6-10 uk-push-2-10">
                            <hr/>
                            <div class="uk-width-1-2 uk-float-left uk-text-left">
                                <span class="uk-margin-small-right"><?=Yii::t('base', 'share')?>:</span>
                                <ul class="social-list">
                                    <li><a href="#"
                                           onclick="Share.facebook('<?= $post->url ?>', '<?= CHtml::encode($post->seo_title) ?>', '<?= $this->createAbsoluteUrl('/images/blog/' . $post->image) ?>', '<?= $encodedShortDescription ?>', '<?= $encodedPostTitle ?>')"><i
                                                class="uk-icon-facebook"></i></a></li>
                                    <li><a href="#"
                                           onclick="Share.twitter('<?= $post->url ?>', '<?= $encodedPostTitle ?>', '23-15.com blog')"><i
                                                class="uk-icon-twitter"></i></a></li>
                                </ul>
                            </div>
                            <div class="uk-width-1-2 uk-float-right uk-text-right">
                                <span class="post_underline">
                                    <?=CHtml::link(
                                        str_replace(' ', '&nbsp;', $post->commentCntAsText),
                                        $this->createUrl('members/blog/post', array('id' => $post->id, '#' => 'comments_block'))
                                    )?>
                                </span>
                                <span class="post_underline">
                                    <?=CHtml::link(
                                        Yii::t('base', 'read&nbsp;more'),
                                        $this->createUrl('/blog/'.strtolower(str_replace(' ', '-', $post->title)))
                                    )?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="posts_pagination">
                <?php
                $this->widget('LinkPager', array(
                    'pages' => $pages,
                    'maxButtonCount' => 5,
                    'firstPageLabel' => 1,
                    'prevPageLabel' => '<i class="uk-icon-caret-left"></i>',
                    'nextPageLabel' => '<i class="uk-icon-caret-right"></i>',
                    'lastPageLabel' => '<strong>' . $pages->pageCount . '</strong>',
                    'htmlOptions' => array(
                        'class' => 'uk-pagination uk-pagination-center'
                    ),
                    'selectedPageCssClass' => 'selected-page-item-class',
                    'header' => ''
                ));
                ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <!--Нет постов для данной категории-->
    <h1 class="blog-no-posts">
        Sorry, there is no posts here <a href="javascript: history.back();">(go back)</a>
    </h1>
<?php endif; ?>
