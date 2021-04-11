<?php
namespace yii\easyii\modules\systems\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\easyii\behaviors\SortableDateController;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

use yii\easyii\components\Controller;
use yii\easyii\modules\systems\models\Systems;
use yii\easyii\helpers\Image;
use yii\easyii\behaviors\StatusController;

class AController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => SortableDateController::className(),
                'model' => Systems::className(),
            ],
            [
                'class' => StatusController::className(),
                'model' => Systems::className()
            ]
        ];
    }

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => Systems::find()->orderBy(['id' => SORT_DESC]),
        ]);

        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate()
    {
        $model = new Systems;
        $model->created_at = time();

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                if($model->save()){
                    $this->flash('success', Yii::t('easyii', 'Systems created'));
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
        $model = Systems::find()->multilingual()->andWhere(['id' => $id])->one();

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
                $model->updated_at = time();
                if($model->save()){
                    $this->flash('success', Yii::t('easyii', 'Systems updated'));
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

    public function actionPhotos($id)
    {
        if(!($model = Systems::findOne($id))){
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        return $this->render('photos', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        if(($model = Systems::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii', 'Systems deleted'));
    }

    public function actionUp($id)
    {

        return $this->move($id, 'up');
    }

    public function actionDown($id)
    {
        return $this->move($id, 'down');
    }

    public function actionOn($id)
    {
        return $this->changeStatus($id, Systems::STATUS_ON);
    }

    public function actionOff($id)
    {
        return $this->changeStatus($id, Systems::STATUS_OFF);
    }
}