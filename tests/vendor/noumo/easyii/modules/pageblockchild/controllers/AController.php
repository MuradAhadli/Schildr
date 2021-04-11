<?php

namespace yii\easyii\modules\pageblockchild\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\easyii\behaviors\SortableDateController;
use yii\easyii\modules\pageblock\models\PageBlock;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;
use yii\easyii\components\Controller;
use yii\easyii\modules\pageblockchild\models\PageBlockChild;
use yii\easyii\helpers\Image;
use yii\easyii\behaviors\StatusController;

class AController extends Controller
{
    const IMAGE_MIN_WIDTH = 1250;
    const IMAGE_MIN_HEIGHT = 750;


    public function behaviors()
    {
        return [
            [
                'class' => SortableDateController::className(),
                'model' => PageBlockChild::className(),
            ],
            [
                'class' => StatusController::className(),
                'model' => PageBlockChild::className()
            ]
        ];
    }

    public function actionIndex()
    {
        $data = \app\models\PageBlockChild::getAllPageBlockChildWithParent();

        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate()
    {

        $model = new PageBlockChild;
        $model->created_at = time();

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {
                if (isset($_FILES)) {
                    $model->image = UploadedFile::getInstance($model, 'image');
                    if ($model->image && $model->validate(['image'])) {
                        $model->image = Image::upload($model->image, 'pageblockchild',1200, 720,true);
                    }
                } else {
                    $model->image = '';
                }

                if ($model->save()) {
                    $this->flash('success', Yii::t('easyii', 'PageBlockChild created'));
                    return $this->redirect(['/admin/' . $this->module->id]);
                } else {
                    $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
            }
        } else {
            $pageBlocks = PageBlock::getAllPageBlock();
            $pageBlocks = ArrayHelper::map($pageBlocks, 'id', 'title');
            return $this->render('create', [
                'model' => $model,
                'pageBlocks' => $pageBlocks
            ]);
        }
    }

    public function actionEdit($id)
    {
        $model = PageBlockChild::find()->multilingual()->andWhere(['id' => $id])->one();
        $oldImage = $model->image;
        if ($model === null) {
            $this->flash('error', Yii::t('easyii', 'Not found'));
            return $this->redirect(['/admin/' . $this->module->id]);
        }

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {
                if (isset($_FILES['PageBlockChild']['name']['image']) && !empty($_FILES['PageBlockChild']['name']['image'])) {
                    $model->image = UploadedFile::getInstance($model, 'image');
                    if ($model->image && $model->validate('image')) {
                        @unlink(Yii::getAlias('@webroot') . $oldImage);
                        $model->image = Image::upload($model->image, 'pageblockchild',1200, 720,true);

                    }
                } else {
                    $model->image = $oldImage;
                }
                $model->updated_at = time();

                if ($model->save()) {
                    $this->flash('success', Yii::t('easyii', 'PageBlockChild updated'));
                } else {
                    $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
                }
                return $this->redirect('index');
            }
        } else {
            $pageBlocks = PageBlock::getAllPageBlock();
            $pageBlocks = ArrayHelper::map($pageBlocks, 'id', 'title');
            return $this->render('edit', [
                'model' => $model,
                'pageBlocks' => $pageBlocks
            ]);
        }
    }

    public function actionPhotos($id)
    {
        if (!($model = PageBlockChild::findOne($id))) {
            return $this->redirect(['/admin/' . $this->module->id]);
        }

        return $this->render('photos', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        if (($model = PageBlockChild::findOne($id))) {
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii', 'PageBlockChild deleted'));
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
        return $this->changeStatus($id, PageBlockChild::STATUS_ON);
    }

    public function actionOff($id)
    {
        return $this->changeStatus($id, PageBlockChild::STATUS_OFF);
    }
}