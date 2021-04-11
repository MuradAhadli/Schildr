<?php
namespace yii\easyii\modules\gallerycategory\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\Query;
use yii\db\QueryBuilder;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\Taggable;
use yii\easyii\models\Photo;
use yii\helpers\StringHelper;
use yii\helpers\VarDumper;

class GalleryCategory extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    public static function tableName()
    {
        return 'easyii_gallery_category';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'trim'],
            [['name'], 'string', 'max' => 128],
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
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => yii::$app->params['languages'],
                'requireTranslations' => true,
                'dynamicLangClass' => true,
                'defaultLanguage' => yii::$app->language,
                'langForeignKey' => 'category_id',
                'tableName' => "easyii_gallery_category_lang",
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
            $settings = Yii::$app->getModule('admin')->activeModules['gallerycategory']->settings;

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

    public static function getCategories()
    {
        $cats = (new Query())
            ->select('
                gc.id,
                gc.time,
                gcl.category_id,
                gcl.name,
                gcl.slug
            ')
            ->from('easyii_gallery_category gc')
            ->leftJoin('easyii_gallery_category_lang gcl', 'gcl.category_id = gc.id')
            ->where([
                'gc.status' => 1,
                'gcl.language' => yii::$app->language
            ])
            ->orderBy('time DESC')
            ->all();

        return $cats;
    }
}