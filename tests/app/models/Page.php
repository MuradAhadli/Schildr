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

class Page extends \yii\easyii\modules\page\models\Page
{
    public function rules()
    {
        return [];
    }

    public static function getNav()
    {
        $x = parent::find()
            ->select('
                easyii_pages.id, 
                easyii_pages.parent_id,  
                easyii_pages.external_link, 
                easyii_pages_lang.title,
                easyii_pages_lang.slug
            ')
            ->leftJoin('easyii_pages_lang', 'easyii_pages_lang.page_id = easyii_pages.id')
            ->where([
                'status' => 1,
                'language' => yii::$app->language
            ])
            ->orderBy('order_num DESC')
            ->asArray()
            ->all();

        $nav = [];

        foreach ($x as $k => $v) {
            $nav[$v['parent_id']][] = $v;
        }

        return $nav;
    }

    public static function getParentNav($page_slug = null)
    {
        $condition = '';
        if($page_slug != null){
            $condition = [
                'slug' => $page_slug
            ];
        }


        $reason = parent::find()
            ->select('
                easyii_pages.id, 
                easyii_pages.parent_id, 
                easyii_pages.module_class, 
                easyii_pages_lang.title,
                easyii_pages_lang.short,
                easyii_pages_lang.text,
                easyii_pages_lang.slug
            ')
            ->leftJoin('easyii_pages_lang', 'easyii_pages_lang.page_id = easyii_pages.id')
            ->where([
                'status' => 1,
                'parent_id' => 0,
                'language' => yii::$app->language
            ])
            ->andWhere($condition)
            ->orderBy('order_num DESC')
            ->asArray();

        if($condition != null){
            return $reason->one();
        }

        return $reason->all();
    }

    public static function getSection()
    {
        return parent::find()
            ->select('
                easyii_pages.id,
                easyii_pages.image, 
                easyii_pages.module_class, 
                easyii_pages_lang.title,
                easyii_pages_lang.short,
                easyii_pages_lang.slug,
                easyii_pages_lang.text
            ')
            ->leftJoin('easyii_pages_lang', 'easyii_pages_lang.page_id = easyii_pages.id')
            ->where([
                'section' => 1,
                'language' => yii::$app->language
            ])
            ->orderBy('order_num DESC')
            ->limit(4)
            ->asArray()
            ->all();
    }

    public static function findPageBySlug($slug)
    {
        return self::find()
            ->select('
                easyii_pages.id, 
                easyii_pages.parent_id, 
                pl.language, 
                pl.title, 
                pl.short, 
            ')
            ->where([
                'easyii_pages.status' => 1,
                'pl.slug' => yii::$app->request->get('page_slug')
            ])
            ->leftJoin('easyii_pages_lang pl', 'pl.page_id = easyii_pages.id')
            ->asArray()
            ->one();
    }

    public static function findPageById($id, $lang)
    {
        return self::find()
            ->select('
                    easyii_pages.id, 
                    pl.slug
                ')
            ->where([
                'easyii_pages.id' => $id,
                'pl.language' => $lang
            ])
            ->leftJoin('easyii_pages_lang pl', 'pl.page_id = easyii_pages.id')
            ->asArray()
            ->one();
    }

    public static function findParent($parent_id, $lang)
    {
        return self::find()
            ->select('easyii_pages_lang.title')
            ->where([
                'easyii_pages.id' => $parent_id,
                'language' => $lang
            ])
            ->leftJoin('easyii_pages_lang', 'easyii_pages_lang.page_id = easyii_pages.id')
            ->asArray()
            ->one();
    }

    public static function getPages()
    {
        return parent::find()
            ->select('
            easyii_pages_lang.title,
            easyii_pages_lang.text,
            ')
            ->where([
                'status' => 1,
                'title' => 'product'
            ])
            ->limit(1)
            ->leftJoin('easyii_pages_lang','easyii_pages_lang.page_id = easyii_pages.id')
            ->asArray()
            ->all();
    }


}