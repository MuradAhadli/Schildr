<?php
namespace yii\easyii\modules\page\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\easyii\behaviors\SortableController;
use yii\easyii\behaviors\StatusController;
use yii\easyii\helpers\Image;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

use yii\easyii\components\Controller;
use yii\easyii\modules\page\models\Page;

class AController extends Controller
{

    public function behaviors()
    {
        return [
            [
                'class' => SortableController::className(),
                'model' => Page::className()
            ],
            [
                'class' => StatusController::className(),
                'model' => Page::className()
            ]
        ];
    }

    public $rootActions = ['create', 'delete'];

    public function actionIndex()
    {
        $x = Page::find()
            ->select('
                easyii_pages.id,
                easyii_pages.status, 
                easyii_pages.parent_id, 
                easyii_pages.module_class, 
                easyii_pages_lang.title,
                easyii_pages_lang.slug
            ')
            ->leftJoin('easyii_pages_lang', 'easyii_pages_lang.page_id = easyii_pages.id')
            ->where([
                'language' => yii::$app->language
            ])
            ->orderBy('order_num DESC')
            ->asArray()
            ->all();

        $models = [];

        foreach ($x as $k => $v) {
            $models[$v['parent_id']][] = $v;
        }

        return $this->render('index', [
            'models' => $models
        ]);
    }

    public function actionCreate($slug = null)
    {
        $model = new Page;

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{

                if(isset($_FILES)){
                    $model->image = UploadedFile::getInstance($model, 'image');
                    if($model->image && $model->validate(['image'])){
                        $model->image = Image::upload($model->image, 'page', Page::IMAGE_WIDTH, Page::IMAGE_HEIGHT,'true');
                    }
                    else{
                        $model->image = '';
                    }
                }

                if($model->save()){
                    $this->flash('success', Yii::t('easyii/page', 'Page created'));
                    return $this->redirect(['/admin/'.$this->module->id]);
                }
                else{
                    $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
            }
        }
        else {
            if($slug) $model->slug = $slug;

            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    public function actionEdit($id)
    {
        $model = Page::find()->multilingual()->andWhere(['id' => $id])->one();

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
                if(isset($_FILES)){
                    $model->image = UploadedFile::getInstance($model, 'image');
                    if($model->image && $model->validate(['image'])){
                        $model->image = Image::upload($model->image, 'page', '', Page::IMAGE_HEIGHT);
                    }
                    else{
                        $model->image = $model->oldAttributes['image'];
                    }
                }

                if($model->save()){
                    $this->flash('success', Yii::t('easyii/page', 'Page updated'));
                }
                else{
                    $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
                }
                return $this->redirect('index');
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
        if(($model = Page::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii', 'Page deleted'));
    }

    public function actionCovers($id)
    {
        if(!($model = Page::findOne($id))){
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        return $this->render('covers', [
            'model' => $model,
        ]);
    }

    public function actionPhotos($id)
    {
        if(!($model = Page::findOne($id))){
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        return $this->render('photos', [
            'model' => $model,
        ]);
    }

    public function actionClearImage($id)
    {
        $model = Page::findOne($id);
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

    public function actionUp($id){
        return $this->move($id,'up');
    }

    public function actionDown($id){
        return $this->move($id,'down');
    }

    public function actionOn($id){
        return $this->changeStatus($id,Page::STATUS_ON);
    }

    public function actionOff($id){
        return $this->changeStatus($id,Page::STATUS_OFF);
    }
}