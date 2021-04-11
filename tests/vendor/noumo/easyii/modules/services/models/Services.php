<?php
namespace yii\easyii\modules\services\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\SortableModel;
use yii\easyii\behaviors\Taggable;
use yii\easyii\models\Photo;
use yii\easyii\modules\servicesLang\models\EasyiiServicesLang;
use yii\helpers\StringHelper;

class Services extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const IMAGE_WIDTH = 585;
    const IMAGE_HEIGHT = 390;

    public static function tableName()
    {
        return 'easyii_services';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            ['text', 'safe'],
            [['name', 'text'], 'trim'],
            [['name'], 'string', 'max' => 255],
            [['status', 'parent_id', 'order_num'], 'integer'],
            ['parent_id', 'default', 'value' => 0],
            ['status', 'default', 'value' => self::STATUS_ON],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('db', 'Name'),
            'parent_id' => Yii::t('db', 'Parent id'),
        ];
    }

    public function behaviors()
    {
        return [
            SortableModel::className(),
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => yii::$app->params['languages'],
                'requireTranslations' => true,
                'dynamicLangClass' => true,
                'defaultLanguage' => yii::$app->language,
                'langForeignKey' => 'service_id',
                'tableName' => "easyii_services_lang",
                'attributes' => [
                    'name', 'text', 'slug'
                ]
            ],
        ];
    }

    public function getServices()
    {
        $query = self::find();

        if($this->id) {
            $query = $query->where(['<>', 'id', $this->id]);
        }
            $services = $query
                ->localized()
                ->asArray()
                ->all();

        return $services;
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }
}