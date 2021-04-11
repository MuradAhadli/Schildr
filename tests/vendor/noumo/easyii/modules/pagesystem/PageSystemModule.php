<?php
namespace yii\easyii\modules\pagesystem;

class PageSystemModule extends \yii\easyii\components\Module
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
            'en' => 'PageSystem',
            'ru' => 'PageSystem',
        ],
        'icon' => 'bullhorn',
        'order_num' => 70,
    ];
}