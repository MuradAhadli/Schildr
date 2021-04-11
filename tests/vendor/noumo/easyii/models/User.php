<?php

namespace yii\easyii\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\easyii\modules\doctor\models\Doctor;
use yii\helpers\VarDumper;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const ROLE_USER = 1;
    const ROLE_DOCTOR = 2;
    const ROLE_ADMIN = 3;
    const ROLE_ROOT = 4;

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    public static function tableName()
    {
        return '{{easyii_user}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByEmail($email)
    {
        return static::find()
            ->where([
                'email' => $email,
                'status' => self::STATUS_ACTIVE,
            ])
            ->andWhere(['<>', 'role', self::ROLE_USER])
            ->one();
    }

    public static function findUserByEmail($email)
    {
        return static::find()
            ->where([
                'email' => $email,
                'status' => self::STATUS_ACTIVE,
                'role' => self::ROLE_USER
            ])
            ->one();
    }

    public static function findByPasswordResetToken($token)
    {

        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function isPasswordResetTokenValid($token)
    {

        if (empty($token)) {
            return false;
        }


        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function isRoot()
    {
        return $this->role === self::ROLE_ROOT;
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isDoctor()
    {
        return $this->role === self::ROLE_DOCTOR;
    }

    public function getUsername()
    {
        if($this->firstname) {
            return $this->firstname.' '. $this->lastname;
        }

        return $this->doctorAbout['translation']['name'];
    }

    public function getDoctorAbout()
    {
        return Doctor::find()
            ->localized(yii::$app->language)
            ->where(['user_id' => $this->id])
            ->asArray()
            ->one();
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if(!$insert && $this->image != $this->oldAttributes['image'] && $this->oldAttributes['image']){
                @unlink(Yii::getAlias('@webroot').$this->oldAttributes['image']);
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        if($this->image){
            @unlink(Yii::getAlias('@webroot').$this->image);
        }
    }
}