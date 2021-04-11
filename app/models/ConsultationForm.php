<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13.04.2018
 * Time: 12:32
 */

namespace app\models;


use yii\base\Model;
use yii;

class ConsultationForm extends Model
{
    public $text;
//    public $gender;
    public $phone;
    public $private;
    public $birthday;
    public $firstname;
    public $lastname;
    public $email;
    public $assign;
    public $department_id;
    public $created_by;
    public $reCaptcha;

    const PRIVATE_ON = 0;
    const PRIVATE_OFF = 1;


    public function rules()
    {
        if ($_POST){
            $post = $_POST;
        }else{
            $post['ConsultationForm']['private'] = 0;
        }

        $rules = [
            [['text', 'assign'], 'required'],
            [['assign', 'department_id'], 'trim'],
            ['private', 'integer'],
            ['email', 'email'],
            [['email', 'assign', 'department_id', 'phone', 'birthday', 'text'], 'trim'],
            [['created_by','private'], 'integer'],
            [['firstname'], 'string', 'max' => 128],
        ];

        if (empty(yii::$app->user->id) && $post['ConsultationForm']['private'] == 0){

            $rules[] =  [
                ['email', 'firstname', 'phone'], 'required',

            ];

        }elseif ($post['ConsultationForm']['private'] == 1){

            $rules[] = [
                ['email'], 'required'
            ];
        }

        if(!yii::$app->request->isAjax) {

            $rules[] = [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className()];
        }

        return $rules;
    }

    public function attributeLabels()
    {
        return [
            'assign' => yii::t('db', 'Doctor'),
            'firstname' => yii::t('db', 'Firstname and Lastname'),
            'email' => yii::t('db', 'email'),
            'phone' => yii::t('db', 'phone'),
            'birthday' => yii::t('db', 'birthday'),
            'text' => yii::t('db', 'Message'),
            'reCaptcha' => yii::t('db', 'reCaptcha'),
        ];
    }

    public static function getDepartments(){

        $model = Department::find()
            ->select(
                'easyii_department.id,
                easyii_department_lang.name,
                ')
            ->leftJoin('easyii_department_lang','easyii_department_lang.department_id = easyii_department.id')
            ->where([
                'status' => 1,
                'language' => yii::$app->language
            ])
            ->where(['status' => 1])
            ->orderBy('time DESC')
            ->asArray()
            ->all();

        $model = yii\helpers\ArrayHelper::map($model, 'id', 'name');

        return $model;
    }

    public static function getDoctors()
    {
        $model = Doctor::find()
            ->select('
                easyii_doctor.id,
                easyii_doctor_lang.name,
            ')
            ->leftJoin('easyii_doctor_lang', 'easyii_doctor_lang.doctor_id = easyii_doctor.id')
            ->where([
                'easyii_doctor.status' => 1,
                'easyii_doctor_lang.language' => yii::$app->language,
            ])
            ->orderBy('time DESC')
            ->asArray()
            ->all();
        return $model;
    }

    public static function getDepDoctors()
    {
        $departments = Department::find()
            ->joinWith('doctors')
            ->asArray()
            ->all();

        return yii\helpers\ArrayHelper::map($departments, 'id', 'doctors');
    }

}