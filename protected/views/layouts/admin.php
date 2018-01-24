<?php $this->beginContent('//layouts/main_admin'); ?>
<div class="container" id="page">
    <div class="clear"></div>

    <div id="mainmenu" class="navbar navbar-inverse">
        <div class="navbar-inner" style="padding: 5px;">
        <?php $this->widget('zii.widgets.CMenu',array(
            'htmlOptions' => array('class' => 'nav'),
            'activateItems' => true,
            'activateParents' => true,
            'submenuHtmlOptions' => array('class' => 'dropdown-menu inverse'),
            'items'=>array(
                array('label'=>Yii::t('base', 'Home'), 'url'=>array('/control/index')),
                array('label'=>Yii::t('base', 'Login'), 'url'=>array('/control/auth/login'), 'visible'=>Yii::app()->admin->isGuest),
                array('label'=>Yii::t('base', 'Users'), 'url' => array('/control/users'), 'visible' => !Yii::app()->admin->isGuest, 'active' => isset($this->usersActive)),
                array(
                    'label' => Yii::t('base', 'Market'),
                    'url' => '#',
                    'visible' => !Yii::app()->admin->isGuest,
                    'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
                    'itemOptions' => array('class' => 'dropdown'),
                    'items' => array(
                        array('label'=>Yii::t('base', 'Products'), 'url' => array('/control/products'), 'visible' => !Yii::app()->admin->isGuest, 'active' => isset($this->productsActive)),
                        array('label'=>Yii::t('base', 'Orders'), 'url' => array('/control/orders'), 'visible' => !Yii::app()->admin->isGuest, 'active' => isset($this->ordersActive)),
                        array('label'=>Yii::t('base', 'Reports'), 'url' => array('/control/reports'), 'visible' => !Yii::app()->admin->isGuest, 'active' => isset($this->reportsActive)),
                        array('label'=>Yii::t('base', 'Ratings'), 'url' => array('/control/ratings'), 'visible' => !Yii::app()->admin->isGuest, 'active' => isset($this->ratingsActive)),
                         array('label'=>Yii::t('base', 'Product reports'), 'url' => array('/control/productReports'), 'visible' => !Yii::app()->admin->isGuest, 'active' => isset($this->productsReportsActive)),
                    ),
                ),
                array(
                    'label' => Yii::t('base', 'Market Settings'),
                    'url' => '#',
                    'visible' => (!Yii::app()->admin->isGuest),
                    'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' =>'dropdown'),
                    'itemOptions' => array('class' => 'dropdown'),
                    'items' => array(
                        array('label'=>Yii::t('base', 'Brands'), 'url' => array('/control/brands'), 'visible' => (!Yii::app()->admin->isGuest), 'active' => isset($this->brandsActive)),
                        array('label'=>Yii::t('base', 'Categories'), 'url' => array('/control/categories'), 'visible' => (!Yii::app()->admin->isGuest), 'active' => isset($this->categoriesActive)),
                        array('label'=>Yii::t('base', 'Attributes'), 'url' => array('/control/attributes'), 'visible' => (!Yii::app()->admin->isGuest), 'active' => isset($this->attributesActive)),
                        array('label'=>Yii::t('base', 'Conditions'), 'url' => array('/control/settings/conditions'), 'visible' => (!Yii::app()->admin->isGuest), 'active' => isset($this->attributesActive)),
                        array('label'=>Yii::t('base', 'Size categories'), 'url' => array('/control/sizeCategories'), 'visible' => (!Yii::app()->admin->isGuest), 'active' => isset($this->attributesActive)),
                        array('label'=>Yii::t('base', 'Sizes'), 'url' => array('/control/sizes'), 'visible' => (!Yii::app()->admin->isGuest), 'active' => isset($this->attributesActive)),
                        array('label'=>Yii::t('base', 'Colors'), 'url' => array('/control/colors'), 'visible' => (!Yii::app()->admin->isGuest), 'active' => isset($this->attributesActive)),
                    ),
                ),
                array(
                    'label' => Yii::t('base', 'CMS'),
                    'url' => '#',
                    'visible' => !Yii::app()->admin->isGuest,
                    'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
                    'itemOptions' => array('class' => 'dropdown'),
                    'items' => array(
                        array('label'=>Yii::t('base', 'Static Pages'), 'url' => array('/control/pages/index'), 'visible' => !Yii::app()->admin->isGuest, 'active' => isset($this->pagesActive)),
                        array('label'=>Yii::t('base', 'Email Templates'), 'url' => array('/control/templates/index'), 'visible' => !Yii::app()->admin->isGuest, 'active' => isset($this->templatesActive)),
                        array('label'=>Yii::t('base', 'Homepage Blocks'), 'url' => array('/control/blocks/index'), 'visible' => (!Yii::app()->admin->isGuest), 'active' => isset($this->blocksActive)),
                        array('label' => Yii::t('base', 'Main Menu Images'), 'url' => array('/control/menuImages/index'), 'visible' => (!Yii::app()->admin->isGuest)),
                        array(
                            'label'=>Yii::t('base', 'Blog'), 
                            'url' => array('/control/blog/index'), 
                            'itemOptions' => array('class' => 'dropdown-submenu'),
                            'visible' => (!Yii::app()->admin->isGuest),
                            'items' => array(
                                array('label'=>Yii::t('base', 'Categories'), 'url' => array('/control/blogCategory'), 'visible' => !Yii::app()->admin->isGuest),
                                array('label'=>Yii::t('base', 'Posts'), 'url' => array('/control/blogPost'), 'visible' => !Yii::app()->admin->isGuest),
                                array('label'=>Yii::t('base', 'Comments'), 'url' => array('/control/blogComment'), 'visible' => !Yii::app()->admin->isGuest),
                            ),
                        ),
                    ),
                ),
                array(
                    'label' => Yii::t('base', 'Website Settings'),
                    'url' => '#',
                    'visible' => (!Yii::app()->admin->isGuest),
                    'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' =>'dropdown'),
                    'itemOptions' => array('class' => 'dropdown'),
                    'items' => array(
                        array('label'=>Yii::t('base', 'Common Settings'), 'url' => array('/control/settings/misc'), 'visible' => (!Yii::app()->admin->isGuest), 'active' => isset($this->miscActive)),
                        array('label'=>Yii::t('base', 'SEO Settings'), 'url' => array('/control/settings/seo'), 'visible' => (!Yii::app()->admin->isGuest), 'active' => isset($this->seoActive)),
                        array('label'=>Yii::t('base', 'Payment Settings'), 'url' => array('/control/settings/payment'), 'visible' => (!Yii::app()->admin->isGuest), 'active' => isset($this->paymentActive)),
                        array('label'=>Yii::t('base', 'Shipping Settings'), 'url' => array('/control/settings/shipping'), 'visible' => (!Yii::app()->admin->isGuest), 'active' => isset($this->shippingActive)),
                        array('label'=>Yii::t('base', 'Languages'), 'url' => array('/control/settings/languages'), 'visible' => (!Yii::app()->admin->isGuest), 'active' => isset($this->languagesActive)),
                        array('label'=>Yii::t('base', 'Comments'), 'url' => array('/control/settings/comments/bannedwords'), 'visible' => (!Yii::app()->admin->isGuest), 'active' => isset($this->commentsActive)),
                        array('label'=>Yii::t('base', 'APIs'), 'url' => array('/control/settings/apis'), 'visible' => (!Yii::app()->admin->isGuest), 'active' => isset($this->apisActive)),
                    ),
                ),
            ),
        )); ?>
        <?php $this->widget('zii.widgets.CMenu',array(
            'htmlOptions' => array('class' => 'nav pull-right'),
            'items'=>array(
                array('label'=>Yii::t('base', 'My Profile'), 'url' => array('/control/admins/view', 'id' => !Yii::app()->admin->isGuest ? Yii::app()->admin->id : 0), 'visible' => !Yii::app()->admin->isGuest, 'active' => isset($this->adminsActive)),

                array('label'=>Yii::t('base', 'Logout ('.(!Yii::app()->admin->isGuest?Yii::app()->admin->username:Yii::app()->admin->guestName).')'), 'url'=>array('/control/auth/logout'), 'visible'=>!Yii::app()->admin->isGuest, 'htmlOptions'=>array('class'=>'pull-right'))
            ),
        )); ?>
        </div>
    </div><!-- mainmenu -->
    <?php if(isset($this->breadcrumbs)):?>
        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
        )); ?><!-- breadcrumbs -->
    <?php endif?>
    <div id="content admin">
    <?php echo $content; ?>
    </div><!-- content -->
</div><!-- page -->
<?php $this->endContent(); ?>