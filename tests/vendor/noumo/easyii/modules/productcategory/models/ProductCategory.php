<?php

namespace yii\easyii\modules\productcategory\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\SortableModel;
use yii\helpers\VarDumper;

class ProductCategory extends \yii\easyii\components\ActiveRecord
{
    const IMAGE_MIN_WIDTH = 1250;
    const IMAGE_MIN_HEIGHT = 750;
    const IMAGE_MAX_HEIGHT = 1500;

    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const APPEND_CATEGORY_LIMIT = 6;

    public static function tableName()
    {
        return 'easyii_product_category';
    }

    public function rules()
    {
        return [
            ['image', 'image', 'minWidth' => self::IMAGE_MIN_WIDTH, 'minHeight' => self::IMAGE_MIN_HEIGHT, 'maxSize' => 1024 * 1024 * 15, 'extensions' => 'jpg, jpeg, png'],
            ['second_image', 'image', 'minWidth' => self::IMAGE_MIN_WIDTH, 'minHeight' => self::IMAGE_MIN_HEIGHT, 'maxSize' => 1024 * 1024 * 15, 'extensions' => 'jpg, jpeg, png'],
            [['title', 'subtitle', 'short', 'slug'], 'required'],
            [['parent_id'], 'safe'],
            [['status', 'parent_id', 'created_at', 'updated_at'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_ON],
            ['parent_id', 'default', 'value' => 0],
        ];
    }

    public function attributeLabels()
    {
        return [
            'image' => Yii::t('easyii', 'Image'),
            'second_image' => Yii::t('easyii', 'Second Image'),
            'slug' => Yii::t('easyii', 'Slug'),
            'title' => Yii::t('easyii', 'Title'),
            'subtitle' => Yii::t('easyii', 'Subtitle'),
            'short' => Yii::t('easyii', 'Short'),
        ];
    }

    public function behaviors()
    {
        return [
            SortableModel::className(),
            'seoBehavior' => SeoBehavior::className(),
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => yii::$app->params['languages'],
                'requireTranslations' => true,
                'dynamicLangClass' => true,
                'defaultLanguage' => yii::$app->language,
                'langForeignKey' => 'category_id',
                'tableName' => "easyii_product_category_lang",
                'attributes' => [
                    'title', 'subtitle', 'short', 'slug'
                ]
            ],
        ];
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    public function afterDelete()
    {
        parent::afterDelete();

        @unlink(Yii::getAlias('@webroot') . $this->image);
        @unlink(Yii::getAlias('@webroot') . $this->second_image);
    }


    public static function getProductCategory($parent_id = null, $id = null, $slug = null, $limit = null)
    {
        if ($parent_id === null) {
            $condition = '';

        } else {
            $condition = [
                'parent_id' => $parent_id,
            ];
        }

        if ($id === null) {
            $condition_self_id = '';

        } else {
            $condition_self_id = [
                'easyii_product_category.id' => $id,
            ];
        }

        if ($slug === null) {
            $pageSlug = '';

        }   else {
                $pageSlug = [
                    'slug' => $slug,
                ];
            }

        return ProductCategory::find()
            ->select([
                'easyii_product_category.id',
                'easyii_product_category.order_num',
                'easyii_product_category.status',
                'easyii_product_category.parent_id',
                'easyii_product_category.image',
                'easyii_product_category.second_image',
                'easyii_product_category_lang.title',
                'easyii_product_category_lang.slug',
                'easyii_product_category_lang.subtitle',
                'easyii_product_category_lang.short',
            ])
            ->leftJoin('easyii_product_category_lang', 'easyii_product_category.id = easyii_product_category_lang.category_id')
            ->where([
                'easyii_product_category.status' => 1,
                'easyii_product_category_lang.language' => yii::$app->language,
            ])
            ->andWhere($condition)
            ->andWhere($condition_self_id)
            ->andWhere($pageSlug)
            ->orderBy('order_num DESC')
            ->limit($limit)
            ->asArray()
            ->all();
    }

    public static function  getProductCategorybySlug($slug = null, $parent_id = null)
    {
        if ($slug === null) {
            $pageSlug = '';

        }   else {
            $pageSlug = [
                'slug' => $slug,
            ];
        }


        if($parent_id != null){
            $condition =  ['easyii_product_category.parent_id' => $parent_id];
        }else{
            $condition = '';
        }

       $reason = ProductCategory::find()
            ->select([
                'easyii_product_category.id',
                'easyii_product_category.status',
                'easyii_product_category.parent_id',
                'easyii_product_category.image',
                'easyii_product_category.second_image',
                'easyii_product_category_lang.title',
                'easyii_product_category_lang.slug',
                'easyii_product_category_lang.subtitle',
                'easyii_product_category_lang.short',
            ])
            ->leftJoin('easyii_product_category_lang', 'easyii_product_category.id = easyii_product_category_lang.category_id')
            ->where([
                'easyii_product_category.status' => 1,
                'easyii_product_category_lang.language' => yii::$app->language,
            ])
            ->andWhere($pageSlug)
           ->andWhere($condition)
            ->orderBy('order_num DESC')
            ->asArray();

        if ($slug != null) {

            return $reason->one();
        }
        else {
            return $reason->all();
        }

    }

    public static function getProductCategoriesWithParent()
    {
        $categories = ProductCategory::find()
            ->select([
                'easyii_product_category.id',
                'easyii_product_category.parent_id',
                'easyii_product_category.image',
                'easyii_product_category.status',
                'easyii_product_category_lang.title',
                'easyii_product_category_lang.subtitle',
                'easyii_product_category_lang.short',
            ])
            ->leftJoin('easyii_product_category_lang', 'easyii_product_category.id = easyii_product_category_lang.category_id')
            ->where([
                'easyii_product_category_lang.language' => yii::$app->language,
            ])
            ->orderBy('easyii_product_category.order_num DESC')
            ->asArray()
            ->all();

        $Arr = [];

        foreach ($categories as $key => $val) {
            if ($val['parent_id'] == 0) {
                foreach ($categories as $k => $item) {
                    if ($val['id'] == $item['parent_id']) {
                        $Arr[$key][$val['title']]['self'] = $val;
                        $Arr[$key][$val['title']]['child'][$k] = $item;
                    } else {
                        $Arr[$key][$val['title']]['self'] = $val;
                        $Arr[$key][$val['title']]['child'][$k] = [];
                    }
                }
            }
        }

        return $Arr;

    }


    public static function getChildCategory()
    {
        return self::find()
            ->select([
                'easyii_product_category.id',
                'easyii_product_category.parent_id',
                'easyii_product_category.image',
                'easyii_product_category_lang.title',
                'easyii_product_category_lang.subtitle',
                'easyii_product_category_lang.short',
                'easyii_product_category_lang.slug',
            ])
            ->leftJoin('easyii_product_category_lang', 'easyii_product_category.id = easyii_product_category_lang.category_id')
            ->where([
                'status' => 1,
                'language' => yii::$app->language,
            ])
            ->andWhere(['<>', 'easyii_product_category.parent_id', 0])
            ->asArray()
            ->all();
    }

    public static function getParentCategory()
    {
        return self::find()
            ->select([
                    'easyii_product_category.id',
                    'easyii_product_category_lang.title',
                ])
            ->leftJoin('easyii_product_category_lang', 'easyii_product_category.id = easyii_product_category_lang.category_id')
            ->where([
                'status' => 1,
                'language' => yii::$app->language,
                'parent_id' => 0,
            ])
            ->asArray()
            ->all();
    }

    public static function getDataForAjax($start = null, $limit = 2, $parent_id = null)
    {
        return self::find()
            ->select([
                'easyii_product_category.id',
                'easyii_product_category.status',
                'easyii_product_category.parent_id',
                'easyii_product_category.image',
                'easyii_product_category.second_image',
                'easyii_product_category_lang.title',
                'easyii_product_category_lang.slug',
                'easyii_product_category_lang.subtitle',
                'easyii_product_category_lang.short',
            ])
            ->leftJoin('easyii_product_category_lang', 'easyii_product_category.id = easyii_product_category_lang.category_id')
            ->where([
                'status' => 1,
                'language' => yii::$app->language,
                'parent_id' => $parent_id
            ])
            ->andWhere(['<', 'easyii_product_category.order_num', $start])
            ->asArray()
            ->orderBy('order_num DESC')
            ->limit($limit)
            ->all();
    }

}