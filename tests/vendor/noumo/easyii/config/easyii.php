<?php

//Check if page is admin
$bootstrap = (strpos((isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 'admin') !== false) ? ['admin'] : [];

return [
    'modules' => [
        'admin' => [
            'class' => 'yii\easyii\AdminModule',
        ],
    ],
    'components' => [

        'urlManager' => [
            'class' => 'codemix\localeurls\UrlManager',
            // List all supported languages here
            // Make sure, you include your app's default language.
            'enableLanguageDetection' => false,
            'languages' => ['en'],
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'enableDefaultLanguageUrlCode' => true,
            'on languageChanged' => '\app\components\User::onLanguageChanged',
            'rules' => [
                '/' => 'site/index',

                '<page_slug:signup>' => 'user/signup',
                'signup/validate' => 'user/signup-validate',
                '<page_slug:login>' => 'user/login',
                'login-validate' => 'user/login-validate',
                'logout' => 'user/logout',
                'request-password-reset' => 'user/request-password-reset',
                'reset-password' => 'user/reset-password',
                'sms-verification' => 'user/sms-verification',
                'verification-code' => 'user/verification-code',
                'verify-user' => 'user/verify-user',

                '<page_slug:services>' => 'site/services',
                '<page_slug:services>/<id:\d+>/<slug:[\w-]+>' => 'site/service-view',
                '<page_slug:management>' => 'management/index',
                '<page_slug:management>/<id:\d+>/<slug:[\w-]+>' => 'management/view',

                'project/recidental' => 'project/recidental',
                'project/commercial' => 'project/commercial',
                'project/append-ajax' => 'project/append-ajax',
                'product-category/append-category' => 'product-category/append-category',
                'product-category/append-alt-category' => 'product-category/append-alt-category',
                'site/video-helper' => 'site/video-helper',
                '<page_slug:video-helper>' => 'site/video-helper',
//                '<page_slug:product>' => 'product/index',
                '<page_slug:product>' => 'product-category/index',
                '<page_slug:product>/<id:\d+>/<slug:[\w-]+>' => 'product-category/view',
                '<page_slug:product>/<id:\d+>/<slug:[\w-]+>/<key:[\w-]+>' => 'product-category/category-in',
//                '<page_slug:category-in>/<id:\d+>/<slug:[\w-]+>' => 'product-category/category-in',

                '<page_slug:news>/<page:\d+>' => '/news/index',
                '<page_slug:news>' => '/news/index',
                '<page_slug:news>/<id:\d+>/<slug:[\w-]+>' => '/news/view',

                '<page_slug:contact>' => 'site/contact',
                '<page_slug:about-us>' => 'site/about-us',
                '<page_slug:gallery>' => 'gallery/index',
                '<page_slug:e-randevu>/<doctor_id:\d+>/<doctor_slug>' => 'e-services/randevu',
                '<page_slug:e-randevu>' => 'e-services/randevu',
                'randevu/submit' => 'e-services/randevu-submit',
                'e-services' => 'e-services',
                'subscribe' => 'subscribe/index',
                'subscribe/validate' => 'subscribe/validate',
                'subscribe/confirm' => 'subscribe/confirm',
                'subscribe/unsubscribe' => 'subscribe/unsubscribe',

                '<page_slug:departments>/<page:\d+>' => 'departments/index',
                '<page_slug:departments>' => 'departments/index',
                'department/form' => 'departments/form',
                'department/validate' => 'departments/validate',
                '<page_slug:departments>/<id:\d+>/<slug:[\w-]+>' => 'departments/view',

                '<page_slug:doctors>/<page:\d+>' => 'doctors/index',
                '<page_slug:doctors>/<category_id:\d+>-<slug:[\w-]+>' => 'doctors/index',
                '<page_slug:doctors>' => 'doctors/index',
                '<page_slug:doctors>/page-<page:\d+>' => 'doctors/index',
                '<page_slug:doctors>/<id:\d+>/<slug:[\w-]+>' => 'doctors/view',

                '<page_slug:consultation>' => 'consultation/index',
                'consultation/validate' => 'consultation/validate',
                'consultation/answer' => 'consultation/answer',
                'feedback' => 'feedback/index',

                '<page_slug:check-up>' => 'checkup/index',
                'check-up/form' => 'checkup/form',
                '<page_slug:check-up>/<id:\d+>/<slug:[\w-]+>' => 'checkup/view',


                '<page_slug:foto>/<cat_id:\d+>-<cat_slug:[\w-]+>' => 'media/photo',
                '<page_slug:foto>/<page:\d+>' => 'media/photo',
                '<page_slug:foto>' => 'media/photo',

                '<page_slug:video>/<cat_id:\d+>-<cat_slug:[\w-]+>' => 'media/video',
                '<page_slug:video>/<page:\d+>' => 'media/video',
                '<page_slug:video>' => 'media/video',
                '<page_slug:laboratory>' => 'site/laboratory',
                '<page_slug:virtual-tur>' => 'media/360',

                'admin' => 'admin',

                'admin/<controller:\w+>/<action:[\w-]+>' => 'admin/<controller>/<action>',
                'admin/<controller:\w+>/<action:[\w-]+>/<id:\d+>' => 'admin/<controller>/<action>',

                'admin/<module:\w+>' => 'admin/<module>',
                'admin/<module:\w+>/<controller:\w+>/<action:[\w-]+>' => 'admin/<module>/<controller>/<action>',
                'admin/<module:\w+>/<controller:\w+>/<action:[\w-]+>/<id:\d+>' => 'admin/<module>/<controller>/<action>',

                '<page_slug:partners>' => 'site/partners',
                '<page_slug:[\w-]+>' => 'site/page',
            ],
        ],
        'user' => [
            'identityClass' => 'yii\easyii\models\User',
            'enableAutoLogin' => true,
            'authTimeout' => 86400,
        ],
        'i18n' => [
            'translations' => [
                'easyii' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@easyii/messages',
                    'fileMap' => [
                        'easyii' => 'admin.php',
                    ]
                ],
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@app/messages',
                    'fileMap' => [
                        'app' => 'app.php',
                    ]
                ],
                'db' => [
                    'class' => '\yii\i18n\DbMessageSource',
                    'enableCaching' => YII_DEBUG ? false : true,
                    'cachingDuration' => 3600
                ]
            ],
        ],
        'formatter' => [
            'sizeFormatBase' => 1000
        ],
    ],
    'bootstrap' => $bootstrap
];
