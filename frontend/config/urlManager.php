<?php
return [
    'class' => 'yii\web\UrlManager',
    'hostInfo' => $params['frontendHostInfo'],
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '' => 'site/index',
        'contact' => 'contact/index',
        'signup' => 'auth/signup/index',
        'reset/<_a:[\w-]+>' => 'auth/reset/<_a>',
        '<_a:login|logout>' => 'auth/auth/<_a>',
        '<_a:about>' => 'site/<_a>',
        '<_c:[\w\-]+>' => '<_c>/index',
        '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
        '<_c:[\w\-]+>/<_a:[\w\-]+' => '<_c>/<_a>',
        '<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+' => '<_c>/<_a>',
    ],
];