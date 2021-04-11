<?php

namespace yii\easyii\modules\pageblock\models;

use app\models\PageBlockLang;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\Taggable;
use yii\easyii\models\Photo;
use yii\easyii\modules\bacgeblock\models\EasyiiPageBlock;
use yii\helpers\StringHelper;

class PageBlock extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const IMAGE_WIDTH = 240;
    const IMAGE_HEIGHT = 150;

    public static function tableName()
    {
        return 'easyii_page_block';
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
                'langForeignKey' => 'page_block_id',
                'tableName' => "easyii_page_block_lang",
                'attributes' => [
                    'title'
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

    public static function getAllPageBlock()
    {
        return self::find()
            ->select([
                'easyii_page_block.id',
                'easyii_page_block_lang.title',
            ])
            ->leftJoin('easyii_page_block_lang', 'easyii_page_block.id = easyii_page_block_lang.page_block_id')
            ->asArray()
            ->all();
    }

}