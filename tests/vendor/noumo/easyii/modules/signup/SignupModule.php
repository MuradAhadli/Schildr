<?php
namespace yii\easyii\modules\signup;

use Yii;

class SignupModule extends \yii\easyii\components\Module
{
    public static $installConfig = [
        'title' => [
            'en' => 'Pages',
            'ru' => 'Страницы',
        ],
        'icon' => 'file',
        'order_num' => 50,
    ];

    public static $app_route = '/user/signup';
}