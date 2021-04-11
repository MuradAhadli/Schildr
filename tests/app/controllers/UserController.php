<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/7/2018
 * Time: 11:18 AM
 */

namespace app\controllers;

use app\components\ModuleTextBehavior;
use app\components\User;
use app\components\UserVerifyBehavior;
use app\models\user\LoginForm;
use app\models\user\PasswordResetRequestForm;
use app\models\user\ResetPasswordForm;
use app\models\user\SignupForm;
use app\models\user\VerificationCodeForm;
use yii;
use yii\web\Controller;
use yii\helpers\Html;
use app\components\Helpers;

class UserController extends Controller
{
    public $content_actions = ['signup'];

    public function behaviors()
    {
        return [
            ModuleTextBehavior::className(),

            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['signup'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?']
                    ],

                ],
                'denyCallback' => function($rule, $action){
//                        $messages = $action->controller->denyMessages();
//                        $message = (isset($messages[$action->id])) ? $messages[$action->id] : 'You are not allowed to perform this action.';
                    throw new yii\web\ForbiddenHttpException(Yii::t('db', 'You\'ve already signed in'));
                }
            ],

            'user-verify' => [
                'class' => UserVerifyBehavior::className(),
                'actions' => ['signup'],
            ]
        ];
    }

    public function actionSignup()
    {
        $model = new SignupForm();

        $session = yii::$app->session;

        if(yii::$app->request->isPost)
        {
            $model->scenario = 'create';

            if ($model->load(yii::$app->request->post()) && $model->validate()){

                if($user = $model->signup()){

                    yii::$app->user->login($user, $model->rememberMe ? 3600*24*30 : 0);

                    $session->set(VerificationCodeForm::SK_VU, VerificationCodeForm::SV_VU);

                    $session->setFlash('success', Html::encode(yii::t('db', 'You have successfully registered.')));

                    return $this->redirect(Yii::$app->homeUrl);
                }
            }
            else {

                throw new yii\web\BadRequestHttpException();
            }
        }

        $model->rememberMe = false;

        return $this->render('signup', [
            'model' => $model,
            'text' => $this->content
        ]);
    }

    public function actionSignupValidate()
    {
        if(yii::$app->request->isAjax && yii::$app->request->isPost)
        {
            $model = new SignupForm();

            $model->scenario = 'create';

            if($model->load(yii::$app->request->post())) {

                yii::$app->response->format = 'json';

                return \yii\widgets\ActiveForm::validate($model);
            }
        }
    }

    public function actionLogin()
    {
        $model = new LoginForm();

        if(yii::$app->request->isPost) {

            if ($model->load(yii::$app->request->post()) && $model->validate()){

                if($model->login()){

                    yii::$app->session->set(VerificationCodeForm::SK_VU, VerificationCodeForm::SV_VU);

                    return $this->redirect(Yii::$app->homeUrl);
                }
            }
        }

        $model->rememberMe = false;

        return $this->render('login', [
            'model' => $model
        ]);
    }

    public function actionLoginValidate()
    {
        if(yii::$app->request->isAjax && yii::$app->request->isPost)
        {
            $model = new LoginForm();

            if($model->load(yii::$app->request->post())) {

                yii::$app->response->format = 'json';

                return \yii\widgets\ActiveForm::validate($model);
            }
        }
    }

    public function actionLogout()
    {
        if(!yii::$app->user->isGuest && yii::$app->user->logout()) {

            yii::$app->session->remove(VerificationCodeForm::SK_VU);

            return $this->redirect(['/']);
        }

        throw new yii\web\BadRequestHttpException();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Html::encode(yii::t('db', 'Check your email for further instructions.')) );

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', Html::encode(yii::t('db', 'Sorry, we are unable to reset password for the provided email address.')) );
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (yii\base\InvalidParamException $e) {

            throw new yii\web\BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Html::encode(yii::t('db', 'Your password successfully changed.')));

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionVerificationCode()
    {
        $req = yii::$app->request;

        if($req->isPost && $req->isAjax) {

            $depend_element = $req->post('depend_element');

            $user_phone = $req->post('user_phone');


            if(count($req->post()) > 2 || (!$user_phone && !$depend_element)) {

                throw new yii\web\BadRequestHttpException();
            }

            $session = yii::$app->session;

            if(!yii::$app->user->isGuest || (!$user_phone && $depend_element)) {

                $session->set(VerificationCodeForm::SK_VU, VerificationCodeForm::SV_VU);

                return VerificationCodeForm::SV_VU;
            }

            if($session->get(VerificationCodeForm::SK_VU) == VerificationCodeForm::SV_VU) {

                return VerificationCodeForm::SV_VU;
            }

            $code = rand(99999, 999999);

            VerificationCodeForm::sendSms(
                User::smsNumber($user_phone),
                Helpers::strToLatin(yii::t('db', 'Your verification code:').' '.$code)
            );

            $session->set(VerificationCodeForm::SK_VC, $code);

            return $this->asJson(['code' => 'success']);
        }

        throw new yii\web\BadRequestHttpException();
    }

    public function actionVerifyUser()
    {
        if(yii::$app->request->isPost && yii::$app->request->isAjax) {

            $model = new VerificationCodeForm();

            if($model->load(yii::$app->request->post())) {

                return $this->asJson(yii\widgets\ActiveForm::validate($model));
            }
        }

        throw new yii\web\BadRequestHttpException();
    }
}