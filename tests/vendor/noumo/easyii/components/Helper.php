<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 3/7/2018
 * Time: 12:20 PM
 */

namespace yii\easyii\components;


use yii\helpers\VarDumper;

class Helper
{
    public static function getWeekDays()
    {
        $timestamp = strtotime('next Monday');

        for ($i = 1; $i < 8; $i++) {

            $days[$i] = utf8_encode(strftime('%A', $timestamp));

            $timestamp = strtotime('+1 day', $timestamp);
        }
        return $days;
    }

    /**
     * @param int $day
     */
    public static function weekDayName(int $day)
    {
        return  strftime('%A', strtotime("Sunday + $day Days"));
    }
}