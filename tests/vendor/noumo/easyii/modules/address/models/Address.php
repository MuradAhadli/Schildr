<?php

namespace yii\easyii\modules\address\models;


use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\Taggable;
use yii\easyii\models\Photo;
use yii\helpers\StringHelper;

class Address extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const  IMAGE_WIDTH = 1200;
    const IMAGE_HEIGHT = 750;

    public static function tableName()
    {
        return 'easyii_address';
    }

    public function rules()
    {
        return [
            [['title','general_address', 'phone', 'email','coor_x','coor_y'], 'required'],
            [['title', 'email', 'phone','web'], 'string', 'max' => 128],
            ['email', 'email'],
            ['image', 'image', 'extensions' => 'png, PNG, jpg, JPG, jpeg, JPEG, svg'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            ['created_at', 'default', 'value' => time()],
            ['status', 'default', 'value' => self::STATUS_ON],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('easyii', 'Title'),
            'image' => Yii::t('easyii', 'Image'),
        ];
    }

    public function getPhotos()
    {
        return $this->hasMany(Photo::className(), ['item_id' => 'id'])->where(['class' => self::className()])->orderBy('order_num DESC');
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $settings = Yii::$app->getModule('admin')->activeModules['adress']->settings;

            if (!$insert && $this->image != $this->oldAttributes['image'] && $this->oldAttributes['image']) {
                @unlink(Yii::getAlias('@webroot') . $this->oldAttributes['image']);
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        if ($this->image) {
            @unlink(Yii::getAlias('@webroot') . $this->image);
        }

        foreach ($this->getPhotos()->all() as $photo) {
            $photo->delete();
        }
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }


    public static function getAllAddress()
    {
        return Self::find()
            ->select([
                'easyii_address.id',
                'easyii_address.image',
                'easyii_address.status',
                'easyii_address.created_at',
                'easyii_address.updated_at',
            ])
            ->where(['language' => yii::$app->language])
            ->asArray()
            ->all();
    }
}