<?php
namespace yii\easyii\modules\video\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\easyii\behaviors\CacheFlush;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\SortableModel;
use yii\easyii\behaviors\Taggable;

class Video extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;
    const CACHE_KEY = 'easyii_video';
    const PHOTO_MAX_WIDTH = 2500;
    const PHOTO_MAX_HEIGHT = 2000;
    const PHOTO_THUMB_WIDTH = 255;
    const PHOTO_THUMB_HEIGHT = 200;

    public $ssl = [
        'ssl' => [
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ]
    ];

    public static function tableName()
    {
        return 'easyii_video';
    }

    public function rules()
    {
        return [
            [['link', 'category_id'], 'required'],
            ['link', 'trim'],
            [['status', 'category_id'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_ON],
        ];
    }

    public function attributeLabels()
    {
        return [
//            'image' => Yii::t('easyii', 'Image'),
            'link' =>  Yii::t('easyii', 'Youtube video id'),
            'title' => Yii::t('easyii', 'Title'),
            'text' => Yii::t('easyii', 'Text'),
        ];
    }

    public function behaviors()
    {
        return [
            SortableModel::className(),
        ];
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            return true;
        } else {
            return false;
        }
    }
}