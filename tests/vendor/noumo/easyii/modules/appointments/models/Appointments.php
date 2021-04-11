<?php
namespace yii\easyii\modules\appointments\models;

use Yii;
use yii\easyii\models\Constants;
use yii\easyii\modules\doctor\models\Doctor;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\VarDumper;
use yii\easyii\models\User;

/**
 * This is the model class for table "easyii_appointments".
 *
 * @property int $id
 * @property int $doctor_id
 * @property int $user_id
 * @property int $created_at
 * @property string $comment
 * @property string $decline_comment
 * @property int $status
 */
class Appointments extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const STATUS_NEW = 0;
    const STATUS_WAIT = 1;
    const STATUS_DECLINE = 2;
    const STATUS_ACCEPT = 3;

    public static function tableName()
    {
        return 'easyii_randevu';
    }

    public function rules()
    {
        return [
//            ['username', 'string', 'max' => 255],
//            ['email', 'email'],
//            ['phone', 'string', 'max' => 20],
//            ['message', 'string', 'max' => 500],
//            ['birthday', 'string', 'max' => 10],
//            [['doctor_id', 'user_id'], 'integer'],
            ['exact_time', 'safe'],
            ['doctor_message', 'string']
//            [['created_at', 'status'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('easyii', 'ID'),
            'doctor_id' => Yii::t('easyii', 'Doctor'),
            'day' => Yii::t('easyii', 'Day'),
            'hour_from' => Yii::t('easyii', 'Hour From'),
            'hour_to' => Yii::t('easyii', 'Hour To'),
            'status' => Yii::t('easyii', 'Status'),
            'exact_time' => Yii::t('db', 'Exact Time'),
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        return true;
    }

    public function getDoctors()
    {
        return Doctor::find()
            ->localized(yii::$app->language)
            ->asArray()
            ->all();
    }

    public function getDoctor()
    {
        return Doctor::find()
            ->where(['easyii_doctor.id' => $this->doctor_id])
            ->joinWith('user')
            ->asArray()
            ->one();
    }

    public function getDoctorName()
    {
        return Doctor::find()
            ->localized(yii::$app->language)
            ->where(['id' => $this->doctor_id])
            ->asArray()
            ->one()['translation']['name'];
    }

    public function getPatientName()
    {
        $user = User::find()
            ->select('firstname, lastname')
            ->where(['id' => $this->user_id])
            ->asArray()
            ->one();

        return $user['firstname'].' '.$user['lastname'];
    }

    public function getPatient()
    {
        if($this->user_id) {
            $patient = User::find()
                ->select('
                    firstname, 
                    lastname,
                    birthday,
                    phone,
                    email
                ')
                ->where(['id' => $this->user_id])
                ->asArray()
                ->one();

            $patient['username'] = $patient['firstname'].' '.$patient['lastname'];

            unset($patient['firstname'], $patient['lastname']);

//            VarDumper::dump($patient,10,1); die();
        }
        else {
            $patient = [
                'username' => $this->username,
                'birthday' => $this->birthday,
                'phone' => $this->phone,
                'email' => $this->email,
            ];
        }

        return $patient;
    }

    public function getUsername()
    {
        $user = \yii\easyii\models\User::find()
            ->select('firstname, lastname')
            ->where(['id' => $this->user_id])
            ->asArray()
            ->one();

        return $user['firstname'].' '.$user['lastname'];
    }

    public function getStatusLabel()
    {
        switch ($this->status) {
            case self::STATUS_NEW:
                $status = 'white';
                break;
            case self::STATUS_ACCEPT:
                    $status = 'success';
                    break;
            case  self::STATUS_DECLINE:
                    $status = 'danger';
                    break;

            case  self::STATUS_WAIT:
                    $status = 'warning';
                    break;
            default:
                break;
        }

        return $status;
    }

    public function getRandevuTime()
    {
        if($this->status == self::STATUS_ACCEPT || $this->status == $this::STATUS_DECLINE) {

            return date('d.m.y, h:i', $this->exact_time);
        }
        else {
            return $this->date_from.' - '.$this->date_to;
        }
    }
    public static function getCountNew(){

      $model = Appointments::find()
          ->where(['status' => 0])
          ->asArray()
          ->all();
      return count($model);
    }
}