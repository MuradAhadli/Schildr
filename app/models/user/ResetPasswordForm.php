<?php

namespace app\models\user;

use Yii;
use yii\base\InvalidParamException;
use yii\base\Model;
use yii\easyii\models\User;
use yii\helpers\VarDumper;

/**
 * Class ResetPasswordForm
 */
class ResetPasswordForm extends Model
{
    /**
     * @var string password
     */
    public $password;

    /**
     * @var UserModel
     */
    protected $user;

    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     *
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }

        $this->user = User::findByPasswordResetToken($token);

        if (!$this->user) {
            throw new InvalidParamException('Wrong password reset token.');
        }

        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' => Yii::t('db', 'Password'),
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset
     */
    public function resetPassword()
    {
        $user = $this->user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save();
    }
}
