<?php
namespace yii\easyii\modules\social\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;

use yii\easyii\behaviors\SortableDateController;
use yii\easyii\behaviors\StatusController;

use yii\easyii\components\Controller;
use yii\easyii\modules\social\models\Social;

class AController extends Controller
{
//    public $rootActions = ['create', 'delete'];

    public function behaviors()
    {
        return [
            [
                'class' => SortableDateController::className(),
                'model' => Social::className(),
            ],
            [
                'class' => StatusController::className(),
                'model' => Social::className()
            ]
        ];
    }

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => Social::find()->sortDate(),
        ]);
        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate($slug = null)
    {
        $model = new Social;
        $model->time = time();

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                if($model->save()){
                    $this->flash('success', Yii::t('easyii', 'Created successfully'));

                    return $this->render('edit', [
                        'model' => $model
                    ]);

                    return $this->redirect(['/admin/'.$this->module->id]);
                }
                else{
                    $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
            }
        }
        else {
            if($slug){
                $model->slug = $slug;
            }
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    public function actionEdit($id)
    {
        $model = Social::findOne($id);

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
                    $this->flash('success', Yii::t('easyii', 'Updated successfully'));
                }
                else{
                    $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
                }

                return $this->render('edit', [
                    'model' => $model
                ]);

                return $this->refresh();
            }
        }
        else {
            return $this->render('edit', [
                'model' => $model
            ]);
        }
    }

    public function actionDelete($id)
    {
        if(($model = Social::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii', 'Deleted successfully'));
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
        return $this->changeStatus($id, Social::STATUS_ON);
    }

    public function actionOff($id)
    {
        return $this->changeStatus($id, Social::STATUS_OFF);
    }
}