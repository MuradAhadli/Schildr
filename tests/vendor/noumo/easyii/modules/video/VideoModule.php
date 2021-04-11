<?php
namespace yii\easyii\modules\video;

class VideoModule extends \yii\easyii\components\Module
{
    public $settings = [
        'enableTitle' => true,
        'enableText' => true,
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'Video',
            'ru' => 'Карусель',
        ],
        'icon' => 'picture',
        'order_num' => 40,
    ];

    public static $app_route = '/media/video';
}