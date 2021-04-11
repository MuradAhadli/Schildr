<?php
namespace yii\easyii\modules\mailaddresses\models;

use Yii;
use yii\easyii\behaviors\CacheFlush;
use yii\easyii\behaviors\SortableModel;

class Mailaddresses extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const CACHE_KEY = 'easyii_mailaddresses';

    public static function tableName()
    {
        return 'easyii_mailaddresses';
    }

    public function rules()
    {
        return [
            [['name','tech_name', 'email'], 'required'],
            [['name', 'tech_name'], 'trim'],
            ['status', 'integer'],
            ['email', 'email'],
            ['status', 'default', 'value' => self::STATUS_ON],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('easyii', 'Name'),
            'technical_name' => Yii::t('easyii', 'Techical name'),
            'email' => Yii::t('easyii', 'Email'),
        ];
    }

    public function behaviors()
    {
        return [
            CacheFlush::className(),
            SortableModel::className()
        ];
    }
}