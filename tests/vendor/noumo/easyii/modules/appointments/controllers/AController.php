<?php
namespace yii\easyii\modules\appointments\controllers;

use app\components\Helpers;
use app\components\User;
use app\models\user\VerificationCodeForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\easyii\behaviors\SortableDateController;
use yii\easyii\components\Helper;
use yii\helpers\VarDumper;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\widgets\ActiveForm;

use yii\easyii\components\Controller;
use yii\easyii\modules\appointments\models\Appointments;
use yii\easyii\behaviors\StatusController;

class AController extends Controller
{

    public function behaviors()
    {
        return [
            [
                'class' => StatusController::className(),
                'model' => Appointments::className()
            ]
        ];
    }

    public function actionIndex()
    {
        $query = Appointments::find()->orderBy(['id' => SORT_DESC]);

        if(yii::$app->user->identity->isDoctor()) {
            $query = $query->andWhere(['doctor_id' => yii::$app->user->id]);
        }

        $data = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionEdit($id)
    {
        $model = Appointments::find()->andWhere(['id' => $id])->one();

        if($model === null){
            $this->flash('error', Yii::t('easyii', 'Not found'));
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        if(yii::$app->user->identity->isDoctor()) {

            if(yii::$app->user->id != $model->doctor_id) {

                throw new ForbiddenHttpException();
            }
        }

        if($model->status != $model::STATUS_ACCEPT && $model->status != $model::STATUS_DECLINE) {
            $model->status = $model::STATUS_WAIT;
        }

        $model->save(false);

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{

                if(isset($_POST['decline'])) {
                    $model->status = $model::STATUS_DECLINE;
                }
                else {
                    $model->status = $model::STATUS_ACCEPT;
                }

                $model->exact_time = strtotime($model->exact_time);

                if($model->save()){

                    if($model->status == $model::STATUS_ACCEPT) {

                        $subject = 'Mediland Hospital - Randevu təsdiqləndi';

                        $text = 'Hörmətli pasient. Sizin randevu sorğunuz təsdiq edildi.<br />';

                        if(!empty($model->doctor_message)){
                            $text .= $model->doctor_message . '<br />';
                        }

                        $text .= '<h2><b>Randevu vaxtı: </b>'.date('d.m.y, H:i', $model->exact_time).'</h2>';

                        Yii::$app->mailer->compose('common', [
                            'text' => $text,
                        ])
                            ->setFrom([yii::$app->params['noReplyEmail'] => yii::$app->params['senderName']])
                            ->setTo($model->doctor['user']['email'])
                            ->setSubject($subject)
                            ->send();

                        $sms_text = Helpers::strToLatin(sprintf(yii::t('app','randevu_accept','',$model->user_lang), date('d.m.y, H:i', $model->exact_time), $model->doctorName));

                    }
                    else {
                        $text = 'Hörmətli pasient. Sizin randevu sorğunuzdan imtina edildi.<br />';

                        if(!empty($model->doctor_message)){
                            $text .= $model->doctor_message . '<br />';
                        }

                        $text .= '<h2><b>Randevu vaxtı: </b>'.date('d.m.y, H:i', $model->exact_time).'</h2>';

                        $subject = 'Mediland Hospital - Randevu imtina edildi';

                        $sms_text = Helpers::strToLatin(yii::t('app','randevu_decline','', $model->user_lang));

                    }

                    VerificationCodeForm::sendSms(User::smsNumber($model->patient['phone']), $sms_text);

                    Yii::$app->mailer->compose('common', [
                            'text' => $text,
                        ])
                        ->setFrom([yii::$app->params['noReplyEmail'] => yii::$app->params['senderName']])
                        ->setTo($model->patient['email'])
                        ->setSubject($subject)
                        ->send();

                    $this->flash('success', Yii::t('db', 'Appointments updated'));
                }
                else{
                    $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
                }
                return $this->refresh();
            }
        }
        else {

            return $this->render('edit', [
                'model' => $model
            ]);
        }
    }

    public function actionStatus($id, $action)
    {
        if($model = Appointments::findOne($id)) {

            switch ($action) {
                case 'accept': {
                    $model->status = Appointments::STATUS_ACCEPT;
                    break;
                }
                case 'decline': {
                    $model->status = Appointments::STATUS_DECLINE;
                    break;
                }
                default :
                    throw new BadRequestHttpException();
            }

            if($model->save())
                return $this->redirect(['/admin/'.$this->module->id]);
        }

        throw new BadRequestHttpException();
    }

    public function actionDelete($id)
    {
        if(($model = Appointments::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii', 'Appointments deleted'));
    }

    public function actionOn($id)
    {
        return $this->changeStatus($id, Appointments::STATUS_ON);
    }

    public function actionOff($id)
    {
        return $this->changeStatus($id, Appointments::STATUS_OFF);
    }
}