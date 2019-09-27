<?php $this->beginContent('//layouts/site_layout'); ?>

<?php $top_menu = UtilsHelper::getTopMenu(); ?>

<!--NAVBAR-->
<nav class="uk-navbar padding-top-30" id="dropdown-nav" data-uk-sticky>
    <a href="#" class="uk-navbar-toggle uk-navbar-toggle-home uk-hidden-large" data-uk-toggle="{target:'#navbar-collapse', cls: 'uk-animation-slide-left'}"></a>
    <div class="uk-navbar-content uk-navbar-flip show-menu" style="width: 100%; padding-right: 20px;" id="navbar-collapse">
        <ul class="uk-navbar-nav top_menu uk-navbar-nav-light" style="width: 100%;">
            <li class="uk-visible-large">
                <a href="/"><img src="<?= Yii::app()->request->baseUrl ?>/images/logo-black.jpg" style="margin-top: -15px;" alt="N2315.com - best designer clothing stores in one place"></a>
            </li>
            <li class="uk-hidden-large">
                <a href="/"><img src="<?= Yii::app()->request->baseUrl ?>/images/logo-white.jpg" style="margin-top: -5px;" alt="N2315.com - best designer clothing stores in one place"></a>
            </li>
            <?php $menu = UtilsHelper::getCategoryMenu(); $count = count($menu);?>
            <?php for ($i = 0; $i < $count; $i++): ?>
                <?php if (count($menu[$i]['items']) > 0): ?>
                    <li data-uk-dropdown="{'bottom-justify':'#dropdown-nav','mode':'click'}" class="nav-correction uk-hidden-medium uk-hidden-small">
                <?php else: ?>
                    <li class="nav-correction uk-hidden-medium uk-hidden-small">
                <?php endif; ?>
                        <a href="<?=$menu[$i]['url']?>" class="main_menu_link"><?=$menu[$i]['name']?></a>
                        <div class="uk-dropdown dropdown-nav">
                            <ul class="uk-nav uk-dropdown-nav">
                                <?php foreach ($menu[$i]['items'] as $child) : ?>
                                    <li style="display: block;"><a style="font-size: 14px; color: #000;" href="<?=$child['url']?>"><?=$child['name']?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                <?php if(count($menu[$i]['items']) > 0): ?>
                    <li data-uk-dropdown="{justify:'#dropdown-nav'}" class="category_menu uk-hidden-large">
                <?php else: ?>
                    <li class="category_menu uk-hidden-large">
                <?php endif; ?>
                        <a href="<?=$menu[$i]['url']?>"><?=$menu[$i]['name']?></a>
                        <div class="uk-dropdown dropdown-nav uk-margin-large-left">
                            <ul>
                                <?php foreach ($menu[$i]['items'] as $child) : ?>
                                    <li><a href="<?=$child['url']?>"><?=$child['name']?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
            <?php endfor; ?>
            
