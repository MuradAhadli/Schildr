<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/7/2018
 * Time: 11:18 AM
 */

namespace app\controllers;

use yii;
use app\models\SubscribeForm;
use yii\web\Controller;
use yii\easyii\modules\subscribe\models\Subscriber;
use yii\helpers\Html;

class SubscribeController extends Controller
{
    public function actionValidate()
    {
        if(yii::$app->request->isAjax && yii::$app->request->isPost)
        {
            $model = new SubscribeForm();

            if($model->load(yii::$app->request->post())) {

                yii::$app->response->format = 'json';
                return \yii\widgets\ActiveForm::validate($model);
            }
        }
    }

    public function actionIndex()
    {
        if(yii::$app->request->isPost)
        {
            $model = new SubscribeForm();

            if($model->load(yii::$app->request->post()) && $model->validate()) {

                $model->token = Yii::$app->getSecurity()->hashData($model->email, SubscribeForm::TOKEN_KEY);

                $exist_model = SubscribeForm::find()
                    ->where(['email' => $model->email])
                    ->one();

                if($exist_model) {

                    $model = $exist_model;

                    $model->load(yii::$app->request->post());

                    $model->email = $exist_model->email;
                }

                if($model->save(false)) {

                    Yii::$app->mailer->compose('confirm-subscribe', [
                            'email' => $model->email,
                            'url' => yii::$app->urlManager->hostInfo . yii\helpers\Url::to(['/subscribe/confirm', 'token' => $model->token])
                        ])
                        ->setFrom([yii::$app->params['noReplyEmail'] => yii::$app->params['senderName']])
                        ->setTo($model->email)
                        ->setSubject(yii::t('db', 'News subscription verification'))
                        ->send();

                    yii::$app->session->setFlash('success', Html::encode(yii::t('db', 'Confirm your email for newsletter subscription')) );

                    return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
                }
                echo 'z';
                yii\helpers\VarDumper::dump($model->getErrors(),10,1); die();
            }
            else {
                yii::$app->response->format = 'json';
                return \yii\widgets\ActiveForm::validate($model);
            }
        }

        throw new yii\web\BadRequestHttpException();
    }

    public function actionConfirm($token)
    {
        if(yii::$app->security->validateData($token, SubscribeForm::TOKEN_KEY)) {

            $model = new SubscribeForm();

            $model  = $model->findOne(['token' => $token]);

            if($model && $model->token == $token) {

                $model->status = 1;

                if($model->save(false)) {

                    yii::$app->session->setFlash('success', Html::encode(yii::t('db', 'You have successfully subscribed to our newsletter')) );

                    return $this->redirect(Yii::$app->homeUrl);
                }
            }
        }

        throw new yii\web\BadRequestHttpException();
    }

    public function actionUnsubscribe($token)
    {
        if($email = yii::$app->security->validateData($token, SubscribeForm::TOKEN_KEY))
        {
            Subscriber::deleteAll(['email' => $email]);

            yii::$app->session->setFlash('success', Html::encode(yii::t('db', 'You have successfully unsubscribed')) );

            return $this->redirect(Yii::$app->homeUrl);
        }

        throw new \yii\web\BadRequestHttpException(Yii::t('easyii/subscribe/api', 'Incorrect E-mail'));
    }
}