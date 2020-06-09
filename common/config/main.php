<?php

return [
    'language' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@backendHost' => $params['backendHostInfo'],
        '@frontendHost' => $params['frontendHostInfo'],
    ],
    'bootstrap' => [
        'common\bootstrap\SetUp'
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',


    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache',
        ],
        'telegram' => [
            'class' => 'aki\telegram\Telegram',
            'botToken' => '1108058298:AAFXEmclOx6MduA_pCXPOYVwNUPFVRT8Knc',
            ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => 'google_client_id',
                    'clientSecret' => 'google_client_secret',
                ],
                'vkontakte' => [
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => '7422954',
                    'clientSecret' => 'ksgOuPFuiTL3Bdt96jud',
                ],

            ],
        ],

    ],
];
