<?php

namespace yii\easyii\modules\pagesystem\models;

use app\models\PageSystemLang;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\Taggable;
use yii\easyii\models\Photo;
use yii\easyii\modules\pagesystem\models\EasyiiPageSystem;
use yii\helpers\StringHelper;

class PageSystem extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const IMAGE_WIDTH = 240;
    const IMAGE_HEIGHT = 150;

    public static function tableName()
    {
        return 'easyii_page_system';
    }

    public $ssl = [
        'ssl' => [
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ]
    ];

    public function rules()
    {
        return [
            [['title','text', 'youtube_embed', 'file'], 'safe'],
            [['title'],'string', 'max' => 128],
            [['file'], 'file', 'skipOnEmpty' => true],
            [['title', 'file'], 'string', 'max' => 128],
            [['created_at', 'updated_at', 'status'], 'integer'],
            ['created_at', 'default', 'value' => time()],
            ['status', 'default', 'value' => self::STATUS_ON],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('easyii', 'Title'),
            'text' => Yii::t('easyii', 'Text'),
        ];
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
                'langForeignKey' => 'page_system_id',
                'tableName' => "easyii_page_system_lang",
                'attributes' => [
                    'title', 'text'
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

    public static function getAllPageSystem()
    {
        return self::find()
            ->select([
                'easyii_page_system.id',
                'easyii_page_system.youtube_embed',
                'easyii_page_system_lang.title',
            ])
            ->leftJoin('easyii_page_system_lang', 'easyii_page_system.id = easyii_page_system_lang.page_system_id')
            ->asArray()
            ->all();
    }

}