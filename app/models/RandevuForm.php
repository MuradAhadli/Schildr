<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/21/2018
 * Time: 12:24 PM
 */

namespace app\models;

use yii;
use yii\easyii\modules\appointments\models\Appointments;

class RandevuForm extends Appointments
{
    public $date;
    public $reCaptcha;

    public function rules()
    {
        $rules = [
            [['doctor_id', 'date'], 'required'],
            ['username', 'string', 'max' => 255],
            ['email', 'email'],
            ['phone', 'string', 'max' => 20],
            ['message', 'string', 'max' => 500],
            ['birthday', 'string'],
            [['doctor_id', 'user_id', 'status'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_NEW],
            ['date', 'string', 'max' => 30],
            [['date_from', 'date_to', 'user_lang'], 'safe'],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className()]
        ];

        if(yii::$app->user->isGuest) {

            $rules[] = [['username', 'email', 'phone'], 'required'];
        }

        return $rules;
    }

    public function attributeLabels()
    {
        return [
            'doctor_id' => yii::t('db', 'Doctor'),
            'date' => yii::t('db', 'date'),
            'birthday' => yii::t('db', 'birthday'),
            'username' => yii::t('db', 'Firstname and Lastname'),
            'phone' => yii::t('db', 'phone'),
            'email' => yii::t('db', 'email'),
            'message' => yii::t('db', 'Message'),
            'reCaptcha' => yii::t('db', 'reCaptcha'),
        ];
    }

    public function getDoctors()
    {
        return Department::getDoctorsOptGroup();
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $date = explode(' - ', $this->date);

        $this->date_from = $date[0];
        $this->date_to = $date[1];

        $this->created_at = time();

        $this->birthday = strtotime($this->birthday);

        $this->user_lang = yii::$app->language;

        return true;

    }
}