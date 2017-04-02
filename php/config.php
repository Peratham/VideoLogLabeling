<?php

$params = require(__DIR__ . '/params.php');

return [
    'basePath'     => __DIR__,
    'controllerDir'=> 'controller',
    'modelDir'     => 'models',
    'viewDir'      => 'view',
    'name'         => 'NaoTH - VideoLogLabeling',
    'components'   => [
        'user'         => [
            'userClass' => 'app\models\User',
            // default configuration values for user-component:
            // 'loginUrl'  => ['default/login'],
            // 'enableSession' => TRUE,
            // 'enableCookieAutoLogin' => TRUE,
            // 'autoRenewCookie' => TRUE,
        ],
    ],
    'params' => $params,
];