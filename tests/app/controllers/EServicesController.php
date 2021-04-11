<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/21/2018
 * Time: 12:49 PM
 */

namespace app\controllers;

use app\components\Helpers;
use app\components\ModuleTextBehavior;
use app\components\User;
use app\components\UserVerifyBehavior;
use app\models\RandevuForm;
use app\models\user\VerificationCodeForm;
use yii\web\Controller;
use yii;
use yii\helpers\Html;
use yii\easyii\modules\mailaddresses\models\Mailaddresses;

class EServicesController extends Controller
{
    public $module_route = [
        'randevu' => 'appointments'
    ];
    public $content_actions = ['index', 'randevu'];

    public function behaviors()
    {
        return [
            ModuleTextBehavior::className(),

            'user-verify' => [
                'class' => UserVerifyBehavior::className(),
                'actions' => ['randevu-submit'],
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'text' => $this->content,
        ]);
    }

    public function actionRandevu()
    {
        $model = new RandevuForm();

        if(!yii::$app->user->isGuest) {

            $user = yii::$app->user->identity;
            $model->username = $user->firstname.' '.$user->lastname;
            $model->birthday = date('d.m.Y');
            $model->phone = $user->phone;
            $model->email = $user->email;
        }

        if($doctor_id = yii::$app->request->get('doctor_id')) {
            $model->doctor_id = $doctor_id;
        }

        $model->date = date('d.m.Y').' - '.date('d.m.Y');

        return $this->render('randevu', [
            'model' => $model,
            'guest' => yii::$app->user->isGuest,
            'text' => yii::$app->cache->get('content')
        ]);
    }

    public function actionRandevuSubmit()
    {
        if(yii::$app->request->isPost) {

            $mailAddress = Mailaddresses::find()->select('email')->where(['tech_name' => 'appointment'])->one();

            $model = new RandevuForm();

            if($model->load(yii::$app->request->post()) && $model->save()) {

                $text = '<b>Ad, Soyad: </b>'. $model->patient['username'].'<br>
                          <b>Arzu olunan vaxt: </b>'.$model->date.'<br>
                          <b>Email: </b>'.$model->patient['email'].'<br>
                          <b>Telefon: </b>'.$model->patient['phone'].'<br>
                          <b>Mesaj: </b>'.$model->message;

                Yii::$app->mailer->compose('common', [
                    'text' => $text
                ])
                    ->setFrom([yii::$app->params['noReplyEmail'] => yii::$app->params['senderName']])
                    ->setTo([$model->doctor['user']['email'], $mailAddress->email])
                    ->setSubject('Mediland Hospital - Randevu')
                    ->send();

                VerificationCodeForm::sendSms(
                    User::smsNumber($model->patient['phone']),
                    Helpers::strToLatin(yii::t('db', 'Your request has been successfully send. In short time we will respond you.'))
                );

                yii::$app->session->setFlash('success', Html::encode(yii::t('db', 'your request has been successfully send')) );

                return $this->redirect(['/e-randevu']);
            }

            yii::$app->session->setFlash('error', Html::encode(yii::t('db', 'An error occurred in your question')) );

            return $this->redirect(['/e-randevu']);
        }
    }
}