<?php
namespace yii\easyii\modules\media\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\easyii\behaviors\CacheFlush;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\SortableModel;
use yii\easyii\behaviors\Taggable;
use yii\easyii\modules\gallerycategory\models\GalleryCategory;
use yii\helpers\VarDumper;

class Media extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;
    const CACHE_KEY = 'easyii_media';
    const PHOTO_MIN_WIDTH = 1280;
    const PHOTO_MIN_HEIGHT = 720;
    const PHOTO_THUMB_WIDTH = 378;
    const PHOTO_THUMB_HEIGHT = 295;

    public static function tableName()
    {
        return 'easyii_media';
    }

    public function rules()
    {
        return [
            [['category_id'], 'required'],
            ['image', 'image', 'maxSize' => 1024 * 1024 * 10, 'extensions' => 'png, PNG, jpg, JPG, jpeg, JPEG,'],
            ['title', 'trim'],
            [['status', 'category_id'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_ON],
        ];
    }

    public function attributeLabels()
    {
        return [
            'image' => Yii::t('easyii', 'Image'),
            'link' =>  Yii::t('easyii', 'Link'),
            'title' => Yii::t('easyii', 'Title'),
            'text' => Yii::t('easyii', 'Text'),
        ];
    }

    public function behaviors()
    {
        return [
            SortableModel::className(),
            'seoBehavior' => SeoBehavior::className(),
//            'taggabble' => Taggable::className(),
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => yii::$app->params['languages'],
                'requireTranslations' => true,
                'dynamicLangClass' => true,
                'defaultLanguage' => yii::$app->language,
                'langForeignKey' => 'media_id',
                'tableName' => "easyii_media_lang",
                'attributes' => [
                    'title'
                ]
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if(!$insert && $this->image != $this->oldAttributes['image'] && $this->oldAttributes['image']){
                @unlink(Yii::getAlias('@webroot').$this->oldAttributes['image']);
            }
            return true;
        } else {
            return false;
        }
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    public function afterDelete()
    {
        parent::afterDelete();

        @unlink(Yii::getAlias('@webroot').$this->image);
        @unlink(Yii::getAlias('@webroot').$this->thumb);
    }
}