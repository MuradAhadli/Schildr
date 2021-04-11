<?php
namespace yii\easyii\modules\language\models;

use Yii;
use yii\easyii\behaviors\CacheFlush;

class Message extends \yii\easyii\components\ActiveRecord
{
    const CACHE_KEY = 'message';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'language'], 'required'],
            [['id'], 'integer'],
            [['translation'], 'trim'],
            [['language'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'language' => Yii::t('app', 'Language'),
            'translation' => Yii::t('app', 'Translation'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(SourceMessage::className(), ['id' => 'id']);
    }

    public function getMessageKey()
    {
        return SourceMessage::find()
            ->where(['source_message.id' => $this->id])
            ->asArray()
            ->one()['message'];
    }

    public function behaviors()
    {
        return [
            CacheFlush::className()
        ];
    }
}