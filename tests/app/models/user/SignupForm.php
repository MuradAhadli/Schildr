<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/13/2018
 * Time: 11:40 AM
 */

namespace app\models\user;


use yii\base\Model;
use yii\easyii\models\User;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii;

/**
 * Class SignupForm
 * @package app\models
 */
class SignupForm extends Model
{
    public $firstname;
    public $lastname;
    public $patronymic;
    public $birthday;
    public $email;
    public $phone;
    public $password;
    public $gender;
    public $reCaptcha;
    public $rememberMe;
    
    public function rules()
    {
        $rules = [
            [['email','birthday'], 'trim'],
            [['email', 'phone', 'password', 'firstname', 'lastname', 'gender'], 'required'],
            ['email', 'email'],
            [['email', 'phone', 'patronymic'], 'string', 'max' => 255],
            [
                'email',
                'unique',
                'targetClass' => 'yii\easyii\models\User',
                'message' => Html::encode(yii::t('db', 'This email address is already in use. try another one')),
                'on' => 'create'
            ],
            [
                'phone',
                'unique',
                'targetClass' => 'yii\easyii\models\User',
                'message' => Html::encode(yii::t('db', 'This phone is already in use. try another one')),
                'on' => 'create'
            ],

            ['rememberMe', 'boolean'],

            ['gender', 'integer'],
            ['gender', 'in', 'range' => [User::GENDER_MALE, User::GENDER_FEMALE]],

            [['password'], 'required', 'on' => 'create'],
            ['password', 'string', 'min' => 6],
        ];

        if (!yii::$app->request->isAjax) {
            $rules[] =  [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className()];
        }

        return $rules;
    }

    public function attributeLabels()
    {
        return [
            'rememberMe' => Yii::t('db', 'Remember me'),
            'firstname' => Yii::t('db', 'Firstname'),
            'lastname' => Yii::t('db', 'Lastname'),
            'gender' => Yii::t('db', 'Gender'),
            'email' => Yii::t('db', 'email'),
            'patronymic' => Yii::t('db', 'patronymic'),
            'birthday' => Yii::t('db', 'birthday'),
            'phone' => Yii::t('db', 'phone'),
            'password' => Yii::t('db', 'Password'),
            'reCaptcha' => Yii::t('db', 'reCaptcha'),
        ];
    }
    
    public function signup()
    {
        $user = new User();

        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->patronymic = $this->patronymic;
        $user->birthday = $this->birthday;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->gender = $this->gender;
        $user->birthday = strtotime($this->birthday);
        $user->status = User::STATUS_ACTIVE;
        $user->role = User::ROLE_USER;
        
        $user->setPassword($this->password);
        $user->generateAuthKey();

        if($user->save()) {

            return $user;
        }

        throw new BadRequestHttpException();
    }
}