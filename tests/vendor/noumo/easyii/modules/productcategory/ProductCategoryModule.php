<?php

namespace yii\easyii\modules\productcategory;

class ProductCategoryModule extends \yii\easyii\components\Module
{
    public $settings = [
        'enableTitle' => true,
        'enableText' => true,
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'Product category',
            'ru' => 'Product category',
        ],
        'icon' => 'picture',
        'order_num' => 40,
    ];
}