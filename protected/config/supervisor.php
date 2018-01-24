<?php return array(
    'configFile' => '/etc/supervisor/conf.d/workers.conf',
    'workersDirectory' => realpath(__DIR__ . '/../../'),
    'restartSleepingTime' => 5,
    /*'all' => [
        'crop_image' => ['numprocs' => 0, 'command' => '/usr/bin/php yii workers/crop-image'],
        'bad_worker' => ['numprocs' => 0, 'command' => '/usr/bin/php yii workers/bad-worker'],
    ],
    'sets' => [
        'general' => [
            'crop_image' => 5,
        ],
        'minimal' => [
            'crop_image' => 50,
            'bad_worker' => 50,
        ],
        'maximal' => [
            'crop_image' => 100,
            'bad_worker' => 100,
        ],
    ],*/
);