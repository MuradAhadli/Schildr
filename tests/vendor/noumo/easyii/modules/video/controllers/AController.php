<?php
namespace yii\easyii\modules\video\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

use yii\easyii\components\Controller;
use yii\easyii\modules\video\models\Video;
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
                'model' => Video::className()
            ],
            [
                'class' => StatusController::className(),
                'model' => Video::className()
            ]
        ];
    }

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => Video::find()->orderBy('order_num DESC'),
        ]);
        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate()
    {
        $model = new Video;

        if ($model->load(Yii::$app->request->post())) {

            if(Yii::$app->request->isAjax){

                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                if($model->validate()) {

                    $content = file_get_contents("http://youtube.com/get_video_info?video_id=".$model->link, false, stream_context_create($model->ssl));
                    parse_str($content, $ytarr);

                    if($ytarr['status'] == 'fail') {
                        $this->flash('error', 'Please add valid youtube valid');

                        return $this->render('create', [
                            'model' => $model
                        ]);
                    }

                    $model->title = $ytarr['title'];

                    if($model->save(false)){
                        $this->flash('success', Yii::t('easyii', 'Media created'));
                        return $this->redirect(['/admin/'.$this->module->id]);
                    }
                    else{
                        $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                    }
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
        $model = Video::find()->andWhere(['id' => $id])->one();
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

                if($model->validate()) {

                    $content = file_get_contents("http://youtube.com/get_video_info?video_id=".$model->link, false, stream_context_create($model->ssl));
                    parse_str($content, $ytarr);

                    if($ytarr['status'] == 'fail') {

                        $this->flash('error', 'Please add valid youtube valid');

                        return $this->render('edit', [
                            'model' => $model
                        ]);
                    }

                    $model->title = $ytarr['title'];

                    if($model->save(false)){
                        $this->flash('success', Yii::t('easyii', 'Media updated'));
                    }
                    else{
                        $this->flash('error', Yii::t('easyii','Update error. {0}', $model->formatErrors()));
                    }

                    return $this->refresh();
                }
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
        if(($model = Video::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii', 'Video item deleted'));
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
        return $this->changeStatus($id, Video::STATUS_ON);
    }

    public function actionOff($id)
    {
        return $this->changeStatus($id, Video::STATUS_OFF);
    }
}