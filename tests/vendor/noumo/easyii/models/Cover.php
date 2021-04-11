<?php
namespace yii\easyii\models;

use Yii;
use yii\easyii\behaviors\SortableModel;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;

class Cover extends \yii\easyii\components\ActiveRecord
{
    const PHOTO_MIN_WIDTH = 1540;
    const PHOTO_MAX_WIDTH = 1900;

    const PHOTO_MIN_HEIGHT = 310;
    const PHOTO_MAX_HEIGHT = 310;

//    const PHOTO_THUMB_WIDTH = 120;
//    const PHOTO_THUMB_HEIGHT = 90;

    public static function tableName()
    {
        return 'easyii_covers';
    }

    public function rules()
    {
        return [
            [['class', 'item_id'], 'required'],
            [['item_id', 'order_num'], 'integer'],
            [['image'], 'image', 'minWidth' => self::PHOTO_MIN_WIDTH, 'minHeight' => self::PHOTO_MIN_HEIGHT, 'maxSize' => 1024 * 1024 * 20],
            ['title', 'trim']
        ];
    }

    public function behaviors()
    {
        return [
            SortableModel::className(),
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => yii::$app->params['languages'],
                //'languageField' => 'language',
                //'localizedPrefix' => '',
                'requireTranslations' => true,
                'dynamicLangClass' => true,
//                'langClassName' => NewsLang::className(), // or namespace/for/a/class/PostLang
                'defaultLanguage' => yii::$app->language,
                'langForeignKey' => 'cover_id',
                'tableName' => "easyii_cover_lang",
                'attributes' => [
                    'title'
                ]
            ],
        ];
    }

    public function afterDelete()
    {
        parent::afterDelete();

        @unlink(Yii::getAlias('@webroot').$this->image);
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }
}