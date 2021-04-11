<?php
namespace yii\easyii\modules\consultation\models;

use app\components\Helpers;
use app\components\User;
use app\models\Doctor;
use app\models\user\VerificationCodeForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\easyii\behaviors\CalculateNotice;
use yii\easyii\helpers\Mail;
use yii\easyii\models\Setting;
use yii\easyii\modules\department\models\Department;
use yii\easyii\validators\ReCaptchaValidator;
use yii\easyii\validators\EscapeValidator;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\easyii\modules\mailaddresses\models\Mailaddresses;

class Consultation extends \yii\easyii\components\ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_VIEW = 1;
    const STATUS_ANSWERED = 2;

    const FLASH_KEY = 'eaysiicms_consultation_send_result';

    public $reCaptcha;

    public static function tableName()
    {
        return 'easyii_consultation';
    }

    public function rules()
    {
        return [
            [['text', 'answer_subject', 'answer_text', 'token'], 'required'],
            [['email', 'text', 'assign', 'department_id', ], 'trim'],
            [['created_by', 'gender'], 'integer'],
            [['text'], EscapeValidator::className()],
            [['firstname' , 'lastname'], 'string', 'max' => 128],
            ['email', 'email'],
            ['user_lang', 'safe']
//            ['phone', 'match', 'pattern' => '/^[\d\s-\+\(\)]+$/'],
//            ['reCaptcha', ReCaptchaValidator::className(), 'when' => function($model){
//                return $model->isNewRecord && Yii::$app->getModule('admin')->activeModules['consultation']->settings['enableCaptcha'];
//            }],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($insert){
//                $this->ip = Yii::$app->request->userIP;
                $this->created_at = time();
                $this->status = self::STATUS_NEW;

                $this->user_lang = yii::$app->language;
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if($insert){
//            $this->mailAdmin();
        }
    }

    public function attributeLabels()
    {
        return [
            'email' => 'E-mail',
            'answer_subject' => Yii::t('db', 'Answer subject'),
            'answer_text' => Yii::t('db', 'Answer text'),
//            'title' => Yii::t('easyii', 'Title'),
//            'text' => Yii::t('easyii', 'Text'),
//            'answer_subject' => Yii::t('easyii/consultation', 'Subject'),
//            'answer_text' => Yii::t('easyii', 'Text'),
//            'phone' => Yii::t('easyii/consultation', 'Phone'),
//            'reCaptcha' => Yii::t('easyii', 'Anti-spam check')
        ];
    }

    public function behaviors()
    {
        return [
            'cn' => [
                'class' => CalculateNotice::className(),
                'callback' => function(){
                    return self::find()->status(self::STATUS_NEW)->count();
                }
            ]
        ];
    }

    public function mailAdmin()
    {
        $settings = Yii::$app->getModule('admin')->activeModules['consultation']->settings;

        if(!$settings['mailAdminOnNewConsultation']){
            return false;
        }
        return Mail::send(
            Setting::get('admin_email'),
            $settings['subjectOnNewConsultation'],
            $settings['templateOnNewConsultation'],
            ['consultation' => $this, 'link' => Url::to(['/admin/consultation/a/view', 'id' => $this->primaryKey], true)]
        );
    }

    public function sendAnswer()
    {
        $settings = Yii::$app->getModule('admin')->activeModules['consultation']->settings;

        if($this->private == 0) {

            $sms_text = Helpers::strToLatin('Hekimin cavabi:' . $this->answer_text);

            VerificationCodeForm::sendSms(
                User::smsNumber($this->phone),
                $sms_text
            );

        }

        $mailAddress = Mailaddresses::find()->select('email')->where(['tech_name' => 'consultation'])->one();

        $text = 'Hörmətli pasient, sizin sualınız həkimimiz tərəfindən cavablandırıldı.<br />
                          <b>Sual: </b>'. $this->text.'<br>
                          <b>Cavab: </b>'.$this->answer_text.'<br>';

        return Yii::$app->mailer->compose('common', [
            'text' => $text
        ])
            ->setFrom([yii::$app->params['noReplyEmail'] => yii::$app->params['senderName']])
            ->setTo($this->email, $mailAddress->email)
            ->setSubject('Mediland Hospital - Suala cavab')
            ->send();
    }

    public function getDoctors()
    {
        $model = Doctor::find()
            ->select('easyii_doctor.id, easyii_doctor_lang.name')
            ->leftJoin('easyii_doctor_lang', 'easyii_doctor_lang.doctor_id = easyii_doctor.id')
            ->where([
                'language' => yii::$app->language,
                'status' => 1
            ])
            ->asArray()
            ->all();

        return ArrayHelper::map($model, 'id', 'name');

    }

    public static function getDoctor($id)
    {
        return Doctor::find()
            ->leftJoin('easyii_doctor_lang', 'easyii_doctor_lang.doctor_id = easyii_doctor.id')
            ->where([
                'easyii_doctor.id' => $id,
                'language' => yii::$app->language
            ])
            ->one()['name'];

    }

    public function getDoctorUser($id)
    {
        return Doctor::find()
            ->where(['easyii_doctor.id' => $id])
            ->joinWith('user')
            ->asArray()
            ->one();
    }

    public static function getDepartment($id)
    {
        return Department::find()
            ->leftJoin('easyii_department_lang', 'easyii_department_lang.department_id = easyii_department.id')
            ->where([
                'easyii_department.id' => $id,
                'language' => yii::$app->language
            ])
            ->one()['name'];

    }
    public static function getWhere(){
        $where = '';
        if (yii::$app->user->identity->isDoctor()){
            $where = ['assign' => yii::$app->user->id];
        }
        return $where;
    }

    public static function getCountNoAnswer(){

       $where = Consultation::getWhere();

        $data = new ActiveDataProvider([
            'query' => Consultation::find()->where($where)->status(Consultation::STATUS_VIEW)->asc(),
        ]);

        return $data->count;
    }

    public static function getCountNew(){

        $where = Consultation::getWhere();

        $data = new ActiveDataProvider([
            'query' => Consultation::find()->where($where)->status(Consultation::STATUS_NEW)->asc(),
        ]);

        return $data->count;
    }

    public function getStatusColor()
    {
        switch ($this->status) {
            case 0: {
                $class = 'white';
                break;
            }
            case 1: {
                $class = 'warning';
                break;
            }
            case 2: {
                $class = 'success';
                break;
            }
            default:
                $class = '';
                break;
        }

        return $class;
    }
}