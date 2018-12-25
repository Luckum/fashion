<?php echo $this->beginContent('//layouts/site_layout'); ?>
<?php $top_menu = UtilsHelper::getTopMenu(); ?>
<!--NAVBAR-->
<nav class="uk-navbar uk-navbar-homepage" id="dropdown-nav">
    <a href="#" class="uk-navbar-toggle uk-navbar-toggle-home uk-hidden-large" data-uk-toggle="{target:'#navbar-collapse', cls: 'uk-animation-slide-left'}"></a>
    <div class="uk-navbar-content uk-navbar-flip uk-navbar-top-nav show-menu" style="width: 100%; padding-right: 20px;" id="navbar-collapse">
        <ul class="uk-navbar-nav top_menu uk-navbar-nav-light" style="width: 100%;">
            <li class="uk-visible-large">
                <a href="/"><img src="<?= Yii::app()->request->baseUrl ?>/images/logo-black.jpg" style="margin-top: -15px;"></a>
            </li>
            <li class="uk-hidden-large">
                <a href="/"><img src="<?= Yii::app()->request->baseUrl ?>/images/logo-white.jpg" style="margin-top: -5px;"></a>
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
                                    <li style="display: block;"><a style="font-size: 14px" href="<?=$child['url']?>"><?=$child['name']?></a></li>
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
            <li style="float: right;" class="uk-visible-large">
                <a class="main_menu_link search-icon" href="#search">
                    <?php echo Yii::t('base', 'Search'); ?>
                </a>
            </li>
            
            <?php if ($top_menu['login']['visible']) { ?>
                <li class="uk-visible-large" style="float: right;">
                    <a class="main_menu_link" id="wishlist_main" href="<?php echo $top_menu['login']['url']; ?>">
                        <span><?php echo $top_menu['wishlist']['name'] ?></span>
                    </a>
                </li>
            <?php } else { ?>
                <li class="uk-visible-large" style="float: right;">
                    <a class="main_menu_link" href="<?php echo $top_menu['wishlist']['url']; ?>">
                        <span><?php echo $top_menu['wishlist']['name'] ?></span>
                    </a>
                </li>
            <?php } ?>
            
            <!--<li id="cart" class="dropdown-bag-wrapper uk-visible-large" data-uk-dropdown="{mode:'hover', pos:'bottom-right'}" style="float: right;">
                <?php //$this->renderPartial('application.views.members.shop._cart'); ?>
            </li>-->

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

            <?php if ($top_menu['login']['visible']) { ?>
                <li class="uk-hidden-large">
                    <a class="main_menu_link" id="wishlist_mobile" href="<?php echo $top_menu['login']['url']; ?>">
                        <span><?php echo $top_menu['wishlist']['name'] ?></span>
                    </a>
                </li>
            <?php } else { ?>
                <li class="uk-hidden-large">
                    <a class="main_menu_link" href="<?php echo $top_menu['wishlist']['url']; ?>">
                        <span><?php echo $top_menu['wishlist']['name'] ?></span>
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
            
            <li class="uk-hidden-large">
                <a class="main_menu_link search-icon" href="#search">
                    <?php echo Yii::t('base', 'Search'); ?>
                </a>
            </li>
            
        </ul>
    </div>
</nav>
<!--END NAVBAR-->

<?php echo $content; ?>

<?php echo $this->endContent(); ?>
