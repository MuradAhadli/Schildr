<?php
namespace yii\easyii\modules\appointments;

class AppointmentsModule extends \yii\easyii\components\Module
{
    public $settings = [
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'News',
            'ru' => 'Новости',
        ],
        'icon' => 'bullhorn',
        'order_num' => 70,
    ];

    public static $app_route = '/e-services/randevu';
}