<!--            <?php $second_menu = UtilsHelper::getSecondMenu();
                foreach ($second_menu as $item): ?>
                    <li>
                        <a class="main_menu_link"<?php if($item['key'] == 'sell' && Yii::app()->member->isGuest){
                            echo ' id="login_sell" '; // for calling of modal login window
                            } ?>  href="<?php echo $item['url']; ?>"><?php echo $item['name']; ?></a>
                    </li>
            <?php endforeach; ?>-->
            
            <?php if ($top_menu['logout']['visible']) : ?>
                <li class="uk-visible-large" style="float: right;">
                    <a class="main_menu_link" href="<?php echo $top_menu['logout']['url']; ?>">
                        <span><?php echo $top_menu['logout']['name']; ?></span>
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if ($top_menu['login']['visible']) { ?>
                <li class="uk-visible-large" style="float: right;">
                    <a class="main_menu_link" id="login_main" href="<?php echo $top_menu['login']['url']; ?>">
                        <span><?php echo $top_menu['login']['name'] ?></span>
                    </a>
                </li>
            <?php } else { ?>
                <li class="uk-visible-large" style="float: right;">
                    <a class="main_menu_link" href="<?php echo $top_menu['account']['url']; ?>">
                        <span><?php echo $top_menu['account']['name'] ?></span>
                    </a>
                </li>
            <?php } ?>
            
            <li id="currency-selector" data-uk-dropdown="{'bottom-justify':'#dropdown-nav','mode':'click'}" class="nav-correction uk-hidden-medium uk-hidden-small" style="float: right;">
                <?php $current_currency = Currency::getCurrency() ?>
                <?php $currencies_list = Currency::getList(); ?>
                <a href="javascript:void(0)" class="main_menu_link currency-selector"><?= $current_currency->name . '&nbsp;' . $current_currency->sign; ?></a>
                <div class="uk-dropdown dropdown-nav" style="left: 0; width: auto;">
                    <ul class="uk-nav uk-dropdown-nav">
                        <?php foreach ($currencies_list as $currency): ?>
                            <li style="display: block;"><a style="font-size: 14px; color: #000; padding-left: 12px;" href="javascript:void(0);" onclick="setCurrency('<?= $currency->id ?>')"><?= $currency->name . '&nbsp;' . $currency->sign ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </li>
            
            
            <li style="float: right;" class="uk-visible-large">
                <a class="main_menu_link search-icon" href="#search">
                    <?php echo Yii::t('base', 'Search'); ?>
                </a>
            </li>
            
            <li class="uk-hidden-large">
                <a class="main_menu_link search-icon" href="#search">
                    <?php echo Yii::t('base', 'Search'); ?>
                </a>
            </li>
            
            <li id="currency-selector-mbl" data-uk-dropdown="{'bottom-justify':'#dropdown-nav'}" class="uk-hidden-large">
                <?php $current_currency = Currency::getCurrency() ?>
                <?php $currencies_list = Currency::getList(); ?>
                <a href="javascript:void(0)" class="main_menu_link currency-selector"><?= $current_currency->name . '&nbsp;' . $current_currency->sign; ?></a>
                <div class="uk-dropdown dropdown-nav" style="left: 0; width: auto;">
                    <ul class="uk-nav uk-dropdown-nav">
                        <?php foreach ($currencies_list as $currency): ?>
                            <li style="display: block;"><a style="font-size: 14px; color: #000;" href="javascript:void(0);" onclick="setCurrency('<?= $currency->id ?>')"><?= $currency->name . '&nbsp;' . $currency->sign ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </li>
            
            
            <?php if ($top_menu['login']['visible']) { ?>
                <li class="uk-hidden-large">
                    <a class="main_menu_link" id="login_mobile" href="<?php echo $top_menu['login']['url']; ?>">
                        <span><?php echo $top_menu['login']['name'] ?></span>
                    </a>
                </li>
            <?php } else { ?>
                <li class="uk-hidden-large">
                    <a class="main_menu_link" href="<?php echo $top_menu['account']['url']; ?>">
                        <span><?php echo $top_menu['account']['name'] ?></span>
                    </a>
                </li>
            <?php } ?>

            <!--<li id="cart-mobile-link" class="uk-hidden-large">
                <?php //$this->renderPartial('application.views.members.shop._cart_mobile'); ?>
            </li>-->

            <?php if ($top_menu['logout']['visible']) : ?>
                <li class="uk-hidden-large">
                    <a class="main_menu_link" href="<?php echo $top_menu['logout']['url']; ?>">
                        <span><?php echo $top_menu['logout']['name']; ?></span>
                    </a>
                </li>
            <?php endif; ?>
            
            
        </ul>
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
    
    function setCurrency(currency_id)
    {
        $("body").addClass("loading");
        $.ajax({
            type: "POST",
            data: {currency: currency_id},
            success: function (data) {
                var response = JSON.parse(data);
                $("#products").html(response.html);
                $("#currency-selector").html(response.selector_html);
                $("#currency-selector-mbl").html(response.selector_html);
                $("#currency-selector").removeClass("uk-open");
                $("#currency-selector-mbl").removeClass("uk-open");
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
                $("body").removeClass("loading");
            }
        });
    }
</script>

<!--END NAVBAR-->

<?php echo $content; ?>

<?php $this->endContent(); ?>
