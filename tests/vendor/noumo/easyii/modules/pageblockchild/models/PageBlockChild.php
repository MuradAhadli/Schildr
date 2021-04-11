<?php

namespace yii\easyii\modules\pageblockchild\models;

use app\models\PageBlockChildLang;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\Taggable;
use yii\easyii\models\Photo;
use yii\easyii\modules\bacgeblock\models\EasyiiPageBlockChild;
use yii\easyii\modules\pageblock\models\PageBlock;
use yii\helpers\StringHelper;

class PageBlockChild extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const IMAGE_WIDTH = 240;
    const IMAGE_HEIGHT = 150;

    public static function tableName()
    {
        return 'easyii_page_block_child';
    }

    public function rules()
    {
        return [
            [['title', 'short', 'description', 'page_block_id', 'url', 'target'], 'required'],
            ['title', 'string', 'max' => 255],
            ['image', 'image', 'minWidth' => self::IMAGE_WIDTH, 'minHeight' => self::IMAGE_HEIGHT, 'maxSize' => 1024 * 1024 * 10, 'extensions' => 'png, PNG, jpg, JPG, jpeg, JPEG,'],
            [['created_at', 'updated_at'], 'integer'],
            ['created_at', 'default', 'value' => time()],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('easyii', 'Title'),
            'short' => Yii::t('easyii', 'Short'),
            'description' => Yii::t('easyii', 'Description'),
            'target' => Yii::t('easyii', 'Target'),
            'image' => Yii::t('easyii', 'Image'),
            'url' => Yii::t('easyii', 'Url'),
            'page_block_id' => Yii::t('easyii', 'Page Block Id'),
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
                'langForeignKey' => 'page_block_child_id',
                'tableName' => "easyii_page_block_child_lang",
                'attributes' => [
                    'title', 'short', 'description',
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

    public static function getAllPageBlockChild()
    {
        return self::find()
            ->select([
                'easyii_page_block_child.page_block_id',
                'easyii_page_block_child.image',
                'easyii_page_block_child.url',
                'easyii_page_block_child.target',
                'easyii_page_block_child_lang.title',
                'easyii_page_block_child_lang.short',
                'easyii_page_block_child_lang.description',
            ])
            ->where([
                'language' => yii::$app->language
            ])
            ->leftJoin('easyii_page_block_child_lang', 'easyii_page_block_child.id = easyii_page_block_child_lang.page_block_child_id')
            ->asArray()
            ->all();
    }

    public static function getAllPageBlockChildWithParent()
    {
        $blocks = PageBlock::find()
            ->select([
                'easyii_page_block.id as parent_block_id',
                'easyii_page_block_child.id',
                'easyii_page_block_lang.title as page_block_title',
                'easyii_page_block_child.image',
                'easyii_page_block_child.target',
                'easyii_page_block_child.url',
                'easyii_page_block_child_lang.title',
                'easyii_page_block_child_lang.short',
                'easyii_page_block_child_lang.description',
            ])
            ->leftJoin('easyii_page_block_lang', 'easyii_page_block.id = easyii_page_block_lang.page_block_id')
            ->leftJoin('easyii_page_block_child', 'easyii_page_block.id = easyii_page_block_child.page_block_id')
            ->leftJoin('easyii_page_block_child_lang', 'easyii_page_block_child.id = easyii_page_block_child_lang.page_block_child_id')
            ->where([
                'easyii_page_block_child_lang.language' => yii::$app->language,
                'easyii_page_block_lang.language' => yii::$app->language,

            ])
            ->asArray()
            ->all();

        return $blocks;
    }
}