<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/3/2018
 * Time: 5:47 PM
 */

namespace app\models;

use yii;

class Cover extends \yii\easyii\models\Cover
{
    public function rules()
    {
        return [];
    }

    public static function getCovers($page_id, $title)
    {
        $carousel = parent::find()
            ->select('
                easyii_covers.id, 
                easyii_covers.image, 
                easyii_cover_lang.language,
                easyii_cover_lang.title,
            ')
            ->leftJoin('easyii_cover_lang', 'easyii_cover_lang.cover_id = easyii_covers.id')
            ->where([
                'language' => yii::$app->language,
                'item_id' => $page_id
            ])
            ->asArray()
            ->all();

        if($carousel) {
            return $carousel;
        }

        $carousel[] = [
            'image' => '/app/media/img/slider1.png',
            'title' => $title,
        ];

        return $carousel;
    }

    public static function defaultCovers($title)
    {
        $carousel[] = [
            'image' => '/app/media/img/slider1.png',
            'title' => $title,
        ];

        return $carousel;
    }
}