<?php
namespace yii\easyii\modules\gallerycategory;

class GalleryCategoryModule extends \yii\easyii\components\Module
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
            'en' => 'Examination',
            'ru' => 'Новости',
        ],
        'icon' => 'bullhorn',
        'order_num' => 70,
    ];
}