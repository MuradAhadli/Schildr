<?php

namespace yii\easyii\modules\systems\models;

use app\models\SystemsLang;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\Taggable;
use yii\easyii\models\Photo;
use yii\easyii\modules\systems\models\EasyiiSystems;
use yii\helpers\StringHelper;

class Systems extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const IMAGE_WIDTH = 240;
    const IMAGE_HEIGHT = 150;

    public static function tableName()
    {
        return 'easyii_systems';
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            ['title', 'string', 'max' => 128],
            [['created_at', 'updated_at', 'status'], 'integer'],
            ['created_at', 'default', 'value' => time()],
            ['status', 'default', 'value' => self::STATUS_ON],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('easyii', 'Title'),
            'tagNames' => Yii::t('easyii', 'Tags'),
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
                'langForeignKey' => 'systems_id',
                'tableName' => "easyii_systems_lang",
                'attributes' => [
                    'title','text'
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

    public static function getAllSystems()
    {
        return self::find()
            ->select([
                'easyii_systems.id',
                'easyii_systems_lang.title',
                'easyii_systems_lang.text',
            ])
            ->leftJoin('easyii_systems_lang', 'easyii_systems.id = easyii_systems_lang.systems_id')
            ->asArray()
            ->all();
    }

}