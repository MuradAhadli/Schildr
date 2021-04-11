<?php
namespace yii\easyii\modules\checkupform\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\Taggable;
use yii\easyii\models\Photo;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\VarDumper;
use yii\easyii\modules\checkup\models\CheckUp as CheckupName;

class CheckUp extends \yii\easyii\components\ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_SEEN = 1;
    const STATUS_CONTACT = 2;

    public static function tableName()
    {
        return 'easyii_checkup_form';
    }

    public function rules()
    {
        return [
            [['username','email', 'phone', 'text'], 'required'],
            [['username','text', 'birthday'], 'trim'],
            [['username'], 'string', 'max' => 128],
            [['status', 'user_id', 'checkup_id'], 'integer'],
            ['created_at', 'default', 'value' => time()],
            ['status', 'default', 'value' => self::STATUS_NEW],
            ['email','email']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('easyii', 'Username'),
            'text' => Yii::t('easyii', 'Text'),
            'email' => Yii::t('easyii', 'E-mail'),
            'phone' => Yii::t('easyii', 'Phone'),
            'Created_at' => Yii::t('easyii', 'Created at'),
        ];
    }

    public static function getStatusClass($status)
    {
        switch ($status){
            case '0':
                echo '';
                break;
            case '1':
                echo 'warning';
                break;
            case '2':
                echo 'success';
                break;
        }
    }

    public static function getStatusSituation($status)
    {
        switch ($status){
            case '1':
                echo 'Baxilib';
                break;
            case '2':
                echo 'Əlaqə saxlanılıb';
                break;
        }
    }
}








