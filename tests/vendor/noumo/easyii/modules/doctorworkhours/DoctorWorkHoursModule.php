<?php
namespace yii\easyii\modules\doctorworkhours;

class DoctorWorkHoursModule extends \yii\easyii\components\Module
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
}