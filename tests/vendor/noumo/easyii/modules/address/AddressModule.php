<?php
namespace yii\easyii\modules\address;

class AddressModule extends \yii\easyii\components\Module
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
            'en' => 'Address',
            'ru' => 'Address',
        ],
        'icon' => 'bullhorn',
        'order_num' => 70,
    ];
}