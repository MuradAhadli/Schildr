<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 3/31/2018
 * Time: 10:44 AM
 */

namespace yii\easyii\models;

use yii;
use yii\easyii\modules\contacts\models\Contacts;
use yii\helpers\Html;

abstract class Constants
{
    const STATUS_ON = 1;
    const STATUS_OFF = 0;

    public static function getNavLangs()
    {
        return [
            'az' => 'az',
            'en' => 'en',
            'ru' => 'ru',
        ];
    }

    public static function getGender()
    {
        return [
            User::GENDER_MALE => Html::encode(yii::t('db', 'Male')),
            User::GENDER_FEMALE => Html::encode(yii::t('db', 'Female')),
        ];
    }

    public static function getContactsTypes()
    {
        return [
            Contacts::TYPE_ADDRESS => yii::t('db', 'address'),
            Contacts::TYPE_PHONE => yii::t('db', 'phone'),
            Contacts::TYPE_MOBILE => yii::t('db', 'mobile'),
            Contacts::TYPE_EMAIL => yii::t('db', 'email'),
        ];
    }
}