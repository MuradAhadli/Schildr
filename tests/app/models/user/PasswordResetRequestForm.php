<?php

namespace app\models\user;

use Yii;
use yii\base\Model;
use yii\easyii\models\User;
use yii\helpers\Html;

/**
 * Class PasswordResetRequestForm
 */
class PasswordResetRequestForm extends Model
{
    /**
     * @var string email field for password reset
     */
    public $email;
    public $reCaptcha;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [
                'email',
                'exist',
                'targetClass' => Yii::$app->user->identityClass,
                'message' => Html::encode(Yii::t('db', 'User with this email is not found.')),
            ],
            [
                'email',
                'exist',
                'targetClass' => Yii::$app->user->identityClass,
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => Html::encode(Yii::t('db', 'Your account has been deactivated, please contact support for details.')),
            ],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('db', 'email'),
            'reCaptcha' => Yii::t('db', 'reCaptcha'),
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/reset-password', 'token' => $user->password_reset_token]);

        return Yii::$app->mailer->compose('passwordResetToken', [
            'user' => $user,
            'resetLink' => $resetLink
        ])
            ->setFrom([yii::$app->params['noReplyEmail'] => yii::$app->params['senderName']])
            ->setTo($this->email)
            ->setSubject(Yii::t('db', 'Password reset for {0}', Yii::$app->name))
            ->send();
    }
}
