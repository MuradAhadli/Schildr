<?php
namespace yii\easyii\modules\consultation\controllers;

use Yii;
use yii\data\ActiveDataProvider;

use yii\easyii\components\Controller;
use yii\easyii\models\Setting;
use yii\easyii\modules\consultation\models\Consultation;
use yii\helpers\VarDumper;

class AController extends Controller
{
    public $new = 0;
    public $noAnswer = 0;

    public function init()
    {
        parent::init();

        $this->new = Yii::$app->getModule('admin')->activeModules['consultation']->notice;
        $this->noAnswer = Consultation::find()->status(Consultation::STATUS_VIEW)->count();
    }

    public function actionIndex()
    {
        $where = Consultation::getWhere();

        $data = new ActiveDataProvider([
            'query' => Consultation::find()->where($where)->status(Consultation::STATUS_NEW)->orderBy('id DESC, status ASC'),
        ]);
        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionNoanswer()
    {
        $where = Consultation::getWhere();
        $this->setReturnUrl();

        $data = new ActiveDataProvider([
            'query' => Consultation::find()->where($where)->status(Consultation::STATUS_VIEW)->orderBy('id DESC, status ASC'),
        ]);

        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionAll()
    {
        $where = Consultation::getWhere();
        $this->setReturnUrl();

        $data = new ActiveDataProvider([
            'query' => Consultation::find()->where($where)->orderBy('id DESC, status ASC'),
        ]);
        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionView($id)
    {
        $model = Consultation::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('easyii', 'Not found'));
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        if($model->status == Consultation::STATUS_NEW){

            $model->status = Consultation::STATUS_VIEW;
            $model->update(false);
        }

        $assign = '';
        if ($model->assign != 0){
            $assign = $model->getDoctor($model->assign);
        }

        return $this->render('view', [
            'model' => $model,
            'assign' => $assign,
        ]);
    }

    public function actionSendAnswer($id)
    {
        $model = Consultation::findOne($id);

        $postData = Yii::$app->request->post('Consultation');

        if($postData) {
            if(filter_var(Setting::get('admin_email'), FILTER_VALIDATE_EMAIL))
            {
                $model->answer_subject = filter_var($postData['answer_subject'], FILTER_SANITIZE_STRING);
                $model->answer_text = filter_var($postData['answer_text'], FILTER_SANITIZE_STRING);
                if($model->sendAnswer()){
                    $model->status = Consultation::STATUS_ANSWERED;
                    $model->save();
                    $this->flash('success', Yii::t('db', 'Answer successfully sent'));

                    return $this->redirect(Yii::$app->request->referrer);
                }
                else{
                    $this->flash('error', Yii::t('easyii/consultation', 'An error has occurred while sending mail'));
                }
            }
            else {
                $this->flash('error', Yii::t('easyii/consultation', 'Please fill correct `Admin E-mail` in Settings'));
            }

            return $this->refresh();
        }
    }

    public function actionSetAnswer($id)
    {
        $model = Consultation::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('easyii', 'Not found'));
        }
        else{
            $model->status = Consultation::STATUS_ANSWERED;
            if($model->update()) {
                $this->flash('success', Yii::t('easyii/consultation', 'Consultation updated'));
            }
            else{
                $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
            }
        }
        return $this->back();
    }

    public function actionDelete($id)
    {
        if(($model = Consultation::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii/consultation', 'Consultation deleted'));
    }
}