<?php $this->beginContent('//layouts/site_layout'); ?>

<?php $top_menu = UtilsHelper::getTopMenu(); ?>

<!--NAVBAR-->
<nav class="uk-navbar" id="dropdown-nav" data-uk-sticky>
    <div class="uk-navbar-content uk-navbar-flip">
        <ul class="uk-navbar-nav uk-navbar-nav-light">

            <?php if ($top_menu['login']['visible']) { ?>
                <li class="uk-visible-large">
                    <a class="main_menu_link" id="login_main" href="<?php echo $top_menu['login']['url']; ?>">
                        <i class="icon-ic_account uk-margin-right-mini"></i>
                        <span><?php echo $top_menu['login']['name'] ?></span>
                    </a>
                </li>
            <?php } else { ?>
                <li class="uk-visible-large">
                    <a class="main_menu_link" href="<?php echo $top_menu['account']['url']; ?>">
                        <i class="icon-ic_account uk-margin-right-mini"></i>
                        <span><?php echo $top_menu['account']['name'] ?></span>
                    </a>
                </li>
            <?php } ?>

            <li id="cart" class="dropdown-bag-wrapper uk-visible-large"
                data-uk-dropdown="{mode:'hover', pos:'bottom-right'}">
                <?php $this->renderPartial('application.views.members.shop._cart'); ?>
            </li>

            <li>
                <a class="main_menu_link search-icon" href="#search"><i
                        class="icon-ic_search uk-margin-right-mini"></i>
                    <span class="uk-visible-large">
                        <?php echo Yii::t('base', 'Search'); ?>
                    </span></a>
            </li>
            <?php if ($top_menu['logout']['visible']) : ?>
                <li class="uk-visible-large">
                    <a class="main_menu_link" href="<?php echo $top_menu['logout']['url']; ?>">
                        <i class="uk-icon-power-off uk-margin-right-mini"></i>
                        <span><?php echo $top_menu['logout']['name']; ?></span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="uk-container uk-container-center">
        <a href="#" class="uk-navbar-toggle uk-hidden-large"
           data-uk-toggle="{target:'#navbar-collapse', cls: 'uk-animation-slide-left'}">
        </a>
        <a href="/" class="uk-navbar-brand uk-visible-large">
            <!-- img src="<?php echo Yii::app()->request->baseUrl; ?>/uikit/images/logo-white.svg" alt="23-15" -->
        </a>
        <div class="uk-navbar-content uk-navbar-center show-menu" id="navbar-collapse" style="max-width:70%">
            <ul class="uk-navbar-nav navbar-main">

                <?php
                $menu = UtilsHelper::getCategoryMenu();
                $count = count($menu);

                for ($i = 0; $i < $count; $i++): ?>

                    <!--LARGE AND MEDIUM SCREEN MENU-->
                    <?php if(count($menu[$i]['items']) > 0): ?>
                        <li data-uk-dropdown="{'justify':'#dropdown-nav','mode':'click'}" class="nav-correction uk-hidden-medium uk-hidden-small">
                    <?php else: ?>
                        <li class="nav-correction uk-hidden-medium uk-hidden-small">
                    <?php endif; ?>
                        <a href="<?php echo $menu[$i]['url']; ?>" class="main_menu_link <?php echo $menu[$i]['selected'] ? 'selected_cat' : ''; ?>">
                            <?php echo $menu[$i]['name']; ?>
                        </a>
                        <div class="uk-dropdown dropdown-nav">
                            <ul>
                                <?php foreach ($menu[$i]['items'] as $child) : ?>

                                    <li>
                                        <a href="<?php echo $child['url']; ?>"
                                           style="<?php echo $child['selected'] ? 'text-decoration: underline;' : ''; ?>">
                                            <?php echo $child['name']; ?>
                                        </a>
                                    </li>

                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                    <!--END LARGE AND MEDIUM SCREEN MENU-->
                    <!--SMALL SCREEN MENU-->
                    <?php if(count($menu[$i]['items']) > 0): ?>
                        <li data-uk-dropdown="{justify:'#dropdown-nav'}" class="uk-hidden-large">
                    <?php else: ?>
                        <li class="uk-hidden-large">
                    <?php endif; ?>
                        <a href="<?php echo $menu[$i]['url']; ?>" class="<?php echo $menu[$i]['selected'] ? 'selected_cat' : ''; ?>">
                            <?php echo $menu[$i]['name']; ?>
                        </a>
                        <div class="uk-dropdown dropdown-nav uk-margin-large-left">
                            <ul>
                                <?php foreach ($menu[$i]['items'] as $child) : ?>

                                    <li>
                                        <a href="<?php echo $child['url']; ?>"
                                           style="<?php echo $child['selected'] ? 'text-decoration: underline;' : ''; ?>">
                                            <?php echo $child['name']; ?>
                                        </a>
                                    </li>

                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                    <!--END SMALL SCREEN MENU-->
                    
                <?php endfor; ?>

                <?php $second_menu = UtilsHelper::getSecondMenu();

                foreach ($second_menu as $item) :?>

                    <li>
                        <a class="main_menu_link" <?php if ($item['key'] == 'sell' && Yii::app()->member->isGuest) {
                            echo ' id="login_sell" '; // for calling of modal login window
                        } ?> href="<?php echo $item['url']; ?>"
                             style="<?php echo $item['selected'] ? 'text-decoration: underline;' : ''; ?>">
                            <?php echo $item['name']; ?>
                        </a>
                    </li>

                <?php endforeach; ?>

                <?php if ($top_menu['login']['visible']) { ?>
                    <li class="uk-hidden-large">
                        <a id="login_mobile" href="<?php echo $top_menu['login']['url']; ?>">
                            <i class="icon-ic_account uk-margin-right-mini"></i>
                            <span><?php echo $top_menu['login']['name'] ?></span>
                        </a>
                    </li>
                <?php } else { ?>
                    <li class="uk-hidden-large">
                        <a href="<?php echo $top_menu['account']['url']; ?>">
                            <i class="icon-ic_account uk-margin-right-mini"></i>
                            <span><?php echo $top_menu['account']['name'] ?></span>
                        </a>
                    </li>
                <?php } ?>

                <li id="cart-mobile-link" class="uk-hidden-large">
                    <?php $this->renderPartial('application.views.members.shop._cart_mobile'); ?>
                </li>

                <?php if ($top_menu['logout']['visible']) : ?>
                    <li class="uk-hidden-large">
                        <a href="<?php echo $top_menu['logout']['url']; ?>">
                            <i class="uk-icon-power-off uk-margin-right-mini"></i>
                            <span><?php echo $top_menu['logout']['name']; ?></span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- mobile logo -->
        <a href="/" class="uk-navbar-center uk-navbar-brand uk-hidden-large">
            <!--img src="<?php echo Yii::app()->request->baseUrl; ?>/uikit/images/logo-white.svg" alt="23-15" -->
        </a>
    </div>
