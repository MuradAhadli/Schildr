<?php
namespace yii\easyii\modules\subscribe\models;

use Yii;

class Subscriber extends \yii\easyii\components\ActiveRecord
{
    const FLASH_KEY = 'eaysiicms_subscribe_send_result';

    public static function tableName()
    {
        return 'easyii_subscribe_subscribers';
    }

    public function rules()
    {
        $rules = [
            ['email', 'required'],
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'unique', 'filter' => function($query) {
                return $query->andWhere(['status' => 1]);
            }],
            ['status', 'integer', 'max' => 1],
            ['status', 'default', 'value' => 0],

            ['token', 'string', 'max' => 255],
        ];

        return $rules;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($insert){
                $this->ip = Yii::$app->request->userIP;
                $this->time = time();
            }
            return true;
        } else {
            return false;
        }
    }

    public function attributeLabels()
    {
        return [
            'email' => 'E-mail',
        ];
    }
}