<?php

return [
    'language' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
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
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{%auth_items}}',
            'itemChildTable' => '{{%auth_item_children}}',
            'assignmentTable' => '{{%auth_assignments}}',
            'ruleTable' => '{{%auth_rules}}',
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
                    'clientId' => '460552206737-3l609bqkkil7n3t9c8r992q7b5es15g4.apps.googleusercontent.com',
                    'clientSecret' => 'LcABQes7j3YuhxeR0Mo80GKV',
                ],
                'vkontakte' => [
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => '7422954',
                    'clientSecret' => 'ksgOuPFuiTL3Bdt96jud',
                ],
                'yandex' => [
                    'class' => 'yii\authclient\clients\Yandex',
                    'clientId' => 'e9c758f4edc44d2d8dc28bd3936382c8',
                    'clientSecret' => 'e67e85182fa04a3fbdef091ad6fe3cb0',
                ],
            ],
        ],
    ],
];
