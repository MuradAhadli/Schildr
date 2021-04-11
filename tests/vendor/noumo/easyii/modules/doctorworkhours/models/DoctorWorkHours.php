<?php
namespace yii\easyii\modules\doctorworkhours\models;

use Yii;
use yii\easyii\models\Constants;
use yii\easyii\modules\doctor\models\Doctor;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "easyii_doctor_work_hours".
 *
 * @property int $id
 * @property int $doctor_id
 * @property int $day
 * @property int $hour_from
 * @property int $hour_to
 * @property int $status
 */
class DoctorWorkHours extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    public static function tableName()
    {
        return 'easyii_doctor_work_hours';
    }

    public function rules()
    {
        return [
            [['doctor_id', 'day', 'hour_from', 'hour_to'], 'required'],
            [['doctor_id', 'status'], 'integer'],
            [['hour_from', 'hour_to'], 'string', 'max' => 5],
            ['status', 'default', 'value' => Constants::STATUS_ON]
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
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->day = serialize($this->day);

        $this->hour_from = strtotime($this->hour_from);
        $this->hour_to = strtotime($this->hour_to);

        return true;
    }

    public function getDoctors()
    {
        return Doctor::find()
            ->localized(yii::$app->language)
            ->asArray()
            ->all();
    }

    public function getDoctorName()
    {
        return Doctor::find()
            ->localized(yii::$app->language)
            ->where(['id' => $this->doctor_id])
            ->asArray()
            ->one()['translation']['name'];
    }

    public function getHourFrom()
    {
        return date('H:i', $this->hour_from);
    }

    public function getHourTo()
    {
        return date('H:i', $this->hour_to);
    }
}