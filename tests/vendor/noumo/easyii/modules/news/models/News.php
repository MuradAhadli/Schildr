<?php
namespace yii\easyii\modules\news\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\Taggable;
use yii\easyii\models\Photo;
use yii\easyii\modules\newsLang\models\EasyiiNewsLang;
use yii\helpers\StringHelper;

class News extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const IMAGE_WIDTH = 390;
    const IMAGE_HEIGHT = 325;

    public static function tableName()
    {
        return 'easyii_news';
    }

    public function rules()
    {
        return [
            [['title', 'short', 'text', 'slug'], 'required'],
            [['title', 'short', 'text'], 'trim'],
            ['title', 'string', 'max' => 128],
            ['image', 'image', 'minWidth' => self::IMAGE_WIDTH, 'minHeight' => self::IMAGE_HEIGHT, 'maxSize' => 1024*1024*10, 'extensions' => 'jpg, png'],
            [['views', 'status'], 'integer'],
            ['time', 'default', 'value' => time()],
            ['slug', 'default', 'value' => null],
            ['status', 'default', 'value' => self::STATUS_ON],
            [['tagNames', 'time'], 'safe']
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
//                'langClassName' => NewsLang::className(), // or namespace/for/a/class/PostLang
                'defaultLanguage' => yii::$app->language,
                'langForeignKey' => 'news_id',
                'tableName' => "easyii_news_lang",
                'attributes' => [
                    'title', 'short', 'text', 'slug'
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
            $settings = Yii::$app->getModule('admin')->activeModules['news']->settings;
            $this->short = StringHelper::truncate($settings['enableShort'] ? $this->short : strip_tags($this->text), $settings['shortMaxLength']);

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