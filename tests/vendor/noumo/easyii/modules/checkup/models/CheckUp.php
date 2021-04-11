<?php
namespace yii\easyii\modules\checkup\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\Taggable;
use yii\easyii\models\Photo;
use yii\easyii\modules\checkupLang\models\EasyiiCheckupLang;
use yii\easyii\modules\examination\models\Examination;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\VarDumper;

class CheckUp extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const IMAGE_WIDTH = 235;
    const IMAGE_HEIGHT = 195;

    public static function tableName()
    {
        return 'easyii_checkup';
    }

    public function rules()
    {
        return [
            [['name','examination_id'], 'required'],
            [['name','text'], 'trim'],
            [['name','price'], 'string', 'max' => 128],
            [['discount_price'], 'string', 'max' => 10],
            ['discount_price', 'default', 'value' => '0'],
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
            'name' => Yii::t('db', 'Name'),
            'text' => Yii::t('db', 'Text'),
            'slug' => Yii::t('db', 'slug'),
            'price' => Yii::t('db', 'Price'),
            'discount_price' => Yii::t('db', 'Discount price'),
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
                'langForeignKey' => 'checkup_id',
                'tableName' => "easyii_checkup_lang",
                'attributes' => [
                    'name', 'slug', 'text'
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
        $this->examination_id = serialize($this->examination_id);

        if (parent::beforeSave($insert)) {
            $settings = Yii::$app->getModule('admin')->activeModules['checkup']->settings;

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

    public static function getExamination()
    {

        $model = Examination::find()
            ->select('easyii_examination.id, easyii_examination_lang.name')
            ->leftJoin('easyii_examination_lang', 'easyii_examination_lang.examination_id = easyii_examination.id')
            ->where(['status' => 1])
            ->asArray()
            ->all();

        return ArrayHelper::map($model,'id', 'name');

    }

}








