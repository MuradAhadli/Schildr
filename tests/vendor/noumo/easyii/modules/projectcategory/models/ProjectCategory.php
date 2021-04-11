<?php

namespace yii\easyii\modules\projectcategory\models;

use app\models\ProjectCategoryLang;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\Taggable;
use yii\easyii\models\Photo;
use yii\easyii\modules\projectcategory\models\EasyiiProjectCategory;
use yii\helpers\StringHelper;
use yii\helpers\VarDumper;

class ProjectCategory extends \yii\easyii\components\ActiveRecord
{
    const RECIDENTAL_TYPE = 2;
    const COMMERCIAL_TYPE = 1;

    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const IMAGE_WIDTH = 1250;
    const IMAGE_HEIGHT = 720;

    public static function tableName()
    {
        return 'easyii_project_category';
    }

    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['create_date', 'update_date', 'status'], 'integer'],
            ['create_date', 'default', 'value' => time()],
            ['status', 'default', 'value' => self::STATUS_ON],
        ];
    }

    public function attributeLabels()
    {
        return [];
    }

    public function behaviors()
    {
        return [
            'seoBehavior' => SeoBehavior::className(),
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => yii::$app->params['languages'],
                'requireTranslations' => true,
                'dynamicLangClass' => true,
                'defaultLanguage' => yii::$app->language,
                'langForeignKey' => 'category_id',
                'tableName' => "easyii_project_category_lang",
                'attributes' => [
                    'title', 'description'
                ]
            ],
        ];
    }

    public function getPhotos()
    {
        return $this->hasMany(Photo::className(), ['item_id' => 'id'])->where(['class' => self::className()])->orderBy('order_num DESC');
    }

    public function afterDelete()
    {
        parent::afterDelete();

        foreach ($this->getPhotos()->all() as $photo) {
            $photo->delete();
        }
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    public static function getAllProjectCategory()
    {
        return self::find()
            ->select([
                'easyii_project_category.id',
                'easyii_project_category_lang.title',
            ])
            ->where([
                'language' => yii::$app->language
            ])
            ->leftJoin('easyii_project_category_lang', 'easyii_project_category.id = easyii_project_category_lang.category_id')
            ->asArray()
            ->all();
    }

    public static function getAllCategory()
    {
        return self::find()
            ->select([
                'easyii_project_category.id',
                'easyii_project_category_lang.title',
            ])
            ->where([
                'language' => yii::$app->language
            ])
            ->leftJoin('easyii_project_category_lang', 'easyii_project_category.id = easyii_project_category_lang.category_id')
            ->asArray()
            ->one();
    }


    public static function getCategoryName($id)
    {
        return self::find()
            ->select([
                'easyii_project_category_lang.title'
            ])
            ->leftJoin('easyii_project_category_lang', 'easyii_project_category.id = easyii_project_category_lang.category_id')
            ->where([
                'easyii_project_category.id' => $id,
                'language' => yii::$app->language,
            ])
            ->asArray()
            ->one();
    }


    public static function getAllProjectsByCategory($category_id, $limit = null, $start = null)
    {
        $Arr = [];
        $projects = self::find()
            ->select([
                'easyii_project_category.id as category_id',
                'easyii_project.id',
                'easyii_project.image',
                'easyii_project.logo',
                'easyii_project_lang.title',
                'easyii_project_lang.subtitle',
                'easyii_project_category_lang.title as parent_category_title',
                'easyii_project_category_lang.description as parent_category_description',
            ])
            ->leftJoin('easyii_project_category_lang', 'easyii_project_category.id = easyii_project_category_lang.category_id')
            ->leftJoin('easyii_project', 'easyii_project_category.id = easyii_project.category_id')
            ->leftJoin('easyii_project_lang', 'easyii_project.id = easyii_project_lang.project_id')
            ->where([
                'easyii_project_lang.language' => yii::$app->language,
                'easyii_project_category_lang.language' => yii::$app->language,
            ])
            ->orderBy('easyii_project.id DESC')
            ->asArray()
            ->all();

        foreach ($projects as $key => $val) {
            $index = 1;
            if ($start !== null) {
                foreach ($projects as $k => $item) {

                    if ($item['id'] < $start) {
                        if ($val['category_id'] == $item['category_id'] && $item['category_id'] == $category_id) {
                            $Arr[$val['category_id']][$item['parent_category_title']][$k] = $item;
                            if ($limit !== null && $index == $limit) {

                                return $Arr;
                            }
                            $index++;
                        }
                    }
                }
            } else {
                foreach ($projects as $k => $item) {
                    if ($val['category_id'] == $item['category_id'] && $item['category_id'] == $category_id) {
                        $Arr[$val['category_id']][$item['parent_category_title']][$k] = $item;

                        if ($limit !== null && $index == $limit) {
                            return $Arr;
                        }
                        $index++;
                    }
                }
            }
        }
        return $Arr;
    }
}