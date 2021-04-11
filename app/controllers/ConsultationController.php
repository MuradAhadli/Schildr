<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 3/24/2018
 * Time: 10:53 AM
 */

namespace app\controllers;

use app\components\Helpers;
use app\components\ModuleTextBehavior;
use app\components\User;
use app\components\UserVerifyBehavior;
use app\models\ConsultationForm;
use app\models\Doctor;
use app\models\Page;
use app\models\user\VerificationCodeForm;
use yii;
use app\models\Department;
use yii\web\Controller;
use yii\easyii\modules\consultation\models\Consultation;
use yii\helpers\Html;
use yii\easyii\modules\mailaddresses\models\Mailaddresses;

class ConsultationController extends Controller
{
    public $content_actions = ['index'];

    public function behaviors()
    {
        return [
            ModuleTextBehavior::className(),

            'user-verify' => [
                'class' => UserVerifyBehavior::className(),
                'actions' => ['index'],
            ]
        ];
    }

    public function actionIndex()
    {
        $model_cons = new Consultation();
        $model_cons_form = new ConsultationForm();


        $dep_doctors = $model_cons_form::getDepDoctors();

        if (yii::$app->request->isPost){

            if ($model_cons_form->load(yii::$app->request->post())){

                $user = yii::$app->user->identity;

                $model_cons->text = $model_cons_form->text;
                $model_cons->assign = $model_cons_form->assign;
                $model_cons->phone = $model_cons_form->phone;
                $model_cons->private = $model_cons_form->private;
                $model_cons->created_at = time();
                $model_cons->token = md5(Yii::$app->session->id . time());

                if (empty($user->id) && $model_cons_form->private == 0){

                    $model_cons->firstname = $model_cons_form->firstname;
                    $model_cons->birthday = strtotime($model_cons_form->birthday);
                    $model_cons->email = $model_cons_form->email;

                }elseif ($model_cons_form->private == 1){
                    if (empty($user->id)){
                        $model_cons->email = $model_cons_form->email;
                    }else{
                        $model_cons->email = $user->email;
                    }
                }
                else{

                    $model_cons->phone = $user->phone;
                    $model_cons->birthday = $user->birthday;
                    $model_cons->firstname = $user->firstname;
                    $model_cons->lastname = $user->lastname;
                    $model_cons->email = $user->email;
                    $model_cons->created_by = $user->id;
                }

                if ($model_cons ->save(false)){

                    $mailAddress = Mailaddresses::find()->select('email')->where(['tech_name' => 'consultation'])->one();

                    $doctor = $model_cons->getDoctorUser($model_cons->assign)['user'];

                    $text = '';

                    if ($model_cons_form->private == 0) {
                        $text .= '<b>Ad, Soyad: </b>' . $model_cons->firstname . ' ' . $model_cons->lastname . '<br>';
                        $text .= '<b>Dogum tarixi: </b>' . date('d.m.Y', $model_cons->birthday) . '<br>';
                        if(!empty($model_cons->phone)) {
                            $text .= '<b>Telefon: </b>' . $model_cons->phone . '<br>';
                        }
                    }

                    $text .= '<b>Email: </b>'.$model_cons->email.'<br>';
                    $text .= '<b>Sual: </b>'.$model_cons->text . '<br>';
                    $text .= 'Hörmətli həkim, sualı bu linkə daxil olmaqla <a href="' . Yii::$app->urlManager->createAbsoluteUrl(['consultation/answer', 'id' => $model_cons->id, 'token' => $model_cons->token]) . '">cavablandırın.</a>';



                    Yii::$app->mailer->compose('common', [
                        'text' => $text
                    ])
                        ->setFrom([yii::$app->params['noReplyEmail'] => yii::$app->params['senderName']])
                        ->setTo([$doctor['email'], $mailAddress->email])
                        ->setSubject('Mediland Hospital - Konsultasiya')
                        ->send();

                    $sms_text = '';

                    if($model_cons->private == 0) {
                        $sms_text .= 'Ad, Soyad: ' . $model_cons->firstname . ' ' . $model_cons->lastname ;
                        //$sms_text .= $model_cons->lastname ? ' ' . $model_cons->lastname : '';
                        $sms_text .= $model_cons->birthday ? ',  Dogum tarixi: ' . date('d-m-Y', $model_cons->birthday) : '';
                        $sms_text .= ',  Email: ' . $model_cons->email;
                        $sms_text .= ',  Telefon: ' . $model_cons->phone;
                    }
                    else {
                        $sms_text = 'Anonim sual';
                    }

                    //Yii::$app->urlManager->createAbsoluteUrl(['consultation/answer', 'id' => $model_cons->id, 'token' => $model_cons->token])

                    $sms_text = 'Hormetli hekim, size sual unvanlanib. Zehmet olmasa, e-pocht unvaninizi yoxlayin.';

                    $sms_text = Helpers::strToLatin($sms_text);

                    VerificationCodeForm::sendSms(
                        User::smsNumber($doctor['phone']),
                        $sms_text
                    );

                    if($model_cons_form->private == 0) {

                        VerificationCodeForm::sendSms(
                            User::smsNumber($model_cons->phone),
                            Helpers::strToLatin(yii::t('db','Your request has been successfully send. In short time we will respond you.'))
                        );
                    }

                    yii::$app->session->setFlash('success', Html::encode(yii::t('db', 'You have successfully send question. In short time doctor will answer your question')) );

                    return $this->redirect(['/consultation']);
                }
            }
        }

        $model = new \app\models\ConsultationForm();
        $model->private = 0;

        return $this->render('index', [
            'model' => $model,
            'dep_doctors' => $dep_doctors,
            'user' => (yii::$app->user->isGuest) ? false : yii::$app->user->identity,
            'text' => yii::$app->cache->get('content')
        ]);
    }

