<?php

namespace yii\easyii\modules\partners\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\easyii\behaviors\SortableController;
use yii\easyii\modules\clients\models\Clients;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

use yii\easyii\components\Controller;
use yii\easyii\modules\partners\models\Partners;
use yii\easyii\helpers\Image;
use yii\easyii\behaviors\StatusController;

class AController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => SortableController::className(),
                'model' => Partners::className(),
            ],
            [
                'class' => StatusController::className(),
                'model' => Partners::className()
            ]
        ];
    }

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => Partners::find()->orderBy(['order_num' => SORT_DESC]),
        ]);

        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate()
    {
        $model = new Partners;
        $model->created_at = time();

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {
                if (isset($_FILES)) {
                    $model->image = UploadedFile::getInstance($model, 'image');
                    if ($model->image && $model->validate(['image'])) {
                        $model->image = Image::upload($model->image, '../../partners', Partners::IMAGE_WIDTH, Partners::IMAGE_HEIGHT, true);
                    } else {
                        $model->image = '';
                    }
                }
                if ($model->save()) {
                    $this->flash('success', Yii::t('easyii', 'Partners created'));
                    return $this->redirect(['/admin/' . $this->module->id]);
                } else {
                    $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
            }
        } else {
            $clients = Clients::getAllClients();
            $clients = ArrayHelper::map($clients, 'id', 'name');

            return $this->render('create', [
                'model' => $model,
                'clients' => $clients,
            ]);
        }
    }

    public function actionEdit($id)
    {
        $model = Partners::find()->multilingual()->andWhere(['id' => $id])->one();
        $model->updated_at = time();

        if ($model === null) {
            $this->flash('error', Yii::t('easyii', 'Not found'));
            return $this->redirect(['/admin/' . $this->module->id]);
        }

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {
                if (isset($_FILES)) {
                    $model->image = UploadedFile::getInstance($model, 'image');
                    if ($model->image && $model->validate(['image'])) {
                        $model->image = Image::upload($model->image, 'partners', Partners::IMAGE_WIDTH, Partners::IMAGE_HEIGHT, true);
                    } else {
                        $model->image = $model->oldAttributes['image'];
                    }
                }

                if ($model->save()) {
                    $this->flash('success', Yii::t('easyii', 'Partners updated'));
                } else {
                    $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
                }
                return $this->redirect('index');
            }
        } else {
            $clients = Clients::getAllClients();
            $clients = ArrayHelper::map($clients, 'id', 'name');
            return $this->render('edit', [
                'model' => $model,
                'clients' => $clients
            ]);
        }
    }

    public function actionPhotos($id)
    {
        if (!($model = Partners::findOne($id))) {
            return $this->redirect(['/admin/' . $this->module->id]);
        }

        return $this->render('photos', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        if (($model = Partners::findOne($id))) {
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii', 'Partners deleted'));
    }

    public function actionClearImage($id)
    {
        $model = Partners::findOne($id);

        if ($model === null) {
            $this->flash('error', Yii::t('easyii', 'Not found'));
        } else {
            $model->image = '';
            if ($model->update(true, ['image'])) {
                @unlink(Yii::getAlias('@webroot') . $model->image);
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
        return $this->changeStatus($id, Partners::STATUS_ON);
    }

    public function actionOff($id)
    {
        return $this->changeStatus($id, Partners::STATUS_OFF);
    }
}