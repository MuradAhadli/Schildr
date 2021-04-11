<?php
namespace yii\easyii\modules\news\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\easyii\behaviors\SortableController;
use yii\easyii\behaviors\SortableDateController;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

use yii\easyii\components\Controller;
use yii\easyii\modules\news\models\News;
use yii\easyii\helpers\Image;
use yii\easyii\behaviors\StatusController;

class AController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => SortableDateController::className(),
                'model' => News::className(),
            ],
            [
                'class' => StatusController::className(),
                'model' => News::className()
            ]
        ];
    }

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => News::find()->orderBy(['time' => SORT_DESC]),
        ]);

        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate()
    {
        $model = new News;

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                if(isset($_FILES) && $this->module->settings['enableThumb']){
                    $model->image = UploadedFile::getInstance($model, 'image');
                    if($model->image && $model->validate(['image'])){
                        $model->image = Image::upload($model->image, 'news', News::IMAGE_WIDTH, News::IMAGE_HEIGHT, true);
                    }
                    else{
                        $model->image = '';
                    }
                }

                $model->time = $model->time ? strtotime($model->time) : time();

                if($model->save()){
                    $this->flash('success', Yii::t('easyii', 'News created'));
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
        $model = News::find()->multilingual()->andWhere(['id' => $id])->one();

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
                if(isset($_FILES) && $this->module->settings['enableThumb']){
                    $model->image = UploadedFile::getInstance($model, 'image');
                    if($model->image && $model->validate(['image'])){
                        $model->image = Image::upload($model->image, 'news', News::IMAGE_WIDTH, News::IMAGE_HEIGHT, true);
                    }
                    else{
                        $model->image = $model->oldAttributes['image'];
                    }
                }

                $model->time = strtotime($model->time);

                if($model->save()){
                    $this->flash('success', Yii::t('easyii', 'News updated'));
                }
                else{
                    $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
                }
                return $this->refresh();
            }
        }
        else {

            $model->time = date('d.m.Y', $model->time);

            return $this->render('edit', [
                'model' => $model
            ]);
        }
    }

    public function actionPhotos($id)
    {
        if(!($model = News::findOne($id))){
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        return $this->render('photos', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        if(($model = News::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii', 'News deleted'));
    }

    public function actionClearImage($id)
    {
        $model = News::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('easyii', 'Not found'));
        }
        else{
            $model->image = '';
            if($model->update(true, ['image'])){
//                echo $model->image.'----er'; die();
//                unlink(Yii::getAlias('@webroot').$model->image);
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
        return $this->changeStatus($id, News::STATUS_ON);
    }

    public function actionOff($id)
    {
        return $this->changeStatus($id, News::STATUS_OFF);
    }
}