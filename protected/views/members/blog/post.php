<?php $encodedPostTitle = CHtml::encode($post->title)?>
<?php $encodedShortDescription = CHtml::encode($post->short_description)?>

<div class="uk-block uk-margin-top">
    <div class="uk-container uk-container-center uk-text-center">
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
            <div class="post-text uk-grid">
                <!--Текст поста-->
                <div class="uk-width-small-1-1 uk-width-medium-6-10 uk-push-2-10 post_description uk-text-left">
                    <?php $this->beginWidget('CHtmlPurifier')?>
                    <?=$post->content?>
                    <?php $this->endWidget()?>
                    <!--Тэги-->
                    <?php
                        $tags = $post->getNormalizedTags(true);
                        if (!empty($tags)):
                    ?>
                        <div class="post_tags">
                            <i class="uk-icon-tag"></i>
                            <?php
                                array_walk($tags, function(&$item, $key) {
                                    $item = '<span>' .
                                        CHtml::link(CHtml::encode($item), $this->createUrl('members/blog/tag', array('id' => $key))) .
                                        '</span>';
                                });
                                echo implode(', ', $tags);
                            ?>
                        </div>
                    <?php
                        endif;
                    ?>
                </div>
                <div class="uk-width-2-10 uk-push-2-10 uk-hidden-small">
                    <ul class="blog-all-cats">
                        <li><?=Yii::t('base', 'Categories')?></li>
                        <?php foreach (BlogCategory::getAllCategories() as $id => $category): ?>
                            <li><?=CHtml::link(
                                    CHtml::encode($category),
                                    $this->createUrl('members/blog/category', array('id' => $id)))?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="post-socials uk-grid">
                <div class="uk-width-small-1-1 uk-width-medium-6-10 uk-push-2-10">
                    <hr/>
                    <a name="comments_block"></a>
                    <div class="uk-text-left">
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
                    <hr/>
                    <?php if ($post->allow_add_comments || count($comments) > 0): ?>
                    <div class="uk-grid">
                        <div class="uk-width-1-2 uk-text-left">
                            <div class="uk-flex uk-flex-space-between">
                                <span><b><?=Yii::t('base', 'comments')?></b></span>
                            </div>
                        </div>
                        <div class="uk-width-1-2 uk-text-right">
                            <a id="add-new-comment" class="uk-link" href="#">
                                <?=Yii::t('base', 'add a new comment')?> >
                            </a>
                        </div>
                    </div>
                    <hr/>
                    <div class="uk-grid">
                        <div class="uk-width-1-1">
                            <div class="comments-wrapper">
                                <div>
                                    <div id="comments">
                                        <?php $this->renderPartial('_comments', array(
                                            'comments' => $comments,
                                            'pages'    => $pages
                                        ))?>
                                    </div>
                                </div>
                                <?php if ($post->allow_add_comments): ?>
                                    <?php
                                        $class = "";
                                        if (Yii::app()->member->isGuest) {
                                            $class = "class='hidden_form'";
                                        }
                                     ?>
                                    <form <?= $class ?> action="#" id="comments-form">
                                        <div class="uk-form-row">
                                            <textarea id="comment" name="comment" class="comment-textarea"
                                                      onfocus="this.select()"></textarea>
                                        </div>
                                        <div class="uk-form-row uk-text-right">
                                            <button id="submit-new-comment" type="button" class="uk-button"><?=Yii::t('base', 'submit')?></button>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function scrollToBottom() {
        $("html, body").animate({ scrollTop: $(document).height() }, 1000);
    }

    function reloadThenScrollToBottom() {
        if(window.location.hash) {
            window.location.hash = "#add_comment_form_anchor";
        } else {
            window.location.href += "#add_comment_form_anchor";
        }
        window.location.reload();
    }

    function submitCommentForm(withoutRedirect) {
        var withoutRedirect = withoutRedirect || 0;
        var comment = $('#comment').val();
        if (!withoutRedirect) {
            reloadThenScrollToBottom();
        }
        if (!comment.length) {
            return false;
        }
        var url = globals.url + '/members/blog/newComment';
        var data = {'id': <?=$post->id?>, 'comment': comment};
        $.post(url, data, function (response) {
            var response = JSON.parse(response);
            if (response.result == 'ok') {
                $('#comments').html(response.html);
                $('#comment').val('');
                $('#no_comments').remove();
            }
        });
    }
    jQuery(document).ready(function($) {
        if (window.location.hash == '#add_comment_form_anchor') {
            scrollToBottom();
            $('#comment').focus();
        }
        $(document).on('click', '#add-new-comment', function(event) {
            event.preventDefault();
            <?php if (!Yii::app()->member->isGuest): ?>
               scrollToBottom();
               $('#comment').focus();
            <?php else: ?>
                var href = $('#login_sell');
                if (href.length > 0) {
                    var url = '<?= Yii:: app()->createUrl("/members/auth/login", array("withoutRedirect" => "check_if_user_is_guest", "commentsForm" => "1")) ?>';
                    var wrapper = $('#login_content');

                    $.ajax({
                        'url': url,
                        success: function (data) {
                            if (data == '0') {
                                reloadThenScrollToBottom();
                            } else {
                                $(wrapper).html(data);
                            }
                        }
                    });
                }
            <?php endif; ?>
        });

        $('#comments').on('click', 'ul li a', function(event) {
            event.preventDefault();
            var comments_block = $('#comments');
            comments_block.css('opacity', '0.5');
            $.ajax({
                type: "GET",
                url: $(this).attr('href'),
                data: {comments_only: 1},
                success:function(data){
                   comments_block.html(data);
                   comments_block.css('opacity', '1');
                }
            });
        });

        /**
         * Добавление нового комментария.
         */
        $('#submit-new-comment').on('click', function () {
            submitCommentForm(1);
        });

        /**
         * Инициализация слайдера внутри поста.
         */
        var sliders;
        var classes = [
            '.slider',
            '.slide-list',
            '.slide-wrap',
            '.slide-item',
            '.slide-img',
            '.slide-title',
            '.prev-slide',
            '.next-slide'
        ];
        if ((sliders = $('.slider')).length) {
            $('<link/>')
                .prop({
                    'rel'  : 'stylesheet',
                    'href' : '<?=Yii::app()->request->baseUrl?>/css/blog.slider.css'
                })
                .appendTo('head');
            $('<script/>')
                .prop({
                    'src' : '<?=Yii::app()->request->baseUrl?>/js/blog.slider.js'
                })
                .appendTo('head');
            sliders
                .each(function() {
                    $(this)
                        .find('*')
                        .not(classes.join(','))
                        .remove();
                    var sliderImages = $(this).find('.slide-img');
                    var sliderTitles = $(this).find('.slide-title');
                    var sliderInnerHtml = '';
                    for (var i = 0; i < sliderImages.length; i++) {
                        var imgSrc = $(sliderImages[i]).attr('src');
                        var imgTitle = '';
                        if (i < sliderTitles.length) {
                            imgTitle = $(sliderTitles[i]).html();
                        }
                        sliderInnerHtml += '<div class="slide-item">' +
                            '<img src="' + imgSrc + '" class="slide-img" alt="slide image" />'   +
                            '<span class="slide-title">' + imgTitle + '</span>'    +
                            '</div>';
                    }
                    $(this).find('.slide-wrap').html(sliderInnerHtml);
                    BlogSlider.init();
                })
                .contents()
                .filter(function() {
                    return this.nodeType == 3;
                })
                .remove();
        }

        /**
         * Фикс для изображений поста.
         */
        $('.post-item p').each(function() {
            var imgs;
            if ((imgs = $(this).find('img')).length) {
                if (imgs.length > 1) {
                    $(this).css({
                        'position' : 'relative',
                        'left'     : -$(this).offset().left + 'px',
                        'width'    : $(window).width()      + 'px',
                        'padding' : '0 20px'
                    });
                }
                $(this).css('text-align', 'center');
            }
        });
        if ($(window).width() < 780) {
            $('.slide-item img').wrap('<span style="display:inline-block;width: ' + (($(window).width() + 30) + 'px') + ';text-align:center;"></span>');
            $('.slide-title').css('margin-left', '15%');
            $('.slide-item img').css({
                'width'  : '80%'
            });
            $('.slide-item img').css('height', 'auto');
        }
    });
</script>