<?php
// TODO нихрена не работает???
return [
    'language' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'bootstrap' => ['common\bootstrap\SetUp'],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',



   /* 'yandexkassa' => [
        'login' => '570422',
        'password' => 'live_QkybQa8B1pkRaqFfhHrMEGIJbv5nqRi6bU0AO5MCEQU',
        'confirmation' => [
            'type' => 'redirect',
            'return_url' => 'https://kupi41.ru/yandex/finishpay',
        ],
        'payment_method_data' => [
            'type' => 'bank_card',
        ],
    ],*/
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache',
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
