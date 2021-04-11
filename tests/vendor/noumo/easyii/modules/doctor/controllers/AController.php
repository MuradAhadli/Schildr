<?php
namespace yii\easyii\modules\doctor\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\easyii\behaviors\SortableDateController;
use yii\easyii\models\User;
use yii\easyii\modules\doctor\models\UserForm;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

use yii\easyii\components\Controller;
use yii\easyii\modules\doctor\models\Doctor;
use yii\easyii\helpers\Image;
use yii\easyii\behaviors\StatusController;

class AController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => SortableDateController::className(),
                'model' => Doctor::className(),
            ],
            [
                'class' => StatusController::className(),
                'model' => Doctor::className()
            ]
        ];
    }

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => Doctor::find()->with('user', 'department')->orderBy(['time' => SORT_DESC]),
        ]);

        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate()
    {
        $model = new Doctor;
        $model->time = time();

        $user = new UserForm();
        $user->scenario = 'create';

        if ($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {

            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                $model = ActiveForm::validate($model);

                if($model)
                    return $model;
                else
                    return ActiveForm::validate($user);
            }
            else{

                $isValid = $model->validate();
                $isValid = $user->validate() && $isValid;

                if($isValid){

                    $user = $user->signup();

                    $model->user_id = $user->id;

                    $model->save(false);

                    $this->flash('success', Yii::t('easyii', 'Doctor created'));
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
                'model' => $model,
                'user' => $user,
            ]);
        }
    }

    public function actionEdit($id)
    {
        $model = Doctor::find()->multilingual()->with('user')->andWhere(['id' => $id])->one();

        $user = new UserForm();

        if($model === null){
            $this->flash('error', Yii::t('easyii', 'Not found'));
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        if ($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {

            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                $model = ActiveForm::validate($model);

                if($model)
                    return $model;
                else
                    return ActiveForm::validate($user);
            }
            else{

                $isValid = $model->validate();
                $isValid = $user->validate() && $isValid;

                if($isValid){

                    $user = $user->update($model->user_id);

                    $model->save();

                    $this->flash('success', Yii::t('easyii', 'Doctor updated'));
                }
                else{
                    $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
                }
                return $this->refresh();
            }
        }
        else {

            $model->social = unserialize($model->social);
            $user->birthday = date('d/m/Y', $model->user->birthday);
            $user->email = $model->user->email;
            $user->phone = $model->user->phone;
            $user->status = $model->user->status == 10 ? 1 : 0;

            return $this->render('edit', [
                'model' => $model,
                'user' => $user
            ]);
        }
    }

    public function actionPhotos($id)
    {
        if(!($model = Doctor::findOne($id))){
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        return $this->render('photos', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        if(($model = Doctor::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii', 'Doctor deleted'));
    }

    public function actionCovers($id)
    {
        if(!($model = Doctor::findOne($id))){
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        return $this->render('covers', [
            'model' => $model,
        ]);
    }

    public function actionClearImage($id)
    {
        $model = User::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('easyii', 'Not found'));
        }
        else{
            $model->image = '';
            if($model->update(true, ['image'])){
                $this->flash('success', Yii::t('easyii', 'Image cleared'));
            } else {
                $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
            }
        }
        return $this->back();
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
        return $this->changeStatus($id, Doctor::STATUS_ON);
    }

    public function actionOff($id)
    {
        return $this->changeStatus($id, Doctor::STATUS_OFF);
    }
}