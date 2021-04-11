<?php

namespace yii\easyii\models;

use Yii;
use yii\easyii\components\ActiveRecord;

use yii\easyii\validators\EscapeValidator;
use yii\helpers\VarDumper;
use yii\web\ForbiddenHttpException;

class LoginForm extends ActiveRecord
{
    const CACHE_KEY = 'SIGNIN_TRIES';

    public $email;
    public $password;
    public $rememberMe;
    private $_user = false;

    public static function tableName()
    {
        return 'easyii_loginform';
    }

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            [['email', 'password'], EscapeValidator::className()],
            [['email'], 'email'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => Yii::t('easyii', 'Email'),
            'password' => Yii::t('easyii', 'Password'),
            'remember' => Yii::t('easyii', 'Remember me')
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('easyii', 'Incorrect username or password.'));
            }
        }
    }

    public function login()
    {
        $cache = Yii::$app->cache;

        $user = $this->getUser();

        if(($tries = (int)$cache->get(self::CACHE_KEY)) > 5){
            $this->addError('email', Yii::t('easyii', 'You tried to login too often. Please wait 5 minutes.'));
//            return false;
        }

        if ($this->validate()) {
            return Yii::$app->user->login($user, $this->rememberMe ? 3600*24*30 : 0);
        }

        $cache->set(self::CACHE_KEY, ++$tries, 300);

        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}
