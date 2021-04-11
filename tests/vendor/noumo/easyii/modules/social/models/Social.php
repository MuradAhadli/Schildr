<?php
namespace yii\easyii\modules\social\models;

use Yii;
use yii\easyii\behaviors\CacheFlush;

class Social extends \yii\easyii\components\ActiveRecord
{
    const CACHE_KEY = 'easyii_social';
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'easyii_social';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['icon', 'color', 'link', 'time'], 'required'],
            ['status','default', 'value' => self::STATUS_ON],
            [['time', 'status'], 'integer'],
            [['icon', 'link'], 'string', 'max' => 128],
            [['color'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('easyii', 'ID'),
            'icon' => Yii::t('easyii', 'Icon'),
            'color' => Yii::t('easyii', 'Color'),
            'link' => Yii::t('easyii', 'Link'),
            'time' => Yii::t('easyii', 'Time'),
            'status' => Yii::t('easyii', 'Status'),
        ];
    }

    public function behaviors()
    {
        return [
            CacheFlush::className()
        ];
    }
}