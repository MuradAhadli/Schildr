<?php

namespace yii\easyii\modules\footerlink\models;

use app\models\FooterLinkLang;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\Taggable;
use yii\easyii\models\Photo;
use yii\easyii\modules\bacgeblock\models\EasyiiFooterLink;
use yii\helpers\StringHelper;

class FooterLink extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const IMAGE_WIDTH = 240;
    const IMAGE_HEIGHT = 150;

    public static function tableName()
    {
        return 'easyii_footer_link';
    }

    public function rules()
    {
        return [
            [['title', 'url', 'target'], 'required'],
            ['parent_id', 'default', 'value' => 0],
            ['title', 'string', 'max' => 255],
            [['created_at', 'updated_at', 'parent_id', 'status'], 'integer'],
            ['created_at', 'default', 'value' => time()],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('easyii', 'Title'),
            'target' => Yii::t('easyii', 'Target'),
            'url' => Yii::t('easyii', 'Url'),
            'parent_id' => Yii::t('easyii', 'Parent Id'),
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
                'langForeignKey' => 'footer_link_id',
                'tableName' => "easyii_footer_link_lang",
                'attributes' => [
                    'title'
                ]
            ],
        ];
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    public static function getFooterLinks()
    {
        return self::find()
            ->select([
                'easyii_footer_link.id',
                'easyii_footer_link_lang.title'
            ])
            ->leftJoin('easyii_footer_link_lang', 'easyii_footer_link.id = easyii_footer_link_lang.footer_link_id')
            ->where([
                'parent_id' => 0
            ])
            ->asArray()
            ->all();
    }

    public static function getAllFooterLinks()
    {
        return self::find()
            ->select([
                'easyii_footer_link.id',
                'easyii_footer_link.parent_id',
                'easyii_footer_link.url',
                'easyii_footer_link.target',
                'easyii_footer_link_lang.title'
            ])
            ->leftJoin('easyii_footer_link_lang', 'easyii_footer_link.id = easyii_footer_link_lang.footer_link_id')
            ->where([
                'language' => yii::$app->language,
                'status' => 1
            ])
            ->asArray()
            ->all();
    }
}