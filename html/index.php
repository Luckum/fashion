<?php

error_reporting(0);

// change the following paths if necessary
$yii=dirname(__FILE__).'/../framework/yii.php';
$config=dirname(__FILE__).'/../protected/config/website.php';

define('PAYPAL_SANDBOX', false);

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
$app = Yii::createWebApplication($config);
Yii::setPathOfAlias('webroot', dirname($_SERVER['SCRIPT_FILENAME']));
$app->run();
