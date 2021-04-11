<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/5/2018
 * Time: 5:25 PM
 */

namespace app\models;


use yii\db\ActiveRecord;
use yii\easyii\modules\subscribe\models\Subscriber;
use yii;

class SubscribeForm extends Subscriber
{
    public $reCaptcha;

    const TOKEN_KEY = 'subs_email_ver_mediland';

    public function rules()
    {
        $rules = parent::rules();

        if (!yii::$app->request->isAjax) {
            $rules[] =  [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className()];
        }

        return $rules;
    }

    public function attributeLabels()
    {
        return [
            'email' => yii::t('db', 'email')
        ];
    }
}