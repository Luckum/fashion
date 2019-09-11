<!DOCTYPE html>
<html lang="en">
<?php
/**
 * SEO-параметры.
 */

// Название сайта (title).
if (!isset($this->title)) {
    $this->title = Yii::app()->params['seo']['site_name'];
}

// META description.
if (isset($this->meta_description)) {
    $description = $this->meta_description;
} else {
    $description = Yii::app()->params['seo']['meta_description'];
}

// META keywords.
if (isset($this->meta_keywords)) {
    $keywords = $this->meta_keywords;
} else {
    $keywords = Yii::app()->params['seo']['meta_keywords'];
}

// no-caching
//
$noCacheHeader = '';
$noCacheParameter = '';

if (YII_DEBUG) {
//    $noCacheHeader =
//        '<meta http-equiv="cache-control" content="no-cache" />
//         <meta http-equiv="pragma" content="no-cache" />
//         <meta name="expires" content="0" />';

    //$noCacheParameter = '?nocache=' . rand(1, 1000);
}
?>
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-147078144-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-147078144-1');
    </script>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="description" content="<?=CHtml::encode($description)?>">
    <meta name="p:domain_verify" content="974be073ba2c43edbc2aff13c6adc6f2"/>
    <meta name="fo-verify" content="e0f8bd61-0f64-47a0-ae53-adfccf08d641">
    <!-- meta property="og:image" content="<?=Yii::app()->createAbsoluteUrl('/images/logo-black-fb.png')?>" -->
    <?php 
    $link = explode('/',$_SERVER['REQUEST_URI']);
    if(!empty($link[1])) {
        if(stristr($link[1], 'profile-') !== FALSE) {
            echo '<meta property="og:title" content="Shop My Wardrobe">';
        }
    }
    ?>

    <?php echo $noCacheHeader; ?>

    <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/uikit/css/all-min.css<?php echo $noCacheParameter; ?>">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/uikit/css/added.css<?php echo $noCacheParameter; ?>">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css<?php echo $noCacheParameter; ?>">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.scrollbar.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui-min.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/EasyAutocomplete-1.3.5/easy-autocomplete.css">

    <!-- jQuery lib must be higher than title, because EFancyBox include it scripts under last js script,
         which is situated above title  -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/uikit/js/jquery-1.11.3.min.js"></script>
    <title><?=CHtml::encode($this->title)?></title>
    <!-- Hotjar Tracking Code for https://www.n2315.com -->
    <script>
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:1464278,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
    </script>
</head>
<body>

<!--Уведомление для стран евросоюза-->
<div class="eu-notif">
    <?= Yii:: t('base', 'We use cookies to improve the website&#39;s usability and your shopping experience. <br/>By continuing to browse our site you accept our cookie policy.') ?>
    <a class="uk-base-link" href="<?= UtilsHelper::getPrivacyLink() ?>"><?= Yii::t('base', 'More') ?>.</a>
    <?= CHtml:: button(Yii:: t('base', 'OK'), array('class' => 'eu-notif-btn')) ?>
</div>

