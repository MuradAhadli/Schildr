<?php
namespace yii\easyii\modules\consultation\controllers;

use Yii;
use yii\easyii\modules\consultation\models\Consultation as ConsultationModel;

class SendController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new ConsultationModel;

        $request = Yii::$app->request;

        if ($model->load($request->post())) {
            $returnUrl = $model->save() ? $request->post('successUrl') : $request->post('errorUrl');
            return $this->redirect($returnUrl);
        } else {
            return $this->redirect(Yii::$app->request->baseUrl);
        }
    }
}