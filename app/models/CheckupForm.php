<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 24.04.2018
 * Time: 15:14
 */

namespace app\models;

use yii;
use \yii\easyii\modules\checkupform\models\CheckUp;

class CheckupForm extends CheckUp
{
    public $reCaptcha;

    public function rules()
    {
        $rules = parent::rules();

        $rules[] =  [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className()];

        return $rules;
    }

    public function attributeLabels()
    {
        return [
            'username' => yii::t('db', 'Firstname and Lastname'),
            'email' => yii::t('db', 'email'),
            'phone' => yii::t('db', 'phone'),
            'birthday' => yii::t('db', 'birthday'),
            'text' => yii::t('db', 'Additional Information'),
            'reCaptcha' => yii::t('db', 'reCaptcha'),
        ];
    }

}