<!--WRAPPER-->
<div class="wrapper">

    <?php echo $content; ?>

    <!--OVERLAY-->
    <div id="lean_overlay"></div>

    <!--SEARCH MODAL-->
    <div id="search-dlg">
        <?=CHtml::imageButton(Yii::app()->request->baseUrl . '/images/dialog-close.png', array('class' => 'lnMod-cls-btn'))?>
        <span><?= Yii::t('base', 'Search by designer, category or product') ?>:</span>
        <div id="search-box">
            <input type="text" id="search-text" name="search-text" class="search-input-normal" maxlength="50"/>
        </div>
    </div>
    <!--END SEARCH MODAL-->
    
    <div id="newsletter-frm" style="float: right; margin-right: 10%; display: none;">
        <form class="uk-form">
            <input type="email" id="newsletter-email" style="border: 2px solid #000;" placeholder="<?= Yii::t('base', 'email address') ?>">
            <input type="button" id="newsletter-btn" value="<?= Yii::t('base', 'Subscribe') ?>" class="uk-button uk-button-small" style="line-height: 26px; min-height: 26px;">
        </form>
    </div>
    
    <!--FOOTER-->
    <div class="footer">
        <div class="footer-inner">
            <div class="uk-flex uk-flex-middle uk-flex-space-between uk-flex-row-reverse">
                <div>
                    <ul class="footer-list">
                        <?php if (Yii::app()->member->isGuest): ?>
                            <li>
                                <a href="javascript:void(0);" id="newsletter-link">Newsletter</a>
                            </li>
                        <?php endif; ?>
                        <?php $menu = UtilsHelper::getRightFooterLinks(Yii::app()->getLanguage()); ?>
                        <?php $count = count($menu); ?>
                        <?php for ($i = 0; $i < $count; $i++) : ?>
                            <?php if ($i < 3): ?>
                                <li>
                                    <?php echo CHtml::link(
                                        $menu[$i]['title'],
                                        //$this->createAbsoluteUrl('/page/' . $menu[$i]['slug'])
                                        $this->createAbsoluteUrl('/' . strtolower($menu[$i]['slug']))
                                        ); ?>
                                </li>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <?php if ($count > 3) : ?>
                            <li class="footerToggle">
                                <div data-uk-dropdown="{pos:'top-left'}">
                                    <div><i class="uk-icon-toggle-up uk-icon-small"></i></div>
                                    <div class="uk-dropdown">
                                        <ul>
                                            <?php for ($i = 0; $i < $count; $i++): ?>
                                                <?php if ($i > 2): ?>
                                                    <li>
<!--                                                        <a href="--><?//= $this->createAbsoluteUrl('/page/' . $menu[$i]['slug']) ?><!--">--><?//= $menu[$i]['title'] ?><!--</a>-->
                                                            <a href="><?= $this->createAbsoluteUrl('/' . strtolower($menu[$i]['slug'])) ?>"><?= $menu[$i]['title'] ?></a>
                                                    </li><br/>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        <?php endif; ?>
                        <li class="footer-logo">
                            <a href="/"><!-- img
                                    src="<?php echo Yii::app()->request->baseUrl; ?>/uikit/images/logo-black.svg"
                                    alt="logo" --></a>
                        </li>
                        <li>
                            <?php echo CHtml::link(
                                '<i class="uk-icon-pinterest"></i>',
                                Yii::app()->params['misc']['pinterest_url'],
                                array('class' => 'footer-social')); ?>
                        </li>
<!--                        <li>
                            <?php /*echo CHtml::link(
                                '<i class="uk-icon-twitter"></i>',
                                Yii::app()->params['misc']['twitter_url'],
                                array('class' => 'footer-social'));*/ ?>
                        </li>-->
                        <li>
                            <?php echo CHtml::link(
                                '<i class="uk-icon-instagram"></i>',
                                Yii::app()->params['misc']['instagram_url'],
                                array('class' => 'footer-social')); ?>
                        </li>
                    </ul>
                </div>
                <div>
                    <ul class="footer-list footer-list-small">
                        <?php foreach (UtilsHelper::getLeftFooterLinks(Yii::app()->getLanguage()) as $title => $slug) : ?>
                            <li>
                                <?php echo CHtml::link(
                                    $title,
//                                    $this->createAbsoluteUrl('/page/' . $slug)
                                    $this->createAbsoluteUrl('/' . strtolower($slug))
                                ); ?>
                            </li>
                        <?php endforeach; ?>
                        <li class="footer-copyright">
                            <span>&#169; <?php echo date('Y'); ?></span>
                            <span><a href="/"><?php echo Yii::app()->name; ?></a></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--END FOOTER-->

    <?php $this->widget('ext.googleAnalytics.EGoogleAnalyticsWidget',
        array('account' => Yii::app()->params['seo']['google_analytics_account'], 'domainName' => 'n2315.com')
    ); ?>

</div>
<!--END WRAPPER-->

<!--MOBILE START DIALOG-->
<!-- <div id="mobile-start-dlg">
    <div>
        <?=CHtml::link('register', '', array('class' => 'uk-button register-link'))?>
        <?=CHtml::link('login', '', array('class' => 'uk-button login-link'))?>
        <?=CHtml::link('shop', '/shop', array('class' => 'uk-button btn-inverse'))?>
        <?=CHtml::link('sell', '/sell-online', array('class' => 'uk-button btn-inverse'))?>
    </div>
    <a href="#mobile-start-dlg"></a>
