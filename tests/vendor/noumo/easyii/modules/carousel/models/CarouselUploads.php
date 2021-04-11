<?php

namespace yii\easyii\modules\carousel\models;

use Yii;
use yii\easyii\behaviors\CacheFlush;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\SortableModel;
use yii\easyii\behaviors\Taggable;

class CarouselUploads extends \yii\easyii\components\ActiveRecord
{
    const IMAGE_MIN_WIDTH = 1540;
    const IMAGE_MIN_HEIGHT = 670;
    const IMAGE_MAX_HEIGHT = 860;

    const STATUS_OFF = 0;
    const STATUS_ON = 1;
    const CACHE_KEY = 'easyii_carousel_uploads';
    public $order_num;

    public static function tableName()
    {
        return 'easyii_carousel_uploads';
    }

    public function rules()
    {
        return [
            [['file_name', 'carousel_id'], 'required'],
            [['type'], 'integer'],
            [['order_num'], 'safe'],
        ];
    }

    public function behaviors()
    {
        return [
            SortableModel::className(),
            'seoBehavior' => SeoBehavior::className(),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!$insert && $this->file_name != $this->oldAttributes['file_name'] && $this->oldAttributes['file_name']) {
                @unlink(Yii::getAlias('@webroot') . $this->oldAttributes['file_name']);
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        @unlink(Yii::getAlias('@webroot') . $this->file_name);
    }

    public static function getCarouselUploads($carousel_id)
    {
        return self::find()
            ->select([
                'id',
                'file_name',
            ])
            ->where(['carousel_id' => $carousel_id])
            ->asArray()
            ->all();
    }
}