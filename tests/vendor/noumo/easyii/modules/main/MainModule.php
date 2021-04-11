<?php
namespace yii\easyii\modules\main;

class MainModule extends \yii\easyii\components\Module
{
    public $settings = [
        'enableThumb' => true,
        'enablePhotos' => true,
        'enableShort' => true,
        'shortMaxLength' => 256,
        'enableTags' => true
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'PageBlock',
            'ru' => 'PageBlock',
        ],
        'icon' => 'bullhorn',
        'order_num' => 70,
    ];
}