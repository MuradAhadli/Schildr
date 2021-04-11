<?php
namespace yii\easyii\modules\doctorworkhours\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\easyii\behaviors\SortableDateController;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;

use yii\easyii\components\Controller;
use yii\easyii\modules\doctorworkhours\models\DoctorWorkHours;
use yii\easyii\behaviors\StatusController;

class AController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => StatusController::className(),
                'model' => DoctorWorkHours::className()
            ]
        ];
    }

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => DoctorWorkHours::find()->orderBy(['id' => SORT_DESC]),
        ]);

        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate()
    {
        $model = new DoctorWorkHours;

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{

                if($model->save()){
                    $this->flash('success', Yii::t('easyii', 'DoctorWorkHours created'));
                    return $this->redirect(['/admin/'.$this->module->id]);
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

    public function actionEdit($id)
    {
        $model = DoctorWorkHours::find()->andWhere(['id' => $id])->one();

        if($model === null){
            $this->flash('error', Yii::t('easyii', 'Not found'));
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{

                if($model->save()){
                    $this->flash('success', Yii::t('easyii', 'DoctorWorkHours updated'));
                }
                else{
                    $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
                }
                return $this->refresh();
            }
        }
        else {

            $model->day = unserialize($model->day);
            $model->hour_from = date('H:i', $model->hour_from);
            $model->hour_to = date('H:i', $model->hour_to);


            return $this->render('edit', [
                'model' => $model
            ]);
        }
    }

    public function actionDelete($id)
    {
        if(($model = DoctorWorkHours::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii', 'DoctorWorkHours deleted'));
    }

    public function actionOn($id)
    {
        return $this->changeStatus($id, DoctorWorkHours::STATUS_ON);
    }

    public function actionOff($id)
    {
        return $this->changeStatus($id, DoctorWorkHours::STATUS_OFF);
    }
}