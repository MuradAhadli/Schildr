<?php
$params = require(__DIR__ . '/params.php');

$basePath = dirname(__DIR__);
$webroot = dirname($basePath);

Yii::setAlias('@uploads', $webroot . DIRECTORY_SEPARATOR . 'uploads');

$config = [
    'id' => 'app',
    'name' => 'Glass Construction',
    'basePath' => $basePath,
    'bootstrap' => ['log'],
    'language' => 'en',
    'runtimePath' => $webroot . '/runtime',
    'vendorPath' => $webroot . '/vendor',
    'on beforeAction' => function ($event) {
        \app\components\Init::init($event);
    },
    'components' => [

        'view' => [
            'class' => '\rmrevin\yii\minify\View',
            'enableMinify' => !YII_DEBUG,
            'concatCss' => true, // concatenate css
            'minifyCss' => true, // minificate css
            'concatJs' => true, // concatenate js
            'minifyJs' => true, // minificate js
            'minifyOutput' => true, // minificate result html page
            'webPath' => '@web', // path alias to web base
            'basePath' => '@webroot', // path alias to web base
            'minifyPath' => '@webroot/minify', // path alias to save minify result
            'jsPosition' => [\yii\web\View::POS_END], // positions of js files to be minified
            'forceCharset' => 'UTF-8', // charset forcibly assign, otherwise will use all of the files found charset
            'expandImports' => true, // whether to change @import on content
            'compressOptions' => ['extra' => true], // options for compress
//            'cache' => true,
        ],

        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => '6Lf1yV0UAAAAAK7MeKG_F6WHqWM4u1i2NJO83scR',
            'secret' => '6Lf1yV0UAAAAAMXJXg4fT92FK8OhD4lBKSNmzxUW',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'h3t8JfUCNQ_eCCSJErtji6P7UTATWjWN',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
//            'viewPath' => '@app/mail',
//            'transport' => [
//                'class' => 'Swift_SmtpTransport',
//                'host' => 'smtp.gmail.com',
//                'username' => 'schildrmailer@gmail.com',
//                'password' => 'schildr123',
//                'port' => '587',
//                'encryption' => 'tls',
//                ]
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'class' => 'yii\web\AssetManager',
            'forceCopy' => true,
            'bundles' => [
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 3,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = [
//        'class' => 'yii\debug\Module',
//        'allowedIPs' => ['']
//    ];
//
//    $config['bootstrap'][] = 'gii';
//    $config['modules']['gii'] = 'yii\gii\Module';
//
//    $config['components']['db']['enableSchemaCache'] = false;

//    $config['modules']['debug'] = 'yii\debug\Module';
}

return array_merge_recursive($config, require(dirname(__FILE__) . '/../../vendor/noumo/easyii/config/easyii.php'));
