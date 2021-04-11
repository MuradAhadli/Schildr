<?php

namespace app\models\user;

use Yii;

use yii\base\Model;
use yii\easyii\validators\EscapeValidator;
use yii\easyii\models\User;
use yii\helpers\VarDumper;

class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe;
    public $reCaptcha;
    private $_user = false;

    public static function tableName()
    {
        return 'easyii_loginform';
    }

    public function rules()
    {
        $rules = [
            [['email', 'password'], 'required'],
            [['email', 'password'], EscapeValidator::className()],
            [['email'], 'email'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
        ];

        if (!yii::$app->request->isAjax) {
            $rules[] =  [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className()];

            // password is validated by validatePassword()
            $rules[] = ['password', 'validatePassword'];
        }

        return $rules;
    }

    public function attributeLabels()
    {
        return [
            'email' => Yii::t('db', 'email'),
            'password' => Yii::t('db', 'Password'),
            'rememberMe' => Yii::t('db', 'Yadda saxla')
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('db', 'Incorrect username or password.'));
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }

        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findUserByEmail($this->email);
        }

        return $this->_user;
    }
}
