<?php
namespace yii\easyii\models;

use Yii;
use yii\easyii\behaviors\SortableModel;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;

class Photo extends \yii\easyii\components\ActiveRecord
{
    const PHOTO_MIN_WIDTH = 780;
    const PHOTO_MAX_WIDTH = 1280;

    const PHOTO_MIN_HEIGHT = 519;
    const PHOTO_MAX_HEIGHT = 720;

    const PHOTO_THUMB_WIDTH = 378;
    const PHOTO_THUMB_HEIGHT = 296;

    const TYPE_VIDEO = 1;
    const TYPE_PHOTO = 0;

    public static function tableName()
    {
        return 'easyii_photos';
    }

    public function rules()
    {
        return [
            [['class', 'item_id'], 'required'],
            [['item_id', 'type'], 'integer'],
            [['thumb'], 'image'],
            ['image', 'image'],
            [['title', 'youtube_id'], 'trim'],
            ['description', 'default', 'value' => 'null']
        ];
    }

    public function behaviors()
    {
        return [
            SortableModel::className(),
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => yii::$app->params['languages'],
                //'languageField' => 'language',
                //'localizedPrefix' => '',
                'requireTranslations' => true,
                'dynamicLangClass' => true,
//                'langClassName' => NewsLang::className(), // or namespace/for/a/class/PostLang
                'defaultLanguage' => yii::$app->language,
                'langForeignKey' => 'photo_id',
                'tableName' => "easyii_photo_lang",
                'attributes' => [
                    'title'
                ]
            ],
        ];
    }

    public function afterDelete()
    {
        parent::afterDelete();

        @unlink(Yii::getAlias('@webroot').$this->image);
        @unlink(Yii::getAlias('@webroot').$this->thumb);
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }
}