<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 2/12/2018
 * Time: 9:56 AM
 */

namespace app\components;

use yii;

class User
{
    public static function onLanguageChanged($event)
    {

        // $event->language: new language
        // $event->oldLanguage: old language

        yii::$app->session->set('_language', $event->language);
    }

    public static function smsNumber($phone, $prefix = '+994') {

        $arr = explode('-', $phone);

        $arr[0] = ltrim(
            str_replace(
                ['(', ')', ' '],
                '',
                $arr[0]
            ),
            '0'
        );

        $number = implode('', $arr);

        return $prefix.$number;
    }
}