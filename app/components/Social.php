<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/16/2018
 * Time: 12:25 PM
 */

namespace app\components;

use yii\helpers\VarDumper;

class Social
{
    public static function getBrands()
    {
        return [
            'facebook' => [
                'color' => '3b5998',
                'icon' => '<i class="fab fa-facebook-f"></i>',
            ],
            'instagram' => [
                'color' => 'c13584',
                'icon' => '<i class="fab fa-instagram"></i>',
            ],
            'twitter' => [
                'color' => '1da1f2',
                'icon' => '<i class="fab fa-twitter"></i>',
            ],
            'linkedin' => [
                'color' => '0077b5',
                'icon' => '<i class="fab fa-linkedin-in"></i>',
            ],
            'skype' => [
                'color' => '00aff0',
                'icon' => '<i class="fab fa-skype"></i>',
            ],
            'youtube' => [
                'color' => 'ff0000',
                'icon' => '<i class="fab fa-youtube"></i>',
            ],
        ];
    }

    public static function parseSocialLinks($array)
    {
        if(!is_array($array))
            return [];

        $brands = self::getBrands();

        $social = [];

        foreach ($array as $k => $v) {

            $host = parse_url($v, PHP_URL_HOST);

            $host = str_replace(['www.', '.com'], '', $host);

            if(isset($brands[$host])) {

                $social[] = array_merge($brands[$host], ['url' => $v]);
            }
        }

        return $social;
    }
}