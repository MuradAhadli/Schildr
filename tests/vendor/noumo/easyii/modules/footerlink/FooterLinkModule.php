<?php
namespace yii\easyii\modules\footerlink;

class FooterLinkModule extends \yii\easyii\components\Module
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
            'en' => 'FooterLink',
            'ru' => 'FooterLink',
        ],
        'icon' => 'bullhorn',
        'order_num' => 70,
    ];
}