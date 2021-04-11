<?php

namespace yii\easyii\modules\clients\models;

use app\models\ClientsLang;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\Taggable;
use yii\easyii\models\Photo;
use yii\easyii\modules\clientsLang\models\EasyiiClientsLang;
use yii\helpers\StringHelper;

class Clients extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const IMAGE_WIDTH = 45;
    const IMAGE_HEIGHT = 45;

    public static function tableName()
    {
        return 'easyii_clients';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'string', 'max' => 128],
            ['image', 'image', 'minWidth' => self::IMAGE_WIDTH, 'minHeight' => self::IMAGE_HEIGHT, 'maxSize' => 1024 * 1024 * 10, 'extensions' => 'png, PNG, jpg, JPG, jpeg, JPEG,'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            ['created_at', 'default', 'value' => time()],
            ['status', 'default', 'value' => self::STATUS_ON],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('easyii', 'Title'),
            'url' => Yii::t('easyii', 'Link'),
            'image' => Yii::t('easyii', 'Image'),
            'slug' => Yii::t('easyii', 'Slug'),
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
                'langForeignKey' => 'client_id',
                'tableName' => "easyii_clients_lang",
                'attributes' => [
                    'name'
                ]
            ],
        ];
    }

    public function getPhotos()
    {
        return $this->hasMany(Photo::className(), ['item_id' => 'id'])->where(['class' => self::className()])->orderBy('order_num DESC');
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $settings = Yii::$app->getModule('admin')->activeModules['clients']->settings;

            if (!$insert && $this->image != $this->oldAttributes['image'] && $this->oldAttributes['image']) {
                @unlink(Yii::getAlias('@webroot') . $this->oldAttributes['image']);
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        if ($this->image) {
            @unlink(Yii::getAlias('@webroot') . $this->image);
        }

        foreach ($this->getPhotos()->all() as $photo) {
            $photo->delete();
        }
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }


    public static function getAllClients()
    {
        return Self::find()
            ->select([
                'easyii_clients.id',
                'easyii_clients.image',
                'easyii_clients.status',
                'easyii_clients.url',
                'easyii_clients.created_at',
                'easyii_clients.updated_at',
                'easyii_clients_lang.name',
            ])
            ->where(['language' => yii::$app->language])
            ->leftJoin('easyii_clients_lang', 'easyii_clients.id = easyii_clients_lang.client_id')
            ->asArray()
            ->all();
    }
}