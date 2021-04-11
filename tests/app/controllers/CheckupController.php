<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/11/2018
 * Time: 5:08 PM
 */

namespace app\controllers;

use app\components\UserVerifyBehavior;
use app\models\user\VerificationCodeForm;
use yii\helpers\Html;
use app\components\ModuleTextBehavior;
use app\models\CheckUp;
use app\models\CheckupForm;
use yii\helpers\VarDumper;
use yii\web\Controller;
use app\models\Page;
use yii;
use yii\easyii\modules\mailaddresses\models\Mailaddresses;

class CheckupController extends Controller
{
    public $content_actions = ['index'];

    public function behaviors()
    {
        return [
            ModuleTextBehavior::className(),

            'user-verify' => [
                'class' => UserVerifyBehavior::className(),
                'actions' => ['form'],
            ]
        ];
    }

    public function actionIndex()
    {
        $checkups = CheckUp::getCheckUps();

        return $this->render('index',[
            'text' => $this->content,
            'checkups' => $checkups
        ]);
    }

    public function actionView($id)
    {
        $checkups = CheckUp::getCheckUps();

        $checkup_in = CheckUp::getCheckup($id);

        $examinations = CheckUp::getExaminations($id);

        $model = new CheckupForm();

        return $this->render('view',[
            'model' => $model,
            'user' => yii::$app->user->identity,
            'checkups' => $checkups,
            'checkup_in' => $checkup_in,
            'examinations' => $examinations
        ]);
    }

    public function actionForm()
    {
        $mailAddress = Mailaddresses::find()->select('email')->where(['tech_name' => 'appointment'])->one();

        if (yii::$app->request->isPost && yii::$app->request->isAjax){

            $session = yii::$app->session;

            $model = new CheckupForm();

            if ($model->load(yii::$app->request->post())){

                $user = yii::$app->user->identity;

                $model->created_at = time();
                $model->birthday = strtotime($model->birthday);

                if (!empty($user->id)){

                    $model->phone = $user->phone;
                    $model->birthday = $user->birthday;
                    $model->username = $user->firstname.' '.$user->lastname;
                    $model->email = $user->email;
                    $model->user_id = $user->id;
                }

                $text = '<b>Ad, Soyad: </b>'. $model->username. '<br>
                              <b>Dogum tarixi: </b>'.date('d.m.Y', $model->birthday).'<br>
                              <b>Email: </b>'.$model->email.'<br>
                              <b>Telefon: </b>'.$model->phone.'<br>
                              <b>Mesaj: </b>'.$model->text;

                if ($model->save()){

                    Yii::$app->mailer->compose('common', [
                        'text' => $text
                    ])
                        ->setFrom([yii::$app->params['noReplyEmail'] => yii::$app->params['senderName']])
                        ->setTo($mailAddress->email)
                        ->setSubject('Mediland Hospital - Check-up')
                        ->send();

                    $session->setFlash('success', Html::encode(yii::t('db', 'your request has been successfully send')) );

                    return $this->redirect(Yii::$app->request->referrer);
                }
            }
        }

        throw new yii\web\BadRequestHttpException();
    }
}










