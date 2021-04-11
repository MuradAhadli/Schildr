<?php
namespace yii\easyii\modules\partners\models;

use app\models\PartnerLang;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\Taggable;
use yii\easyii\models\Photo;
use yii\easyii\modules\partnersLang\models\EasyiiPartnersLang;
use yii\helpers\StringHelper;

class Partners extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const IMAGE_WIDTH = 77;
    const IMAGE_HEIGHT = 77;

    public static function tableName()
    {
        return 'easyii_partners';
    }

    public function rules()
    {
        return [
            [['full_name', 'review', 'rating', 'position', 'client_id'], 'required'],
            [['full_name'], 'trim'],
            ['full_name', 'string', 'max' => 128],
            ['position', 'string', 'max' => 255],
            ['image', 'image',  'minWidth' => self::IMAGE_WIDTH, 'minHeight' => self::IMAGE_HEIGHT, 'maxSize' => 1024 * 1024 * 10, 'extensions' => 'png, PNG, jpg, JPG, jpeg, JPEG,'],
            [['created_at', 'status', 'rating'], 'integer'],
            ['created_at', 'default', 'value' => time()],
            ['status', 'default', 'value' => self::STATUS_ON],
            ['tagNames', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'full_name' => Yii::t('easyii', 'Full name'),
            'review' => Yii::t('easyii', 'Review'),
            'position' => Yii::t('easyii', 'Position'),
            'image' => Yii::t('easyii', 'Image'),
            'created_at' => Yii::t('easyii', 'Created at'),
            'updated_at' => Yii::t('easyii', 'Updated at'),
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
                'langForeignKey' => 'partner_id',
                'tableName' => "easyii_partners_lang",
                'attributes' => [
                    'full_name', 'review', 'position'
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
            $settings = Yii::$app->getModule('admin')->activeModules['partners']->settings;

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