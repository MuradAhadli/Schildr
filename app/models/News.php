<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/3/2018
 * Time: 11:30 AM
 */

namespace app\models;

use yii;
use yii\helpers\VarDumper;

class News extends yii\easyii\modules\news\models\News
{
    public function rules()
    {
        return [];
    }

    public static function getNews(){
        return parent::find()
                ->select('
                    nl.short,
                    nl.slug,
                    easyii_news.id,
                    easyii_news.time,
                ')
                ->leftJoin('easyii_news_lang nl','nl.news_id = easyii_news.id')
                ->where([
                    'status' => 1,
                    'language' => yii::$app->language
                ])
                ->orderBy('time DESC')
                ->limit(3)
                ->asArray()
                ->all();
    }

    public static function getNewsIn($id = '', $slug = '')
    {
        return self::find()
            ->select('
                n.id,
                n.image,
                n.time,
                nl.news_id,
                nl.title,
                nl.short,
                nl.text,
                nl.slug
            ')
            ->from('easyii_news n')
            ->leftJoin('easyii_news_lang nl', 'nl.news_id = n.id')
            ->where([
                'status' => 1,
                'n.id' => $id,
                'nl.slug' => $slug,
                'language' => yii::$app->language
            ])
            ->asArray()
            ->one();
    }

    public static function getOtherNews($id = '')
    {
        return self::find()
            ->select('
                n.id,
                n.image,
                n.time,
                nl.news_id,
                nl.title,
                nl.short,
                nl.slug
            ')
            ->from('easyii_news n')
            ->leftJoin('easyii_news_lang nl', 'nl.news_id = n.id')
            ->where([
                'status' => 1,
                'language' => yii::$app->language
            ])
            ->andWhere(['!=', 'n.id', $id])
            ->limit(5)
            ->orderBy('time DESC')
            ->asArray()
            ->all();
    }
}