<?php
return [
   // 'adminEmail' => 'admin@kupi41.ru',
    'user.passwordResetTokenExpire' => 3600,
    'user.rememberMeDuration' => 3600 * 24 * 30,
    'cookieDomain' => '.example.com',
    'frontendHostInfo' => 'http://shop.loc',
    'backendHostInfo' => 'http://dev.shop.loc',
    'staticHostInfo' => 'http://static.shop.loc',
    'staticPath' => dirname(__DIR__, 2) . '/static',
    'mailChimpKey' => '',
    'mailChimpListId' => '',
    'smsRuKey' => '',
    'yandexkassa' => [
        'login' => '586361',
        'test_login' => '570422',

        'password' => 'test_G9hFBE1vNvC2cuHEBtjr_nlwHufM2_QYQWk7uSH34gg',
        'test_password' => 'live_QkybQa8B1pkRaqFfhHrMEGIJbv5nqRi6bU0AO5MCEQU',
        'confirmation' => [
            'type' => 'redirect',
            'return_url' => 'https://kupi41.ru/yandexkassa/responce?id=',
        ],
        'payment_method_data' => [
            'type' => 'bank_card',
        ],
    ],

];
