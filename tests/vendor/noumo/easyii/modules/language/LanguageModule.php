<?php
namespace yii\easyii\modules\language;

class LanguageModule extends \yii\easyii\components\Module
{
    public static $installConfig = [
        'title' => [
            'en' => 'Language',
            'ru' => 'Language',
        ],
        'icon' => 'font',
        'order_num' => 20,
    ];
}