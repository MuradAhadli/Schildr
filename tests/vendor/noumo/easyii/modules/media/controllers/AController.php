<?php
namespace yii\easyii\modules\media\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

use yii\easyii\components\Controller;
use yii\easyii\modules\media\models\Media;
use yii\easyii\helpers\Image;
use yii\easyii\behaviors\SortableController;
use yii\easyii\behaviors\StatusController;


class AController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => SortableController::className(),
                'model' => Media::className()
            ],
            [
                'class' => StatusController::className(),
                'model' => Media::className()
            ]
        ];
    }

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => Media::find()->orderBy('order_num DESC'),
        ]);
        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate()
    {
        $model = new Media;

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                if(($fileInstanse = UploadedFile::getInstance($model, 'image')))
                {
                    $model->image = $fileInstanse;
                    if($model->validate(['image'])){
//                        $model->image = Image::upload($model->image, 'media');
                        $model->image = Image::upload($model->image, 'media', Media::PHOTO_MIN_WIDTH, Media::PHOTO_MIN_HEIGHT);
                        $model->thumb = Image::thumb($model->image, Media::PHOTO_THUMB_WIDTH, Media::PHOTO_THUMB_HEIGHT, true);
                        $model->status = Media::STATUS_ON;

                        if($model->save()){
                            $this->flash('success', Yii::t('easyii', 'Media created'));
                            return $this->redirect(['/admin/'.$this->module->id]);
                        }
                        else{
                            $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                        }
                    }
                    else {
                        $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                    }
                }
                else {
                    $this->flash('error', Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => $model->getAttributeLabel('image')]));
                }
                return $this->refresh();
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
//        $model = Media::findOne($id);
        $model = Media::find()->multilingual()->andWhere(['id' => $id])->one();
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
                if(($fileInstanse = UploadedFile::getInstance($model, 'image')))
                {
                    $model->image = $fileInstanse;
                    if($model->validate(['image'])){
                        $model->image = Image::upload($model->image, 'media', Media::PHOTO_MIN_WIDTH, Media::PHOTO_MIN_HEIGHT);
                        @unlink(Yii::getAlias('@webroot').$model->thumb);
                        $model->thumb = Image::thumb($model->image, Media::PHOTO_THUMB_WIDTH, Media::PHOTO_THUMB_HEIGHT, true);
                    }
                    else {
                        $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
                        return $this->refresh();
                    }
                }
                else{
                    $model->image = $model->oldAttributes['image'];
                }

                if($model->save()){
                    $this->flash('success', Yii::t('easyii', 'Media updated'));
                }
                else{
                    $this->flash('error', Yii::t('easyii','Update error. {0}', $model->formatErrors()));
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

    public function actionDelete($id)
    {
        if(($model = Media::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii', 'Media item deleted'));
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
        return $this->changeStatus($id, Media::STATUS_ON);
    }

    public function actionOff($id)
    {
        return $this->changeStatus($id, Media::STATUS_OFF);
    }
}