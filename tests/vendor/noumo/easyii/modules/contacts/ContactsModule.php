<?php
namespace yii\easyii\modules\contacts;

class ContactsModule extends \yii\easyii\components\Module
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
            'en' => 'Contacts',
            'ru' => 'Новости',
        ],
        'icon' => 'bullhorn',
        'order_num' => 70,
    ];
}