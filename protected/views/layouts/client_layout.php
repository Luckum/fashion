<?php $this->beginContent('//layouts/site_layout'); ?>

<?php

$top_menu = UtilsHelper::getTopMenu();
$brands = Brand::getBrandsSorted();

?>

<!--NAVBAR-->
<nav class="uk-navbar padding-top-30 uk-hidden-small" id="dropdown-nav" data-uk-sticky>
    <div class="uk-navbar-content uk-navbar-flip show-menu" style="width: 100%; padding-right: 20px;" id="navbar-collapse">
        <ul class="uk-navbar-nav top_menu uk-navbar-nav-light" style="width: 100%;">
            <li class="uk-visible-large">
                <a href="/"><img src="<?= Yii::app()->request->baseUrl ?>/images/logo-black.jpg" style="margin-top: -15px;" alt="N2315.com - best designer clothing stores in one place" width="140" height="30"></a>
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
            <?php endfor; ?>
            
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

<div class="uk-hidden-large mbl-nav-cnt">
    <div id="nav-level-1" style="display: none;" class="mbl-nav">
        <ul>
            <?php foreach ($menu as $menu_item): ?>
                <?php if ($menu_item['id'] != Category::getIdByAlias('featured')): ?>
                    <li><a class="level-entry" href="javascript:void(0);" data-item-id="<?= $menu_item['id'] ?>" data-item-level="2"><?= $menu_item['name'] ?></a></li>
                <?php endif; ?>
            <?php endforeach; ?>
            <li><a class="level-entry" href="javascript:void(0);" data-item-id="design" data-item-level="2">Designers</a></li>
            <li><a class="level-entry" href="javascript:void(0);" data-item-id="sale" data-item-level="2">Sale</a></li>
        </ul>
            
        <div class="close-menu">
            <a href="javascript:void(0)" class="close-menu-lnk">Close</a>
        </div>
    </div>

    <?php foreach ($menu as $menu_item): ?>
        <div id="nav-level-2-<?= $menu_item['id'] ?>" style="display: none;" class="mbl-nav">
            <ul>
                <li><a class="level-back" data-level-to="1" data-level-from="2-<?= $menu_item['id'] ?>" href="javascript:void(0);">Back</a></li>
                <li><a href="<?= $menu_item['url']?>">all <?= $menu_item['name']?></a></li>
                <?php foreach ($menu_item['items'] as $child) : ?>
                    <li><a style="text-transform: capitalize;" href="<?= $child['url'] ?>"><?= $child['name'] ?></a></li>
                <?php endforeach; ?>
            </ul>
            <div class="close-menu">
                <a href="javascript:void(0)" class="close-menu-lnk">Close</a>
            </div>
        </div>
    <?php endforeach; ?>
    
    <div id="nav-level-2-sale" style="display: none;" class="mbl-nav">
        <ul>
            <li><a class="level-back" data-level-to="1" data-level-from="2-sale" href="javascript:void(0);">Back</a></li>
            <?php foreach ($menu as $menu_item): ?>
                <?php if ($menu_item['id'] != Category::getIdByAlias('featured')): ?>
                    <li><a class="level-entry" style="text-transform: capitalize;" href="javascript:void(0);" data-item-id="<?= $menu_item['id'] ?>" data-item-level="3"><?= $menu_item['name'] ?></a></li>
                <?php endif; ?>
            <?php endforeach; ?>
            <li><a class="level-entry" href="javascript:void(0);" style="text-transform: capitalize;" data-item-id="design" data-item-level="3">Designers</a></li>
        </ul>
            
        <div class="close-menu">
            <a href="javascript:void(0)" class="close-menu-lnk">Close</a>
        </div>
    </div>
    
    <?php foreach ($menu as $menu_item): ?>
        <div id="nav-level-3-<?= $menu_item['id'] ?>" style="display: none;" class="mbl-nav">
            <ul>
                <li><a class="level-back" data-level-to="2" data-level-from="3-<?= $menu_item['id'] ?>" href="javascript:void(0);">Back</a></li>
                <li><a href="<?= $menu_item['url'] . '/sale'?>">all <?= $menu_item['name']?></a></li>
                <?php foreach ($menu_item['items'] as $child) : ?>
                    <li><a style="text-transform: capitalize;" href="<?= $child['url'] . '/sale' ?>"><?= $child['name'] ?></a></li>
                <?php endforeach; ?>
            </ul>
            <div class="close-menu">
                <a href="javascript:void(0)" class="close-menu-lnk">Close</a>
            </div>
        </div>
    <?php endforeach; ?>
    
    <div id="nav-level-2-design" style="display: none;" class="mbl-nav">
        <ul>
            <li><a class="level-back" data-level-to="1" data-level-from="2-design" href="javascript:void(0);">Back</a></li>
            <li><input type="text" id="search-text-design" name="search-text" class="search-input-normal" maxlength="50"/ placeholder="Search by designer"></li>
            <?php foreach ($brands as $brand): ?>
                <li style="padding-top: 5px;">
                    <a style="text-transform: capitalize;" href="/designers/<?= $brand->url ?>"><?= $brand->name ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
            
        <div class="close-menu">
            <a href="javascript:void(0)" class="close-menu-lnk">Close</a>
        </div>
    </div>
    
    <div id="nav-level-3-design" style="display: none;" class="mbl-nav">
        <ul>
            <li><a class="level-back" data-level-to="2" data-level-from="3-design" href="javascript:void(0);">Back</a></li>
            <li><input type="text" id="search-text-design-sale" name="search-text" class="search-input-normal" maxlength="50"/ placeholder="Search by designer"></li>
            <?php foreach ($brands as $brand): ?>
                <li style="padding-top: 5px;">
                    <a style="text-transform: capitalize;" href="/designers/<?= $brand->url ?>/sale"><?= $brand->name ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
            
        <div class="close-menu">
            <a href="javascript:void(0)" class="close-menu-lnk">Close</a>
        </div>
    </div>
    
    <div class="mbl-nav-cnt">
        <a class="mbl-nav-lnk" href="javascript:void(0);"></a>
        <a class="main_menu_link search-icon" href="#search"></a>
        <div class="mbl-nav-logo">
            <a href="/"><img src="<?= Yii::app()->request->baseUrl ?>/images/logo-white.jpg" style="margin-top: -5px;" alt="N2315.com - best designer clothing stores in one place" width="140" height="30"></a>
        </div>
        <div class="mbl-nav-right">
            <?php if ($top_menu['login']['visible']) { ?>
                <a class="main_menu_link" id="login_mobile" href="<?php echo $top_menu['login']['url']; ?>"></a>
            <?php } else { ?>
                <a class="main_menu_link" href="<?php echo $top_menu['account']['url']; ?>">
                    <span><?php echo $top_menu['account']['name'] ?></span>
                </a>
            <?php } ?>

            <?php if ($top_menu['logout']['visible']) : ?>
                <a class="main_menu_link" href="<?php echo $top_menu['logout']['url']; ?>">
                    <span><?php echo $top_menu['logout']['name']; ?></span>
                </a>
            <?php endif; ?>
            
            <span id="currency-selector-mbl">
                <?php $current_currency = Currency::getCurrency() ?>
                <?php $currencies_list = Currency::getList(); ?>
                <a href="javascript:void(0)" class="main_menu_link currency-selector" id="currency-nav-cnt-lnk" onclick="showCurrency();"><?= $current_currency->name . '&nbsp;' . $current_currency->sign; ?></a>
                <div class="uk-dropdown dropdown-nav" style="width: 63px; display: none;margin-top: 13px;" id="currency-nav-cnt">
                    <ul class="uk-nav uk-dropdown-nav">
                        <?php foreach ($currencies_list as $currency): ?>
                            <li style="display: block;"><a style="font-size: 14px; color: #000; padding-left: 12px; padding-right:0;text-align: right;" href="javascript:void(0);" onclick="setCurrency('<?= $currency->id ?>')"><?= $currency->name . '&nbsp;' . $currency->sign ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </span>
            
        </div>
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
                $("#currency-selector-mbl").html(response.selector_html_mbl);
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
    $(window).click(function() {
        $("#currency-nav-cnt").hide();
    });
    function showCurrency()
    {
        event.stopPropagation();
        $('.mbl-nav').hide('slide', { direction: 'left' }, 300);
        $('.uk-block').show();
        $('#currency-nav-cnt').slideDown();
    }
    
    $('.mbl-nav-lnk').click(function () {
        $('.mbl-tools-sort').hide();
        if ($('#nav-level-1').is(":visible")) {
            $('.mbl-nav').hide('slide', { direction: 'left' }, 300);
            $('.uk-block').show();
        } else {
            $('#nav-level-1').show('slide', { direction: 'left' }, 300);
            $('.uk-block').hide();
        }
    });
    $('.close-menu-lnk').click(function () {
        $('.mbl-nav').hide('slide', { direction: 'left' }, 300);
        $('.uk-block').show();
    });
    $('.level-entry').click(function () {
        var idx = $(this).attr('data-item-id')
            level = $(this).attr('data-item-level');
        $('#nav-level-' + level + '-' + idx).show('slide', { direction: 'right' }, 300);
    });
    $('.level-back').click(function () {
        var backTo = $(this).attr('data-level-to'),
            backFrom = $(this).attr('data-level-from');
        $('#nav-level-' + backFrom).hide('slide', { direction: 'right' }, 300);
        $('#nav-level-' + backTo).show('slide', { direction: 'left' }, 300);
    });
</script>

<!--END NAVBAR-->

<?php echo $content; ?>

<?php $this->endContent(); ?>
