<?php

namespace yii\easyii\modules\product;

class ProductModule extends \yii\easyii\components\Module
{
    public $settings = [
        'enableTitle' => true,
        'enableText' => true,
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'Product',
            'ru' => 'Product',
        ],
        'icon' => 'picture',
        'order_num' => 40,
    ];
}