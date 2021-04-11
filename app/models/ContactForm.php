<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13.04.2018
 * Time: 12:32
 */

namespace app\models;

use yii;
use yii\base\Model;
use yii\easyii\modules\feedback\models\Feedback;

class ContactForm extends Feedback
{
    public function rules()
    {
        $rules = [
            [['name', 'surname', 'street', 'zip_code', 'city', 'tel_no', 'email', 'message'], 'required'],
            ['email', 'trim'],
            ['email', 'email'],
            ['user_id', 'integer'],
        ];

        if (yii::$app->user->isGuest) {
            $rules[] =
                [['email', 'first_name', 'last_name', 'tel_no'], 'required'];
        }

        return $rules;
    }

    public function attributeLabels()
    {
        return [
            'name' => yii::t('db', 'Firstname'),
            'surname' => yii::t('db', 'Lastname'),
            'email' => yii::t('db', 'email'),
            'phone' => yii::t('db', 'phone'),
            'subject' => yii::t('db', 'Subject'),
            'text' => yii::t('db', 'Message'),
            'reCaptcha' => yii::t('db', 'reCaptcha'),
        ];
    }
}