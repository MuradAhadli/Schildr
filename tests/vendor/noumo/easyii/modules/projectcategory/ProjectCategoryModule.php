<?php
namespace yii\easyii\modules\projectcategory;

class ProjectCategoryModule extends \yii\easyii\components\Module
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
            'en' => 'ProjectCategory',
            'ru' => 'ProjectCategory',
        ],
        'icon' => 'bullhorn',
        'order_num' => 70,
    ];
}