<?php

namespace yii\easyii\modules\project\models;

use app\models\ProjectLang;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\Taggable;
use yii\easyii\models\Photo;
use yii\easyii\modules\project\models\EasyiiProject;
use yii\helpers\StringHelper;

class Project extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const IMAGE_WIDTH = 1250;
    const IMAGE_HEIGHT = 720;


    public static function tableName()
    {
        return 'easyii_project';
    }

    public function rules()
    {
        return [
            [['title', 'subtitle', 'category_id'], 'required'],
            [['created_date', 'updated_date', 'status'], 'integer'],
            ['image', 'image', 'maxFiles' => 10, 'minWidth' => self::IMAGE_WIDTH, 'minHeight' => self::IMAGE_HEIGHT, 'maxSize' => 1024 * 1024 * 10, 'extensions' => 'png, PNG, jpg, JPG, jpeg, JPEG,'],
            ['logo', 'image', 'extensions' => 'png, PNG, jpg, JPG, jpeg, JPEG,'],
            ['created_date', 'default', 'value' => time()],
            ['status', 'default', 'value' => self::STATUS_ON],
        ];
    }

    public function attributeLabels()
    {
        return [];
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
                'langForeignKey' => 'project_id',
                'tableName' => "easyii_project_lang",
                'attributes' => [
                    'title', 'subtitle',
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

    public static function getAllProject()
    {
        return self::find()
            ->select([
                'easyii_project.id',
                'easyii_project_lang.title',
            ])
            ->where([
                'language' => yii::$app->language,
            ])
            ->leftJoin('easyii_project_lang', 'easyii_project.id = easyii_project_lang.project_id')
            ->asArray()
            ->all();
    }
}