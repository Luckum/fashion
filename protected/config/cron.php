<?php

return array(
    // This path may be different. You can probably get it from `config/main.php`.
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Cron',

    'preload'=>array('log'),

    'import'=>array(
        'application.components.*',
        'application.models.*',
        'application.helpers.*',
        'ext.shoppingCart.*',
        'application.helpers.LogHelper',
        'application.helpers.EmailHelper',
        'application.extensions.sftp.*',
    ),
    // We'll log cron messages to the separate files
    'components'=>array(
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'logFile'=>'cron.log',
                    'levels'=>'error, warning',
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'logFile'=>'cron_trace.log',
                    'levels'=>'trace',
                ),
            ),
        ),
        'mailer' => array(
            'class' => 'application.extensions.mailer.EMailer',
        ),
        
        'sftp' => array(
            'class' => 'SftpComponent',
            'host' => '127.0.0.1',
            'port' => 22,
            'username' => 'test',
            'password' => 'test.1',
        ),

        // Your DB connection
        'db'=>require(dirname(__FILE__) . '/db.php'),
    ),
    'params'=>require(dirname(__FILE__) . '/params.php'),
);