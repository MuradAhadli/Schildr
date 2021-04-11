<?php
namespace yii\easyii\modules\clients;

class ClientsModule extends \yii\easyii\components\Module
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
            'en' => 'Clients',
            'ru' => 'Clients',
        ],
        'icon' => 'bullhorn',
        'order_num' => 70,
    ];
}