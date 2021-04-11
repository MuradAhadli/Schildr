<?php
namespace yii\easyii\modules\subscribe\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use yii\easyii\components\Controller;
use yii\easyii\models\Setting;
use yii\easyii\modules\subscribe\models\Subscriber;
use yii\easyii\modules\subscribe\models\History;

class AController extends Controller
{
    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => Subscriber::find()->desc(),
        ]);
        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionHistory()
    {
        $this->setReturnUrl();

        $data = new ActiveDataProvider([
            'query' => History::find()->desc(),
        ]);
        return $this->render('history', [
            'data' => $data
        ]);
    }

    public function actionView($id)
    {
        $model = History::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('easyii', 'Not found'));
            return $this->redirect(['/admin/'.$this->module->id.'/history']);
        }

        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionCreate()
    {
        $model = new History;

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else
            {
                if($model->validate() && $this->send($model)){
                    $this->flash('success', Yii::t('easyii/subscribe', 'Subscribe successfully created and sent'));
                    return $this->redirect(['/admin/'.$this->module->id.'/a/history']);
                }
                else{
                    $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
            }
        }
        else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    public function actionDelete($id)
    {
        if(($model = Subscriber::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii/subscribe', 'Subscriber deleted'));
    }

    private function send($model)
    {
        $text = $model->body;

        foreach(Subscriber::find()->where(['status' => 1])->all() as $subscriber) {

            if(
                Yii::$app->mailer->compose('unsubscribe', [
                    'url' => yii::$app->urlManager->hostInfo . Url::to(['/subscribe/unsubscribe', 'token' => $subscriber->token]),
                    'message' => $text
                ])
                ->setFrom([yii::$app->params['noReplyEmail'] => yii::$app->params['senderName']])
                ->setTo($subscriber->email)
                ->setSubject($model->subject)
                ->setReplyTo(yii::$app->params['adminEmail'])
                ->send()
            ) {
                $model->sent++;
            }
        }

        return $model->save();
    }
}
