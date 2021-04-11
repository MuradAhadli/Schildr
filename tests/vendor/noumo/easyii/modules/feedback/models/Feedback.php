<?php
namespace yii\easyii\modules\feedback\models;

use Yii;
use yii\easyii\behaviors\CalculateNotice;
use yii\easyii\helpers\Mail;
use yii\easyii\models\Setting;
use yii\easyii\validators\ReCaptchaValidator;
use yii\easyii\validators\EscapeValidator;
use yii\helpers\Url;
use app\models\user\VerificationCodeForm;
use app\components\Helpers;
use app\components\User;
use yii\helpers\VarDumper;

class Feedback extends \yii\easyii\components\ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_VIEW = 1;
    const STATUS_ANSWERED = 2;

    const FLASH_KEY = 'eaysiicms_feedback_send_result';

    public $reCaptcha;

    public static function tableName()
    {
        return 'easyii_feedback';
    }

    public function rules()
    {
        return [
            [['name', 'surname', 'email', 'text'], 'required'],
            [['name', 'email', 'phone', 'title', 'text'], 'trim'],
            [['name', 'surname','title', 'text','subject'], EscapeValidator::className()],
            ['title', 'string', 'max' => 128],
            ['email', 'email'],
            ['phone', 'match', 'pattern' => '/^[\d\s-\+\(\)]+$/'],
//            ['reCaptcha', ReCaptchaValidator::className(), 'when' => function($model){
//                return $model->isNewRecord && Yii::$app->getModule('admin')->activeModules['feedback']->settings['enableCaptcha'];
//            }],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($insert){
                $this->ip = Yii::$app->request->userIP;
                $this->time = time();
                $this->status = self::STATUS_NEW;
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
            'name' => Yii::t('easyii', 'Name'),
            'title' => Yii::t('easyii', 'Title'),
            'text' => Yii::t('easyii', 'Text'),
            'answer_subject' => Yii::t('easyii/feedback', 'Subject'),
            'answer_text' => Yii::t('easyii', 'Text'),
            'phone' => Yii::t('easyii/feedback', 'Phone'),
            'reCaptcha' => Yii::t('easyii', 'Anti-spam check'),
            'answer_subject' => Yii::t('db', 'Answer subject'),
            'answer_text' => Yii::t('db', 'Answer text'),
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
        $settings = Yii::$app->getModule('admin')->activeModules['feedback']->settings;

        if(!$settings['mailAdminOnNewFeedback']){
            return false;
        }
        return Mail::send(
            Setting::get('admin_email'),
            $settings['subjectOnNewFeedback'],
            $settings['templateOnNewFeedback'],
            ['feedback' => $this, 'link' => Url::to(['/admin/feedback/a/view', 'id' => $this->primaryKey], true)]
        );
    }

    public function sendAnswer()
    {
        $settings = Yii::$app->getModule('admin')->activeModules['feedback']->settings;

        VerificationCodeForm::sendSms(
            User::smsNumber($this->phone),
            Helpers::strToLatin($this->answer_text)
        );

        $mail_text = '<p>'.$this->answer_text.'</p>'.'<hr /><p>' . date('d-m-Y, H:i:s',$this->time) . '</p><p>'.$this->text.'</p>';

        return Yii::$app->mailer->compose('answer-feedback', ['text' => $mail_text])
            ->setFrom([yii::$app->params['noReplyEmail'] => yii::$app->params['senderName']])
            ->setTo($this->email)
            ->setSubject('Mediland Hospital - ' . $this->answer_subject)
            ->send();
    }
}