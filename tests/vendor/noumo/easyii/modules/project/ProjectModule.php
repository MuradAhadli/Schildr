<?php
namespace yii\easyii\modules\project;

class ProjectModule extends \yii\easyii\components\Module
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
            'en' => 'Project',
            'ru' => 'Project',
        ],
        'icon' => 'bullhorn',
        'order_num' => 70,
    ];
}