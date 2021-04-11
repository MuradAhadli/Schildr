<?php
/**
 * Created by PhpStorm.
 * User: Qulam
 * Date: 4/3/2018
 * Time: 3:58 PM
 */

namespace app\models;

use yii;

class PageBlock extends \yii\easyii\modules\pageblock\models\PageBlock
{

    public function rules()
    {
        return [];
    }

    public static function getAllPageBlock()
    {
        return parent::getAllPageBlock();
    }

    public static function getAllBlock()
    {
        $blocks = parent::find()
            ->select([
                'easyii_page_block_lang.title as page_block_title',
                'easyii_page_block_child.image',
                'easyii_page_block_child.target',
                'easyii_page_block_child.url',
                'easyii_page_block_child_lang.title',
                'easyii_page_block_child_lang.short',
                'easyii_page_block_child_lang.description',
            ])
            ->leftJoin('easyii_page_block_lang', 'easyii_page_block.id = easyii_page_block_lang.page_block_id')
            ->leftJoin('easyii_page_block_child', 'easyii_page_block.id = easyii_page_block_child.page_block_id')
            ->leftJoin('easyii_page_block_child_lang', 'easyii_page_block_child.id = easyii_page_block_child_lang.page_block_child_id')
            ->where([
                'easyii_page_block_child_lang.language' => yii::$app->language,
                'easyii_page_block_lang.language' => yii::$app->language,

            ])
            ->asArray()
            ->all();

        $Arr = [];

        foreach ($blocks as $key => $val) {

            foreach ($blocks as $k => $item) {
                if ($val['page_block_title'] == $item['page_block_title']) {
                    $Arr[$val['page_block_title']][$k] = $item;
                }
            }
        }

        return $Arr;

    }
}