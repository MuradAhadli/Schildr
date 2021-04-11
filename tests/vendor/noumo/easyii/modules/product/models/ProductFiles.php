<?php
namespace yii\easyii\modules\product\models;

use Yii;
use yii\easyii\behaviors\CacheFlush;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\SortableModel;
use yii\easyii\behaviors\Taggable;

class ProductFiles extends \yii\easyii\components\ActiveRecord
{
    const IMAGE_MIN_WIDTH = 1540;
    const IMAGE_MIN_HEIGHT = 670;
    const IMAGE_MAX_HEIGHT = 860;

    const IMAGE_TYPE = 0;
    const VIDEO_TYPE = 1;

    const STATUS_OFF = 0;
    const STATUS_ON = 1;
    const CACHE_KEY = 'easyii_product_files';
    public $order_num;

    public static function tableName()
    {
        return 'easyii_product_files';
    }

    public function rules()
    {
        return [
            [['file', 'product_id'], 'required'],
            [['type'], 'integer'],
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
            if (!$insert && $this->file != $this->oldAttributes['file'] && $this->oldAttributes['file']) {
                @unlink(Yii::getAlias('@webroot') . $this->oldAttributes['file']);
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        @unlink(Yii::getAlias('@webroot') . $this->file);
    }


    /**
     * @param $product_id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getProductFiles($product_id)
    {
        return self::find()
            ->select([
                'id',
                'is_base',
                'file',
                'type',
                'order_num',
            ])
            ->where(['product_id' => $product_id])
            ->asArray()
            ->orderBy('order_num ASC')
            ->all();
    }

    public static function getAllProductFiles()
    {
        return self::find()
            ->select([
                'id',
                'is_base',
                'product_id',
                'file',
                'type',
                'order_num',
            ])
            ->orderBy('order_num ASC')
            ->asArray()
            ->all();
    }
}