</div> -->
<!--END MOBILE START DIALOG-->

<!--LOGIN WINDOW-->
<div id="login_content" class="mod-window-wrapper" data-uk-observe></div>
<!--END LOGIN WINDOW-->

<!--FORGOT PASSWORD WINDOW-->
<div id="forgot_pass_content" class="mod-window-wrapper"></div>
<!--END FORGOT PASSWORD WINDOW-->

<!--Глобальные параметры-->
<script>
    var globals = {
        'url'        : '<?=Yii::app()->request->baseUrl?>',
        'lang'       : '<?=Yii::app()->getLanguage()?>',
        'facebook_id': '<?=Yii::app()->params['misc']['facebook_id']?>',
        'imgmw'      : 270,
        'imgmh'      : 340,
        'imgbc'      : '#fff'
    };
</script>

<script src="<?=Yii::app()->request->baseUrl ?>/js/search.js"></script>
<!--jquery.cookie-->
<script src="<?=Yii::app()->request->baseUrl?>/js/jquery/jquery.cookie.js"></script>
<!--leanModal-->
<script src="<?=Yii::app()->request->baseUrl ?>/js/jquery/jquery.leanModal.min.js"></script>
<!--scrollbar-->
<script src="<?=Yii::app()->request->baseUrl ?>/js/jquery/jquery.scrollbar.min.js"></script>
<!--Интеграция с социальными сетями-->
<script src="<?=Yii::app()->request->baseUrl ?>/js/share.js"></script>

<script src="<?=Yii::app()->request->baseUrl?>/uikit/js/uikit.min.js"></script>
<script src="<?=Yii::app()->request->baseUrl?>/uikit/js/assets.min.js<?php echo $noCacheParameter; ?>"></script>
<script src="<?=Yii::app()->request->baseUrl?>/uikit/js/login.js<?php echo $noCacheParameter; ?>"></script>
<script src="<?=Yii::app()->request->baseUrl?>/uikit/js/category.js<?php echo $noCacheParameter; ?>"></script>
<script src="<?=Yii::app()->request->baseUrl?>/js/common.js<?php echo $noCacheParameter; ?>"></script>
<script src="<?=Yii::app()->request->baseUrl?>/js/jquery/jquery-ui.min.js"></script>
<script src="<?=Yii::app()->request->baseUrl?>/js/eternalSession.js<?php echo $noCacheParameter; ?>"></script>
<script src="<?=Yii::app()->request->baseUrl?>/js/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.js"></script>


<script>
    var options = {
        list: {
            maxNumberOfElements: 20
            
        },
        
        categories: [
            {
                listLocation: "product",
                header: "PRODUCTS",
                maxNumberOfElements: 8,
            },
            {
                listLocation: "brand",
                header: "DESIGNERS",
                maxNumberOfElements: 4,
            },
            {
                listLocation: "category",
                header: "CATEGORIES",
                maxNumberOfElements: 4,
            } 
        ],

        
        url: function(phrase) {
            return "/site/ajaxSearch";
        },

        getValue: function(element) {
            return element.title;
        },

        ajaxSettings: {
            dataType: "json",
            method: "POST",
            data: {
                dataType: "json"
            }
        },
        
        minCharNumber: 3,

        preparePostData: function(data) {
            data.phrase = $("#search-text").val();
            return data;
        },
        
        template: {
            type: "links",
            fields: {
                link: "link"
            }
        },

        requestDelay: 400,
        highlightPhrase: false
    };

    $("#search-text").easyAutocomplete(options);
    $("#search-text").on('keypress', function(e) {
        if (e.keyCode == 13 && $(this).val().length > 2) {
            $.ajax({
                type: 'POST',
                data: {query: $.trim($(this).val()).split(' ').join('+')},
                url: globals.url + '/search/get-product',
                success: function (data) {
                    var response = JSON.parse(data);
                    
                    window.location.href = response.link;
                }
            });
        }
    });
</script>

<?php if (empty($_COOKIE['USR_CNT'])): ?>
<!--Геолокация-->
<?php endif; ?>

<!--main.js-->
<script src="<?=Yii::app()->request->baseUrl ?>/js/main.js"></script>
<script type="text/javascript" src="https://s.skimresources.com/js/118861X1578703.skimlinks.js"></script>
</body>
</html>
