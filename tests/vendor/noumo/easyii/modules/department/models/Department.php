<?php
namespace yii\easyii\modules\department\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\Taggable;
use yii\easyii\models\Photo;
use yii\easyii\modules\departmentLang\models\EasyiiDepartmentLang;
use yii\helpers\StringHelper;

class Department extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const IMAGE_WIDTH = 390;
    const IMAGE_HEIGHT = 325;

    public static function tableName()
    {
        return 'easyii_department';
    }

    public function rules()
    {
        return [
            [['name', 'short', 'slug','detail_name'], 'required'],
            [['name', 'text','short'], 'trim'],
            [['name', 'detail_name'], 'string', 'max' => 128],
            ['image', 'image',  'minWidth' => self::IMAGE_WIDTH, 'minHeight' => self::IMAGE_HEIGHT, 'maxSize' => 1024 * 1024 * 10, 'extensions' => 'jpg, png'],
            [['time', 'status', 'phone', 'mobile', 'show_in_home'], 'integer'],
            ['show_in_home', 'default', 'value' => 0],
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
            'detail_name' => Yii::t('easyii', 'Detail name'),
            'text' => Yii::t('easyii', 'Text'),
            'short' => Yii::t('easyii', 'Short'),
            'image' => Yii::t('easyii', 'Image'),
            'phone' => Yii::t('easyii', 'Phone'),
            'mobile' => Yii::t('easyii', 'Mobile'),
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
                'langForeignKey' => 'department_id',
                'tableName' => "easyii_department_lang",
                'attributes' => [
                    'name', 'text', 'short','slug', 'detail_name'
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
            $settings = Yii::$app->getModule('admin')->activeModules['department']->settings;

            if(!$insert && $this->image != $this->oldAttributes['image'] && $this->oldAttributes['image']){
                @unlink(Yii::getAlias('@webroot').$this->oldAttributes['image']);
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        if($this->image){
            @unlink(Yii::getAlias('@webroot').$this->image);
        }

        foreach($this->getPhotos()->all() as $photo){
            $photo->delete();
        }
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }
}