<?php

namespace yii\easyii\modules\product\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\SortableModel;
use yii\easyii\modules\carousel\api\Carousel;
use yii\helpers\VarDumper;

class Product extends \yii\easyii\components\ActiveRecord
{
    const IMAGE_MIN_WIDTH = 600;
    const IMAGE_MIN_HEIGHT = 368;
    const IMAGE_MAX_HEIGHT = 1500;

    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    public static function tableName()
    {
        return 'easyii_product';
    } 

    public function rules()
    {
        return [
            ['image', 'file', 'maxFiles' => 7],
            [['hover_image', 'downloads'], 'safe'],
            [['title', 'slug', 'customization', 'category_id'], 'required'],
            [['type' , 'thumb'], 'safe'],
            [['status', 'category_id', 'created_at', 'updated_at'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_ON],
        ];
    }

    public function attributeLabels()
    {
        return [
            'image' => Yii::t('easyii', 'Image'),
            'slug' => Yii::t('easyii', 'Slug'),
            'hover_image' => Yii::t('easyii', 'Hover Image'),
            'customization' => Yii::t('easyii', 'Customization'),
            'downloads' => Yii::t('easyii', 'Downloads'),
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
                'langForeignKey' => 'product_id',
                'tableName' => "easyii_product_lang",
                'attributes' => [
                    'title', 'customization', 'slug'
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
    }


    public static function getAllProduct()
    {
        return self::find()
            ->select([
                'easyii_product.id',
                'easyii_product.category_id',
                'easyii_product.image',
                'easyii_product.downloads',
                'easyii_product_lang.title',
                'easyii_product_lang.customization',
            ])
            ->leftJoin('easyii_product_lang', 'easyii_product.id = easyii_product_lang.product_id')
            ->where([
                'status' => 1,
                'language' => yii::$app->language
            ])
            ->asArray()
            ->all();

    }

    public static function getProduct($id)
    {
        return self::find()
            ->select([
                'easyii_product.id',
                'easyii_product.category_id',
                'easyii_product.image',
                'easyii_product.downloads',
                'easyii_product_lang.title',
                'easyii_product_lang.customization',
            ])
            ->leftJoin('easyii_product_lang', 'easyii_product.id = easyii_product_lang.product_id')
            ->where([
                'easyii_product.id' => $id,
                'status' => 1, 
                'language' => yii::$app->language
            ])
            ->asArray()
            ->one();
    }


    public static function getProductByParent($parent_id)
    {
        $products = self::find()
            ->select([
                'easyii_product.id',
                'easyii_product.order_num',
                'easyii_product.category_id',
                'easyii_product.image',
                'easyii_product.hover_image',
                'easyii_product.downloads',
                'easyii_product_lang.title',
                'easyii_product_lang.slug',
                'easyii_product_lang.customization',
            ])
            ->leftJoin('easyii_product_lang', 'easyii_product.id = easyii_product_lang.product_id')
            ->where([
                'status' => 1,
                'category_id' => $parent_id,
                'language' => yii::$app->language,
            ])
            ->orderBy('order_num  DESC')
            ->asArray()
            ->all();

        $allFiles = ProductFiles::getAllProductFiles();

        foreach ($products as $key => $val) {

            foreach ($allFiles as $k => $file) {
                if ($val['id'] == $file['product_id']) {
                    $val['files'][$k] = $file;
                    $products[$key] = $val;
                }
            }
        }
        return $products;
    }


    public static function updateDownloads($oldArr = [], $postArr = [])
    {
        foreach($postArr as $k => $v){
            if($v['pdf'] == ''){
                $postArr[$k]['pdf'] = $oldArr[$k]['pdf'];
            }
        }
        return $postArr;
    }

}