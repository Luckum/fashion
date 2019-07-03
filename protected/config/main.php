<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// PayPal.
require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' .
                       DIRECTORY_SEPARATOR . 'components' .
                       DIRECTORY_SEPARATOR . 'paypal' .
                       DIRECTORY_SEPARATOR . 'autoload.php');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$params = array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    // preloading 'log' component
    'preload'=>array('log'),

    'sourceLanguage' => '00', // ----- use values from protected/messages/.. instead keys in all cases
    'language' => 'en',

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.auth.*',
        'application.components.controllers.*',
        'application.components.quickbooks.*',
        'application.components.*',
        'application.helpers.*',
        'application.widgets.*',
        'ext.YiiMailer.YiiMailer',
        'ext.shoppingCart.*',
        'application.extensions.CAdvancedArBehavior'
    ),

    'modules'=>array(
        // uncomment the following to enable the Gii tool
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'rootpwd',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.*','::1'),
        ),

    ),
    // application components
    'components'=>array(
        'clientScript'=>array(
            'scriptMap'=>array(
                'jquery.js'=>false,
            )
        ),
        'member'=>array(
            'class'=>'WebClient',
            'allowAutoLogin'=>true,
        ),
        'admin'=>array(
            'class'=>'WebAdmin',
            'allowAutoLogin'=>true,
        ),
        // uncomment the following to enable URLs in path-format

        'urlManager'=>array(
            'class'=>'UrlManager',
            'urlFormat'=>'path',
            'showScriptName'=>false,
            'rules'=>array(
                
                '/sell-online'=>'members/profile/sell',

                array(
                    'class' => 'application.components.ShopUrlRule',
                    'connectionID' => 'db',
                ),

                '/page/<page:[\w-_]+>' => 'site/static/page/<page>',

                '/mobile-search' => 'site/mobileSearch',
                '/search/results' => 'members/search/results',

                '/blog' => 'members/blog/index',
                '/blog/post/<id:\d+>' => 'members/blog/post',

                '/eternal' => 'members/auth/eternal',
                '<language:\w{2}>/eternal' => 'members/auth/eternal',

                '/filter/*' => 'members/shop/filter',
                '<language:\w{2}>/filter/*' => 'members/shop/filter',

                '/about'=>'site/static/page/about',
                '<language:\w{2}>/about'=>'site/static/page/about',

                '/cart'=>'members/shop/cart',
                '<language:\w{2}>/cart'=>'members/shop/cart',

                '<language:\w{2}>/sell-online'=>'members/profile/sell',

                '/my-account'=>'members/profile/index',

                '/profile-<id:\d+>'=>'members/profile/showProfile',
                '/my-account/<action:\w+>'=>'members/profile/<action>',

                '/my-account/<action:\w+>/<id:\d+>'=>'members/profile/<action>',

                '/profile-<id:\d+>/<action:\w+>'=>'members/profile/<action>',

                '<language:\w{2}>/profile-<id:\d+>'=>'members/profile/showProfile',

                'designers/<category:.+>'=>'members/shop/showCategory',
                'designers/<brand:.+>/<category:.+>/<subcategory:.+>'=>'members/shop/showCategory',

                'shop/<category:\w+>/<subcategory:.+>/<id:.+>'=>'members/shop/productDetails',

                '/product/<category:\w+>/<subcategory:.+>/<id:.+>'=>'members/shop/productDetails',

                '/control'=>'control/index/index',
                '/control/<controller:\w+>'=>'control/<controller>/index',
                '/control/<controller:\w+>/<action:\w+>/<id:\d+>'=>'control/<controller>/<action>',
                '/control/<controller:\w+>/<action:\w+>'=>'control/<controller>/<action>',
                '/control/settings/<controller:\w+>/<action:\w+>'=>'control/settings/<controller>/<action>',
                
                '/members/<controller:[\w\-]+>'=>'members/<controller>/index',
                '/members/<controller:[\w\-]+>/<action:[\w\-]+>/<id:\d+>'=>'members/<controller>/<action>',
                '/members/<controller:[\w\-]+>/<action:[\w\-]+>'=>'members/<controller>/<action>',
                
                '/site/<action:[\w\-]+>' => 'site/<action>',
                
                '<category:\w+>/<subcategory:.+>/designers/<brand:.+>'=>'members/shop/showCategory',
                '<category:\w+>/<id:.+>'=>'members/shop/productDetails',
                '<category:\w+>/<subcategory:.+>/<id:.+>'=>'members/shop/productDetails',
                '<category:\w+>'=>'members/shop/showCategory',
                '<category:\w+>/<subcategory:.+>'=>'members/shop/showCategory',
                
                
                
                'shop/<category:\w+>/<subcategory:.+>'=>'members/shop/showCategory',
                'shop/' => 'members/shop/showCategory',

                '<language:\w{2}>shop/category/<category:.+>'=>'members/shop/showCategory',
                'shop/category/<category:.+>'=>'members/shop/showCategory',

                '/parent/<category:\w+>'=>'members/shop/showCategory',
                '<language:\w{2}>/parent/<category:\w+>'=>'members/shop/showCategory',

                '/'=>'members/index/index',
                '<language:\w{2}>/'=>'members/index/index',

                '<language:\w{2}>/<modules:\w+>'=>'<modules>/index/index',
                '<modules:\w+>'=>'<modules>/index/index',

                '<language:\w{2}>/<modules:\w+>/<controller:\w+>'=>'<modules>/<controller>/index',
                '<modules:\w+>/<controller:\w+>'=>'<modules>/<controller>/index',

                '<language:\w{2}>/<modules:\w+>/shop/<action:cart|order>'=>'<modules>/shop/<action>',
                '<modules:\w+>/shop/<action:cart|order>'=>'<modules>/shop/<action>',

                '<language:\w{2}>/<modules:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<modules>/<controller>/<action>',
                '<modules:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<modules>/<controller>/<action>',

                '<language:\w{2}>/<modules:\w+>/<controller:\w+>/<action:\w+>'=>'<modules>/<controller>/<action>',
                '<modules:\w+>/<controller:\w+>/<action:\w+>'=>'<modules>/<controller>/<action>',

                '<language:\w{2}>/<modules:\w+>/shop/<category:[\w_\/-]+>/<action:\w+>/<id:\d+>'=>'<modules>/shop/<action>',
                '<modules:\w+>/shop/<category:[\w_\/-]+>/<action:\w+>/<id:\d+>'=>'<modules>/shop/<action>',

                '<language:\w{2}>/<modules:\w+>/shop/<category:[\w_\/-]+>'=>'<modules>/shop/showCategory',
                '<modules:\w+>/shop/<category:[\w_\/-]+>'=>'<modules>/shop/showCategory',

                '<language:\w{2}>/<modules:\w+>/shop'=>'<modules>/shop/index',
                '<modules:\w+>/shop'=>'<modules>/shop/index',

                '/<language:\w{2}>/my-account/alertsUpdate/alert_id/<alert_id:\d+>' => 'members/profile/alertsUpdate',
                '/my-account/alertsUpdate/alert_id/<alert_id:\d+>' => 'members/profile/alertsUpdate',
            ),
        ),
        // uncomment the following to use a MySQL database

        'db'=>require(dirname(__FILE__) . '/db.php'),

        'errorHandler'=>array(
            // use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning, info',
                ),
            ),
        ),
        'image'=>array(
            'class'=>'application.extensions.image.CImageComponent',
            // GD or ImageMagick
            'driver'=>'GD',
            // ImageMagick setup path
            'params'=>array('directory'=>'/opt/local/bin'),
        ),
        'mailer' => array(
            'class' => 'application.extensions.mailer.EMailer',
        ),
        'shoppingCart' => array(
            'class' => 'ext.shoppingCart.EShoppingCart',
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>require(dirname(__FILE__) . '/params.php'),
);

if (defined("PAYPAL_SANDBOX") && PAYPAL_SANDBOX) {
    $params['params']['paypal'] = array (
      'user_id' => 'sam9898_api1.mail.ru',
      'signature' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AlV23A9IFssmxUvpApxdcCDnFOHV',
      'password' => 'K8J9WNP7S8K3Z7YT',
      'app_id' => 'APP-80W284485P519543T',
      'email' => 'sam9898@mail.ru',
    );
    $params['params']['payment']['paypal_webscr_url'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    $params['params']['payment']['paypal_svcs_url'] = 'https://svcs.sandbox.paypal.com/AdaptivePayments/Pay';
    $params['params']['payment']['paypal_ap-payment_url'] = 'https://www.sandbox.paypal.com/webscr?cmd=_ap-payment&paykey=';
}

return $params;