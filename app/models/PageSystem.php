<?php
namespace app\models;

use yii;
use yii\data\Sort;

class PageSystem extends \yii\easyii\modules\pagesystem\models\PageSystem
{

    public static function tableName()
    {
        return "easyii_page_system";
    }

    public function rules()
    {
        return [];
    }

    public static function getAllPageSystemPageSystems()
    {

        $sort = new Sort([
            'attributes' => [
                'age',
                'name' => [
                    'asc' => ['order' => SORT_ASC],
                    'desc' => ['order' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Name',
                ],
            ],
        ]);

        return parent::find()
            ->select([
                'easyii_page_system.youtube_embed',
                'easyii_page_system_lang.title',
                'easyii_page_system_lang.text',
                'easyii_page_system.file',
            ])
            ->where([
                'language' => yii::$app->language,
                'status' => 1
            ])
            ->leftJoin('easyii_page_system_lang','easyii_page_system.id = easyii_page_system_lang.page_system_id')
            ->asArray()
            ->all();

    }
}