<?php
namespace yii\easyii\modules\subscribe\controllers;

use Yii;
use yii\easyii\modules\subscribe\api\Subscribe;
use yii\widgets\ActiveForm;

use yii\easyii\modules\subscribe\models\Subscriber;

class SendController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new Subscriber;
        $request = Yii::$app->request;

        if ($model->load($request->post())) {
            if($request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                $returnUrl = $model->save() ? $request->post('successUrl') : $request->post('errorUrl');
                return $this->redirect($returnUrl);
            }
        }
        else {
            return $this->redirect(Yii::$app->request->baseUrl);
        }
    }
}