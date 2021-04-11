<?php
namespace yii\easyii\modules\examination\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\Taggable;
use yii\easyii\models\Photo;
use yii\easyii\modules\examinationLang\models\EasyiiExaminationLang;
use yii\helpers\StringHelper;

class Examination extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const IMAGE_WIDTH = 235;
    const IMAGE_HEIGHT = 195;

    public static function tableName()
    {
        return 'easyii_examination';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'trim'],
            [['name','price'], 'string', 'max' => 128],
            [['time', 'status'], 'integer'],
            ['time', 'default', 'value' => time()],
            ['slug', 'default', 'value' => null],
            ['status', 'default', 'value' => self::STATUS_ON],
            ['tagNames', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('easyii', 'Title'),
            'text' => Yii::t('easyii', 'Text'),
            'short' => Yii::t('easyii', 'Short'),
            'link' => Yii::t('easyii', 'Link'),
            'image' => Yii::t('easyii', 'Image'),
            'time' => Yii::t('easyii', 'Date'),
            'slug' => Yii::t('easyii', 'Slug'),
            'tagNames' => Yii::t('easyii', 'Tags'),
        ];
    }

    public function behaviors()
    {
        return [
            'seoBehavior' => SeoBehavior::className(),
//            'taggabble' => Taggable::className(),
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => yii::$app->params['languages'],
                //'languageField' => 'language',
                //'localizedPrefix' => '',
                'requireTranslations' => true,
                'dynamicLangClass' => true,
//                'langClassName' => DepartmentLang::className(), // or namespace/for/a/class/PostLang
                'defaultLanguage' => yii::$app->language,
                'langForeignKey' => 'examination_id',
                'tableName' => "easyii_examination_lang",
                'attributes' => [
                    'name', 'slug'
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
            $settings = Yii::$app->getModule('admin')->activeModules['examination']->settings;

            return true;
        } else {
            return false;
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }
}