    public function actionAnswer()
    {

        $id = Yii::$app->request->get('id');

        $message = '';

        $model = Consultation::find()->where(['id' => $id])->one();

        if(!isset($model)){
            return $this->redirect(['/']);
            exit;
        }

        $this->layout = 'static';

        if($model->token != Yii::$app->request->get('token')){
            $this->redirect(['/']);
        }else{
            if ($model->load(Yii::$app->request->post())) {
                $model->status = Consultation::STATUS_ANSWERED;
                $model->save(false);

                $mailAddress = Mailaddresses::find()->select('email')->where(['tech_name' => 'consultation'])->one();

                $text = 'Hörmətli pasient, sizin sualınız həkimimiz tərəfindən cavablandırıldı.<br />
                          <b>Sual: </b>'. $model->text.'<br>
                          <b>Cavab: </b>'.$model->answer_text.'<br>';

                Yii::$app->mailer->compose('common', [
                    'text' => $text
                ])
                    ->setFrom([yii::$app->params['noReplyEmail'] => yii::$app->params['senderName']])
                    ->setTo([$model->email, $mailAddress->email])
                    ->setSubject('Mediland Hospital - Suala cavab')
                    ->send();

                $sms_text = Helpers::strToLatin('Hekimin cavabi:' . $model->answer_text);

                VerificationCodeForm::sendSms(
                    User::smsNumber($model->phone),
                    $sms_text
                );


                $this->redirect(Yii::$app->urlManager->createAbsoluteUrl(['consultation/answer', 'id' => $model->id, 'token' => $model->token]));

            }else if($model->status == Consultation::STATUS_ANSWERED){
                $message = 'Cavabınız göndərilib!';
            }

            return $this->render('answer', ['model' => $model, 'message' => $message, 'doctor' => Consultation::getDoctor($model->assign), 'department' => Consultation::getDepartment($model->department_id)]);

        }
    }

    public function actionValidate()
    {
        if(yii::$app->request->isAjax && yii::$app->request->isPost)
        {
            $model_cons = new ConsultationForm();

            if($model_cons->load(yii::$app->request->post())) {

                yii::$app->response->format = 'json';
                return \yii\widgets\ActiveForm::validate($model_cons);
            }
        }
    }
}