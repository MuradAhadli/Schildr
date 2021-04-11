<?php

namespace yii\easyii\modules\carousel\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\easyii\behaviors\CacheFlush;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\SortableModel;
use yii\easyii\behaviors\Taggable;

class Carousel extends \yii\easyii\components\ActiveRecord
{
    const IMAGE_MIN_WIDTH = 1540;
    const IMAGE_MIN_HEIGHT = 670;
    const IMAGE_MAX_HEIGHT = 860;

    const STATUS_OFF = 0;
    const STATUS_ON = 1;
    const CACHE_KEY = 'easyii_carousel';

    public $category_id_help;

    public static function tableName()
    {
        return 'easyii_carousel';
    }

    public function rules()
    {
        return [
            ['image', 'image', 'maxFiles' => 10, 'minWidth' => self::IMAGE_MIN_WIDTH, 'minHeight' => self::IMAGE_MIN_HEIGHT, 'maxSize' => 1024 * 1024 * 15, 'extensions' => 'jpg, png'],
            [['title', 'short', 'link'], 'required'],
            [['page_id', 'category_id'], 'safe'],
            [['status', 'type'], 'integer'],
            ['text', 'default', 'value' => 'text'],
            ['status', 'default', 'value' => self::STATUS_ON],
        ];
    }

    public function attributeLabels()
    {
        return [
            'image' => Yii::t('easyii', 'Image'),
            'page_id' => Yii::t('easyii', 'Page'),
            'category_id' => Yii::t('easyii', 'Category'),
            'link' => Yii::t('easyii', 'Link'),
            'title' => Yii::t('easyii', 'Title'),
            'text' => Yii::t('easyii', 'Text'),
            'type' => Yii::t('easyii', 'Video'),
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
                'langForeignKey' => 'carousel_id',
                'tableName' => "easyii_carousel_lang",
                'attributes' => [
                    'title', 'short', 'text'
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


    /**
     * @param $page_id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getCarouselByPage($page_id)
    {
        return Carousel::find()
            ->select([
                'easyii_carousel_lang.title',
                'easyii_carousel_lang.short',
                'easyii_carousel_lang.text',
                'easyii_carousel_uploads.id',
                'easyii_carousel_uploads.file_name',
            ])
            ->leftJoin('easyii_carousel_lang', 'easyii_carousel.id = easyii_carousel_lang.carousel_id')
            ->leftJoin('easyii_carousel_uploads', 'easyii_carousel.id = easyii_carousel_uploads.carousel_id')
            ->where([
                'easyii_carousel.page_id' => $page_id,
                'language' => yii::$app->language,
            ])
            ->asArray()
            ->all();
    }

    public static function getCarouselByCategory($category_id)
    {
        return Carousel::find()
            ->select([
                'easyii_carousel_lang.title',
                'easyii_carousel_lang.short',
                'easyii_carousel_lang.text',
                'easyii_carousel_uploads.id',
                'easyii_carousel_uploads.file_name',
            ])
            ->leftJoin('easyii_carousel_lang', 'easyii_carousel.id = easyii_carousel_lang.carousel_id')
            ->leftJoin('easyii_carousel_uploads', 'easyii_carousel.id = easyii_carousel_uploads.carousel_id')
            ->where([
                'easyii_carousel.category_id' => $category_id,
                'language' => yii::$app->language,
            ])
            ->asArray()
            ->all();
    }

}