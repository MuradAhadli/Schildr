<?php
namespace yii\easyii\modules\contacts\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\Taggable;
use yii\easyii\models\Photo;
use yii\easyii\modules\contacts\models\EasyiiContactsLang;
use yii\helpers\StringHelper;

class Contacts extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const IMAGE_WIDTH = 235;
    const IMAGE_HEIGHT = 195;

    const TYPE_ADDRESS = '1';
    const TYPE_PHONE = '2';
    const TYPE_EMAIL = '3';
    const TYPE_MOBILE = '4';

    public static function tableName()
    {
        return 'easyii_contacts';
    }

    public function rules()
    {
        return [
            [['name', 'first_name'], 'required'],
            [['name'], 'trim'],
            [['name'], 'string', 'max' => 128],
            ['status', 'default', 'value' => self::STATUS_ON],
            ['tagNames', 'safe'],
            ['time', 'default', 'value' => time()],
            [['time', 'type'], 'integer']
        ];
    }

    public function behaviors()
    {
        return [
            'seoBehavior' => SeoBehavior::className(),
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => yii::$app->params['languages'],
                //'languageField' => 'language',
                //'localizedPrefix' => '',
                'requireTranslations' => true,
                'dynamicLangClass' => true,
//                'langClassName' => DepartmentLang::className(), // or namespace/for/a/class/PostLang
                'defaultLanguage' => yii::$app->language,
                'langForeignKey' => 'contact_id',
                'tableName' => "easyii_contacts_lang",
                'attributes' => [
                    'name'
                ]
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $settings = Yii::$app->getModule('admin')->activeModules['contacts']->settings;

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