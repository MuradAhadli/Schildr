<?php
namespace yii\easyii\modules\pageblockchild;

class PageBlockChildModule extends \yii\easyii\components\Module
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
            'en' => 'PageBlockChild',
            'ru' => 'PageBlockChild',
        ],
        'icon' => 'bullhorn',
        'order_num' => 70,
    ];
}