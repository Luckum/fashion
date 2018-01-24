<?php
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'preload'=>array('log'),
    'components' => array(
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning, info',
                ),
            ),
        ),
        'mailer' => array(
            'class' => 'application.extensions.mailer.EMailer',
            //'pathViews' => 'application.views.email',
            //'pathLayouts' => 'application.views.email.layouts'
        ),
    ),
    'import'=>array(
        'ext.YiiMailer.YiiMailer',
        'application.components.Mail',
        'application.helpers.LogHelper',
        'application.extensions.mailer.EMailer',
    )
);