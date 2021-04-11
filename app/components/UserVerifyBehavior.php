<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 5/21/2018
 * Time: 1:52 PM
 */

namespace app\components;


use app\models\user\VerificationCodeForm;
use yii\base\Behavior;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii;

class UserVerifyBehavior extends Behavior
{
    public $actions;

    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
            Controller::EVENT_AFTER_ACTION => 'afterAction',
        ];
    }

    public function beforeAction($event)
    {
        if(in_array($event->action->id, $this->actions)) {

            $req = yii::$app->request;

            if($req->isPost && $req->isAjax) {

                $session = yii::$app->session;

                if($session->get(VerificationCodeForm::SK_VU) != VerificationCodeForm::SV_VU) {

                    throw new yii\web\BadRequestHttpException();
                }


            }
        }
    }

    public function afterAction($event)
    {
        if(in_array($event->action->id, $this->actions)) {

            $req = yii::$app->request;

            if($req->isPost && $req->isAjax) {

                $session = yii::$app->session;

                if($session->get(VerificationCodeForm::SK_VU) != VerificationCodeForm::SV_VU) {

                    throw new yii\web\BadRequestHttpException();
                }

                if(yii::$app->user->isGuest) {
                    $session->remove(VerificationCodeForm::SK_VU);
                }
            }
        }
    }
}