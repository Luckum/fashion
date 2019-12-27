<?php

echo $this->beginContent('//layouts/site_layout');
$top_menu = UtilsHelper::getTopMenu();
$menu = UtilsHelper::getCategoryMenu(); $count = count($menu);
$brands = Brand::getBrandsSorted();

?>
<!--NAVBAR-->
<nav class="uk-navbar uk-navbar-homepage uk-hidden-medium uk-hidden-small" id="dropdown-nav">
    <div class="uk-navbar-content uk-navbar-flip uk-navbar-top-nav show-menu" style="width: 100%; padding-right: 20px;" id="navbar-collapse">
        <ul class="uk-navbar-nav top_menu uk-navbar-nav-light" style="width: 100%;">
            <li class="uk-visible-large">
                <a href="/"><img src="<?= Yii::app()->request->baseUrl ?>/images/logo-black.jpg" style="margin-top: -15px;" alt="N2315.com - best designer clothing stores in one place" width="140" height="30"></a>
            </li>
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
                                    <li style="display: block;"><a style="font-size: 14px" href="<?=$child['url']?>"><?=$child['name']?></a></li>
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
        </ul>
    </div>
</nav>



<div class="uk-hidden-large">
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
        <div class="mbl-nav-logo idx-logo">
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
        </div>
    </div>
</div>
<!--END NAVBAR-->

<script>
    $('.mbl-nav-lnk').click(function () {
        if ($('#nav-level-1').is(":visible")) {
            $('.mbl-nav').hide('slide', { direction: 'left' }, 300);
            $('.uk-container').show();
        } else {
            $('#nav-level-1').show('slide', { direction: 'left' }, 300);
            $('.uk-container').hide();
        }
    });
    $('.close-menu-lnk').click(function () {
        $('.mbl-nav').hide('slide', { direction: 'left' }, 300);
        $('.uk-container').show();
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

<?php echo $content; ?>

<?php echo $this->endContent(); ?>