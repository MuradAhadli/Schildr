<?php
namespace yii\easyii\modules\management\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\Taggable;
use yii\easyii\models\Photo;
use yii\easyii\modules\managementLang\models\EasyiiManagementLang;
use yii\helpers\StringHelper;

class Management extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const IMAGE_WIDTH = 768;
    const IMAGE_HEIGHT = 449;

    public static function tableName()
    {
        return 'easyii_management';
    }

    public function rules()
    {
        return [
            [['username', 'position', 'text', 'short', 'slug'], 'required'],
            [['username', 'position', 'text'], 'trim'],
            [['username', 'phone'], 'string', 'max' => 255],
            ['image', 'image',  'minWidth' => self::IMAGE_WIDTH, 'minHeight' => self::IMAGE_HEIGHT, 'maxSize' => 1024 * 1024 * 20, 'extensions' => 'jpg, png'],
            [['time', 'status'], 'integer'],
            ['time', 'default', 'value' => time()],
            ['slug', 'default', 'value' => null],
            ['status', 'default', 'value' => self::STATUS_ON],
            ['tagNames', 'safe'],
            ['email', 'email'],
            ['social','safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('easyii', 'Title'),
            'text' => Yii::t('easyii', 'Text'),
            'short' => Yii::t('easyii', 'Short'),
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
//                'langClassName' => ManagementLang::className(), // or namespace/for/a/class/PostLang
                'defaultLanguage' => yii::$app->language,
                'langForeignKey' => 'management_id',
                'tableName' => "easyii_management_lang",
                'attributes' => [
                    'username', 'position', 'text', 'slug', 'short'
                ]
            ],
        ];
    }

    public function getPhotos()
    {
        return $this->hasMany(Photo::className(), ['item_id' => 'id'])->where(['class' => self::className()])->orderBy(['order_num' => SORT_DESC]);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if(!$insert && $this->image != $this->oldAttributes['image'] && $this->oldAttributes['image']){
                @unlink(Yii::getAlias('@webroot').$this->oldAttributes['image']);
            }

            $this->social = serialize($this->social);

            return true;
        }

        return false;

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