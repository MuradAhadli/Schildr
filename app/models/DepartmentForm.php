<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13.04.2018
 * Time: 12:32
 */

namespace app\models;

use yii;
use yii\easyii\modules\feedback\models\Feedback;
use yii\helpers\Html;

class DepartmentForm extends Feedback
{
    public $reCaptcha;

    public function rules()
    {
        $rules =  [
            [ 'text', 'required'],
            [['name'], 'string'],
            [['email', 'phone'], 'trim'],

            ['email', 'email'],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className()]
        ];

        if(yii::$app->user->isGuest) {

            $rules[] =
                [
                    'email', 'required', 'message' => Html::encode(yii::t('db', 'Email or Phone can not be blank.')), 'when' => function ($model) {
                        return $model->phone == null;
                    },
                    'whenClient' => "function (attribute, value) {
                         return $('#departmentform-phone').val() == '';
                    }"
                ];

            $rules[] =
                [
                    'phone', 'required', 'message' => Html::encode(yii::t('db', 'Phone or Email can not be blank.')), 'when' => function ($model) {
                        return $model->email == null;
                    },
                    'whenClient' => "function (attribute, value) {
                        return $('#departmentform-email').val() == '';
                    }"
                ];
        }

        return $rules;
    }

    public function attributeLabels()
    {
        return [
            'name' => yii::t('db', 'Firstname and Lastname'),
            'email' => yii::t('db', 'email'),
            'phone' => yii::t('db', 'phone'),
            'text' => yii::t('db', 'Message'),
            'reCaptcha' => yii::t('db', 'reCaptcha'),
        ];
    }
}