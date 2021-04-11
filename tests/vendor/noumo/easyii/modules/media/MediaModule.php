<?php
namespace yii\easyii\modules\media;

class MediaModule extends \yii\easyii\components\Module
{
    public $settings = [
        'enableTitle' => true,
        'enableText' => true,
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'Media',
            'ru' => 'Карусель',
        ],
        'icon' => 'picture',
        'order_num' => 40,
    ];

    public static $app_route = '/media/photo';
}