<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 2/26/2018
 * Time: 12:54 PM
 */

namespace yii\easyii\modules\doctor\models;

use yii;
use yii\easyii\helpers\Image;
use yii\easyii\helpers\Upload;
use \yii\easyii\models\User;
use yii\base\Model;
use yii\helpers\VarDumper;
use yii\web\JsExpression;
use yii\web\UploadedFile;

class UserForm extends Model
{
    public $birthday;
    public $email;
    public $phone;
    public $image;
    public $password;
    public $password_repeat;
    public $status;

    const IMAGE_WIDTH = 380;
    const IMAGE_HEIGHT = 325;
    const STATUS_OFF = 0;
    const STATUS_ON = 10;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            [['email', 'birthday'], 'required'],
            ['email', 'email'],
            ['status', 'default', 'value' => self::STATUS_ON],
            [['email', 'phone'], 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\yii\easyii\models\User', 'message' => 'This email address has already been taken.', 'on' => 'create'],
            [['password', 'password_repeat'], 'required', 'on' => 'create'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'required',

                'when' => function($model) {
                    return $model->password != '';
                },
                'whenClient' => new JsExpression("
                    function (attribute, value) {
                        return $('#userform-password').val() != '';
                    }
                ")
            ],
            ['password', 'compare', 'compareAttribute' => 'password_repeat', 'message'=>"Passwords don't match"],
            ['image', 'image',  'minWidth' => self::IMAGE_WIDTH, 'minHeight' => self::IMAGE_HEIGHT, 'maxSize' => 1024 * 1024 * 10, 'extensions' => 'jpg, png']
        ];
    }

    public function attributeLabels()
    {
        return [
            'status' => Yii::t('easyii', 'User status'),
        ];
    }


    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        $user = new User();

        $this->upload($user);

        if($this->status != 1){
            $user->status = 0;
        }else{
            $user->status = 10;
        }

        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->birthday = strtotime(str_replace('/', '-', $this->birthday));
        $user->role = User::ROLE_DOCTOR;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        $user->save(false);

        return $user;
    }

    public function update($id)
    {
        $user = User::findOne($id);

        $this->upload($user);

        if($this->status != 1){
            $user->status = 0;
        }else{
            $user->status = 10;
        }

        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->birthday = strtotime(str_replace('/', '-', $this->birthday));

        if($this->password) {

            $user->setPassword($this->password);
            $user->generateAuthKey();
        }

        $user->save(false);

        return $user;
    }

    public function upload($user)
    {
        if(isset($_FILES)){
            $user->image = UploadedFile::getInstance($this, 'image');
            if($user->image && $user->validate(['image'])){
                $user->image = Image::upload($user->image, 'user', self::IMAGE_WIDTH, self::IMAGE_HEIGHT, true);
            }
            else{
                $user->image = isset($user->oldAttributes['image']) ? $user->oldAttributes['image'] : '';
            }
        }
    }

}