<?php
namespace yii\easyii\modules\doctor\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\Taggable;
use yii\easyii\models\Photo;
use yii\easyii\models\User;
use yii\easyii\modules\department\models\Department;
use yii\easyii\modules\doctorLang\models\EasyiiDoctorLang;
use yii\helpers\StringHelper;
use yii\helpers\VarDumper;

class Doctor extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    public static function tableName()
    {
        return 'easyii_doctor';
    }
    
    public function rules()
    {
        return [
            [['name', 'text', 'slug'], 'required'],
            [['name', 'text', 'short', 'position'], 'trim'],
            ['name', 'string', 'max' => 255],
            [['time', 'department_id', 'show_in_home'], 'integer'],
            ['status','default', 'value' => self::STATUS_ON],
            ['time', 'default', 'value' => time()],
            ['slug', 'default', 'value' => null],
            ['social','safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('easyii', 'Title'),
            'position' => Yii::t('easyii', 'Position'),
            'text' => Yii::t('easyii', 'Text'),
            'short' => Yii::t('easyii', 'Short'),
            'image' => Yii::t('easyii', 'Image'),
            'time' => Yii::t('easyii', 'Date'),
            'slug' => Yii::t('easyii', 'Slug'),
            'tagNames' => Yii::t('easyii', 'Tags'),
            'status' => Yii::t('easyii', 'Status'),
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
                'requireTranslations' => true,
                'dynamicLangClass' => true,
                'defaultLanguage' => yii::$app->language,
                'langForeignKey' => 'doctor_id',
                'tableName' => "easyii_doctor_lang",
                'attributes' => [
                    'name', 'position', 'text', 'slug', 'short'
                ]
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->social = serialize($this->social);

        return true;
    }

    public function getPhotos()
    {
        return $this->hasMany(Photo::className(), ['item_id' => 'id'])->where(['class' => self::className()])->orderBy('order_num DESC');
    }

    public function afterDelete()
    {
        parent::afterDelete();

        User::findOne($this->user_id)->delete();

        foreach($this->getPhotos()->all() as $photo){
            $photo->delete();
        }
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getDepartments()
    {
        return Department::find()
            ->localized(yii::$app->language)
            ->asArray()
            ->all();
    }

    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'department_id'])
            ->localized(yii::$app->language);
    }
}