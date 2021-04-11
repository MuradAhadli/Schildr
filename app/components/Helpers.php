<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 6/18/2018
 * Time: 1:09 PM
 */

namespace app\components;

use yii;
use yii\base\Component;

class Helpers extends Component
{
    public static function Month()
    {
        $month = [
            'az' => [
                'long' => [
                    'Yanvar',
                    'Fevral',
                    'Mart',
                    'Aprel',
                    'May',
                    'İyun',
                    'İyul',
                    'Avqust',
                    'Sentyabr',
                    'Oktyabr',
                    'Noyabr',
                    'Dekabr',
                ],
                'short' => [
                    'Yanvar',
                    'Fevral',
                    'Mart',
                    'Aprel',
                    'May',
                    'İyun',
                    'İyul',
                    'Avqust',
                    'Sentyabr',
                    'Oktyabr',
                    'Noyabr',
                    'Dekabr',
                ]
            ],
            'en' => [
                'long' => [
                    'January',
                    'February',
                    'March',
                    'April',
                    'May',
                    'June',
                    'July ',
                    'August',
                    'September',
                    'October',
                    'November',
                    'December',
                ],
                'short' => [
                    'Jan.',
                    'Feb.',
                    'Mar.',
                    'Apr.',
                    'May.',
                    'Jun.',
                    'Jul.',
                    'Aug.',
                    'Sep.',
                    'Oct.',
                    'Nov.',
                    'Dec.'
                ]
            ],
            'ru' => [
                'long' => [
                    'январь',
                    'февраль',
                    'март',
                    'апрель',
                    'май',
                    'июнь',
                    'июль',
                    'август',
                    'сентябрь',
                    'октябрь',
                    'ноябрь',
                    'декабрь',
                ],
                'short' => [
                    'янв.',
                    'февр.',
                    'март',
                    'апр.',
                    'май',
                    'июнь',
                    'июль',
                    'авг.',
                    'сент.',
                    'окт.',
                    'ноябрь',
                    'дек.',
                ]
            ],
        ];

        return $month[yii::$app->language];
    }

    public static function weekDays()
    {
        $week_days = [
            'az' => [
                'long' => [
                    'Bazar ertəsi',
                    'Çərşənbə axşamı',
                    'Çərşənbə',
                    'Cümə axşamı',
                    'Cümə',
                    'Şənbə',
                    'Bazar',
                ],
                'short' => [
                    'B.E.',
                    'Ç.A.',
                    'Ç.',
                    'C.A.',
                    'C.',
                    'Ş.',
                    'B.',
                ],
            ],
            'en' => [
                'long' => [
                    'Monday',
                    'Tuesday',
                    'Wednesday',
                    'Thursday',
                    'Friday',
                    'Saturday',
                    'Sunday',
                ],
                'short' => [
                    'Mon.',
                    'Tue.',
                    'Wed.',
                    'Thu.',
                    'Fri.',
                    'Sat.',
                    'Sun.',
                ],
            ],
            'ru' => [
                'long' => [
                    'понедельник',
                    'вторник',
                    'среда',
                    'четверг',
                    'пятница',
                    'суббота',
                    'воскресенье',
                ],
                'short' => [
                    'Пн.',
                    'Вт.',
                    'Ср.',
                    'Чт.',
                    'Пт.',
                    'Сб.',
                    'Вс.',
                ],
            ],
        ];

        return $week_days[yii::$app->language];
    }

    public static function strToLatin($string)
    {
        $converter = array(
            'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e',
            'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'y', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ь' => '\'', 'ы' => 'y', 'ъ' => '\'',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            'ə' => 'e', 'ı' => 'i', 'ş' => 'sh',
            'ç' => 'ch', 'ü' => 'u', 'ğ' => 'g',
            'ö' => 'o',

            'А' => 'A', 'Б' => 'B', 'В' => 'V',
            'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
            'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
            'И' => 'I', 'Й' => 'Y', 'К' => 'K',
            'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R',
            'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
            'Ь' => '\'', 'Ы' => 'Y', 'Ъ' => '\'',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
            'Ə' => 'E', 'I' => 'I', 'Ş' => 'Sh',
            'Ç' => 'Ch', 'Ü' => 'U', 'Ğ' => 'G',
            'Ö' => 'O', 'İ' => 'I',
        );

        return strtr($string, $converter);
    }

}