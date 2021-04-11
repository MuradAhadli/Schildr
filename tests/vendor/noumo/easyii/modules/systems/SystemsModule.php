<?php
namespace yii\easyii\modules\systems;

class SystemsModule extends \yii\easyii\components\Module
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
            'en' => 'Systems',
            'ru' => 'Systems',
        ],
        'icon' => 'bullhorn',
        'order_num' => 70,
    ];
}