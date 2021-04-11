<?php
namespace yii\easyii\modules\mailaddresses;

use Yii;

class MailAddressesModule extends \yii\easyii\components\Module
{
    public static $installConfig = [
        'title' => [
            'en' => 'Mail addresses',
            'ru' => 'Mail addresses',
        ],
        'icon' => 'mail',
        'order_num' => 45,
    ];
}