</nav>
<!-- first view of selected menu item children -->
<div class="subnav uk-visible-large" data-uk-sticky="{top: 50}" id="div-first-load-sub-navigation">
    <div class="uk-dropdown dropdown-nav">
        <ul>
            <?php
            $flag = false; // visible of this sub navigation

            foreach ($menu as $item) {
                if ($item['selected']) {
                    $flag = true;

                    foreach ($item['items'] as $child) { ?>
                        <li><a href="<?php echo $child['url']; ?>"
                               style="<?php echo $child['selected'] ? 'text-decoration: underline;' : ''; ?>">
                                <?php echo $child['name']; ?>
                            </a>
                        </li>
                    <?php };
                }
            }
            ?>
        </ul>
    </div>
</div>

<script type="text/javascript">
    $('#div-first-load-sub-navigation').
    css('visibility', '<?php echo $flag ? 'visible' : 'hidden'; ?>');
</script>

<script>
    function ensureLoad(images, handler) {
        return images.each(function() {
            if ($(this).data('plugin') == 'lazy-load') {
                return true;
            }
            if(this.complete) {
                handler.call(this);
            } else {
                $(this).load(handler);
            }
        });
    }

    $(document).ready(function () {
        alignImageSizeWrapper();
    });

    $(document).ajaxComplete(function () {
        alignImageSizeWrapper();
    });

    function alignImageSizeWrapper() {
        //@see http://stackoverflow.com/a/5624901/5760062
        ensureLoad($('.thumbnail-image img'), function(){
            alignImageSize(this, globals.imgmw, globals.imgmh, globals.imgbc);
        });
    }

    function alignImageSize(img, maxWidth, maxHeight, borderColor) {
        var $img = $(img);
        var img_height = $img.height();
        var img_width = $img.width();

        var natural_width = $img.prop('naturalWidth');
        var natural_height = $img.prop('naturalHeight');
        if (natural_width && natural_height) {
            img_height = natural_height;
            img_width = natural_width;
        }

        var ratio = img_width / img_height; // -- vertical or horizontal image?

        var width = 0;
        var height = 0;
        var factor = 1;
        var border_t_b = 0;
        var border_l_r = 0;

        if (ratio >= 1) { // ---- horizontal image
            factor = maxWidth / img_width;
            width = maxWidth;
            height = img_height * factor;
            border_t_b = (maxHeight - height) / 2;
            height = maxHeight;
        } else { // ------------- vertical image
            factor = maxHeight / img_height;
            height = maxHeight;
            width = img_width * factor;
            border_l_r = (maxWidth - width) / 2;
            width = maxWidth;
        }

        $img.css({
            'width': width + 'px',
            'height': height + 'px',
            'border-top': border_t_b + 'px solid ' + borderColor,
            'border-bottom': border_t_b + 'px solid ' + borderColor,
            'border-left': border_l_r + 'px solid ' + borderColor,
            'border-right': border_l_r + 'px solid ' + borderColor,
            'visibility': 'visible'
        });
    }
</script>

<!--END NAVBAR-->

<?php echo $content; ?>

<?php $this->endContent(); ?>
