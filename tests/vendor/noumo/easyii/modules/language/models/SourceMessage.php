<?php
namespace yii\easyii\modules\language\models;

use Yii;
use yii\easyii\behaviors\CacheFlush;

class SourceMessage extends \yii\easyii\components\ActiveRecord
{
    const CACHE_KEY = 'source_message';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'source_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['message'], 'unique'],
            [['category'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('easyii', 'ID'),
            'category' => Yii::t('easyii', 'Category'),
            'message' => Yii::t('easyii', 'Message'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['id' => 'id']);
    }

    public function behaviors()
    {
        return [
            CacheFlush::className()
        ];
    }

    public function beforeDelete()
    {
        Message::deleteAll(['id' => $this->id]);

        return parent::beforeDelete();
    }
}