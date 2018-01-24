<?php echo $this->beginContent('//layouts/site_layout'); ?>
<?php $top_menu = UtilsHelper::getTopMenu(); ?>
<!--NAVBAR-->
<nav class="uk-navbar uk-navbar-homepage" id="dropdown-nav" style="top:380px !important;" data-uk-sticky="{top:-380}">
    <div class="uk-navbar-content uk-navbar-flip uk-navbar-top-nav">
        <ul class="uk-navbar-nav top_menu uk-navbar-nav-light">

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

            <li id="cart" class="dropdown-bag-wrapper uk-visible-large" data-uk-dropdown="{mode:'hover', pos:'bottom-right'}">
                <?php $this->renderPartial('application.views.members.shop._cart'); ?>
            </li>

            <li>
                <a class="main_menu_link search-icon" href="#search"><i
                        class="icon-ic_search uk-margin-right-mini"></i>
                    <span class="uk-visible-large">
                        <?php echo Yii::t('base', 'Search'); ?>
                    </span>
                </a>
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
        <div class="uk-navbar-homepage-inner uk-clearfix">
            <a href="#" class="uk-navbar-toggle uk-navbar-toggle-home uk-hidden-large"
               data-uk-toggle="{target:'#navbar-collapse', cls: 'uk-animation-slide-left'}">
            </a>
            <!-- old logo was here -->
            <div class="uk-navbar-content uk-navbar-center show-menu" id="navbar-collapse">
                <?php
                $class = (stristr($_SERVER['HTTP_USER_AGENT'], 'Chrome') == TRUE) ? 'chrome-navbar' : '';
                ?>
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
                            <a href="<?=$menu[$i]['url']?>" class="main_menu_link"><?=$menu[$i]['name']?></a>
                            <div class="uk-dropdown dropdown-nav">
                                <ul>
                                    <?php foreach ($menu[$i]['items'] as $child) : ?>
                                        <li>
                                            <a style="font-size:0.95rem;" href="<?=$child['url']?>"><?=$child['name']?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </li>
                        <!--END LARGE AND MEDIUM SCREEN MENU-->
                        <!--SMALL SCREEN MENU-->
                        <?php if(count($menu[$i]['items']) > 0): ?>
                            <li data-uk-dropdown="{justify:'#dropdown-nav'}" class="category_menu uk-hidden-large">
                        <?php else: ?>
                            <li class="category_menu uk-hidden-large">
                        <?php endif; ?>
                            <a href="<?=$menu[$i]['url']?>"><?=$menu[$i]['name']?></a>
                            <div class="uk-dropdown dropdown-nav uk-margin-large-left">
                                <ul>
                                    <?php foreach ($menu[$i]['items'] as $child) : ?>
                                        <li>
                                            <a href="<?=$child['url']?>"><?=$child['name']?></a>
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
                            <a class="main_menu_link"<?php if($item['key'] == 'sell' && Yii::app()->member->isGuest){
                                echo ' id="login_sell" '; // for calling of modal login window
                            } ?>  href="<?php echo $item['url']; ?>"><?php echo $item['name']; ?></a>
                        </li>

                    <?php endforeach; ?>

                    <?php if ($top_menu['login']['visible']) { ?>
                        <li class="uk-hidden-large">
                            <a class="main_menu_link" id="login_mobile" href="<?php echo $top_menu['login']['url']; ?>">
                                <i class="icon-ic_account uk-margin-right-mini"></i>
                                <span><?php echo $top_menu['login']['name'] ?></span>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="uk-hidden-large">
                            <a class="main_menu_link" href="<?php echo $top_menu['account']['url']; ?>">
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
                            <a class="main_menu_link" href="<?php echo $top_menu['logout']['url']; ?>">
                                <i class="uk-icon-power-off uk-margin-right-mini"></i>
                                <span><?php echo $top_menu['logout']['name']; ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <!-- mobile logo -->
            <a href="/" class="uk-navbar-brand uk-navbar-center uk-hidden-large">
                <!-- svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                     y="0px" width="115px" height="30px" viewBox="0 0 187.6 46.8"
                     style="enable-background:new 0 0 187.6 46.8;" xml:space="preserve">
							<g>
                                <path class="st0" d="M26.1,46.1H0l1-6.6l14.1-15.3c0.6-0.7,1.3-1.5,2-2.3c0.7-0.8,1.3-1.7,1.9-2.6c0.6-0.9,1.1-1.8,1.5-2.8
										c0.4-1,0.7-1.9,0.8-2.9c0.1-0.6,0.1-1.2,0.1-1.9c0-0.7-0.1-1.4-0.3-2C20.9,9,20.6,8.4,20.2,8c-0.4-0.4-1-0.7-1.8-0.7
										c-1,0-1.8,0.2-2.5,0.7c-0.7,0.5-1.2,1.2-1.6,1.9c-0.4,0.8-0.7,1.6-0.9,2.5c-0.2,0.9-0.4,1.7-0.4,2.5l-8.6,0c0.1-2,0.6-3.9,1.4-5.7
										c0.8-1.8,1.8-3.4,3.1-4.8c1.3-1.4,2.8-2.5,4.6-3.3C15.1,0.4,17.1,0,19.2,0c1.9,0,3.6,0.4,5,1c1.4,0.6,2.6,1.5,3.6,2.6
										c0.9,1.1,1.6,2.5,2,4c0.4,1.6,0.5,3.2,0.4,5.1c-0.2,1.8-0.6,3.5-1.3,5.1c-0.7,1.6-1.6,3.1-2.6,4.5c-1,1.4-2.1,2.8-3.3,4.1
										c-1.2,1.3-2.4,2.6-3.6,3.9l-7,8.3h14.8L26.1,46.1z"/>
                                <path class="st0" d="M54.7,19.4l3.8,0.1c0.9,0,1.7-0.2,2.4-0.6c0.7-0.4,1.3-0.8,1.7-1.5c0.5-0.6,0.8-1.3,1.1-2.1
										c0.3-0.8,0.5-1.6,0.6-2.5c0.1-0.6,0.1-1.2,0-1.8c0-0.6-0.2-1.2-0.4-1.8c-0.2-0.6-0.5-1-1-1.4c-0.4-0.4-1-0.6-1.7-0.6
										c-0.7,0-1.4,0.1-1.9,0.4c-0.5,0.3-1,0.7-1.4,1.2c-0.4,0.5-0.7,1.1-0.9,1.7c-0.2,0.6-0.4,1.2-0.5,1.8l-8.6,0c0.1-1.8,0.6-3.5,1.4-5
										c0.8-1.5,1.7-2.9,3-4c1.2-1.1,2.6-2,4.2-2.6C58.1,0.2,59.8,0,61.7,0c1.9,0,3.6,0.4,5,1c1.5,0.6,2.7,1.5,3.7,2.6
										c1,1.1,1.7,2.4,2.2,4c0.5,1.5,0.6,3.2,0.5,5.1C73,13.9,72.8,15,72.4,16c-0.4,1-0.9,1.9-1.6,2.8c-0.7,0.8-1.4,1.6-2.3,2.3
										c-0.9,0.7-1.8,1.3-2.8,1.8c0.9,0.5,1.6,1.2,2.2,2c0.6,0.8,1.1,1.6,1.4,2.5c0.3,0.9,0.6,1.8,0.7,2.8c0.1,1,0.1,2,0,3
										c-0.1,2-0.6,3.9-1.5,5.6c-0.8,1.7-1.9,3.2-3.3,4.4c-1.4,1.2-2.9,2.1-4.7,2.8c-1.8,0.6-3.7,0.9-5.7,0.9c-1.9,0-3.6-0.4-5-1.1
										c-1.4-0.7-2.6-1.6-3.6-2.8c-0.9-1.2-1.6-2.6-2.1-4.1c-0.4-1.6-0.6-3.3-0.6-5l8.6,0c0,0.6,0,1.2,0.1,1.9c0.1,0.7,0.3,1.3,0.5,1.8
										c0.3,0.6,0.6,1,1.1,1.4c0.5,0.4,1.1,0.6,1.9,0.6c0.9,0,1.7-0.1,2.4-0.5c0.7-0.4,1.3-0.9,1.8-1.5c0.5-0.6,0.9-1.3,1.2-2.1
										c0.3-0.8,0.5-1.6,0.6-2.3c0.1-0.7,0.1-1.5,0.1-2.2c0-0.7-0.2-1.4-0.4-2c-0.2-0.6-0.6-1.1-1.2-1.5c-0.5-0.4-1.2-0.6-2.1-0.7l-4.6,0
										L54.7,19.4z"/>
                                <path class="st0" d="M103.7,30.3H88.8l1.3-7.4H105L103.7,30.3z"/>
                                <path class="st0" d="M133.9,46.1h-8.7l6-34.6l-9,3.3l1.4-7.7l16.9-6.6h1.1L133.9,46.1z"/>
                                <path class="st0" d="M159.9,23.7l6.2-23h21.5l-1.3,7.6h-14.3l-2.8,9.8c0.7-0.5,1.6-1,2.4-1.3c0.9-0.3,1.7-0.5,2.7-0.5
										c1.4,0,2.6,0.2,3.6,0.6c1,0.4,1.9,1,2.6,1.8c0.7,0.7,1.3,1.6,1.8,2.6c0.4,1,0.8,2,1,3.2c0.2,1.1,0.4,2.3,0.4,3.5
										c0,1.2,0,2.3-0.1,3.4c-0.2,2-0.7,4-1.4,5.9c-0.8,1.9-1.8,3.6-3,5c-1.3,1.4-2.8,2.6-4.5,3.5c-1.8,0.9-3.7,1.2-6,1.2
										c-1.9-0.1-3.5-0.5-5-1.2c-1.4-0.7-2.6-1.7-3.6-3c-1-1.2-1.7-2.6-2.2-4.2c-0.5-1.6-0.7-3.3-0.6-5h8.5c0,0.6,0,1.2,0.1,1.9
										c0.1,0.7,0.2,1.3,0.5,1.9c0.2,0.6,0.6,1.1,1,1.5c0.5,0.4,1.1,0.6,1.8,0.6c1.1,0,1.9-0.2,2.7-0.8c0.7-0.6,1.3-1.3,1.7-2.2
										c0.4-0.9,0.7-1.8,0.9-2.9c0.2-1,0.3-1.9,0.4-2.7c0.1-0.7,0.1-1.5,0.1-2.4c0-0.9-0.1-1.7-0.3-2.5c-0.2-0.8-0.6-1.4-1.1-2
										c-0.5-0.5-1.3-0.8-2.3-0.8c-1,0-1.9,0.2-2.6,0.7c-0.7,0.5-1.4,1.1-2,1.8L159.9,23.7z"/>
                            </g>
						</svg -->
            </a>
        </div>
    </div>
</nav>
<!--END NAVBAR-->

<?php echo $content; ?>

<?php echo $this->endContent(); ?>
