<?php

namespace yii\easyii\modules\footerlink\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\easyii\behaviors\SortableController;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;
use yii\easyii\components\Controller;
use yii\easyii\modules\footerlink\models\FooterLink;
use yii\easyii\helpers\Image;
use yii\easyii\behaviors\StatusController;


class AController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => SortableController::className(),
                'model' => FooterLink::className(),
            ],
            [
                'class' => StatusController::className(),
                'model' => FooterLink::className()
            ]
        ];
    }

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => FooterLink::find()->orderBy(['id' => SORT_DESC]),
        ]);

        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate()
    {
        $model = new FooterLink;
        $model->created_at = time();

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {

                if ($model->save()) {
                    $this->flash('success', Yii::t('easyii', 'FooterLink created'));
                    return $this->redirect(['/admin/' . $this->module->id]);
                } else {
                    $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
            }
        } else {
            $footerLinks = FooterLink::getFooterLinks();
            $footerLinks = ArrayHelper::map($footerLinks, 'id', 'title');

            return $this->render('create', [
                'model' => $model,
                'footerLinks' => $footerLinks
            ]);
        }
    }

    public function actionEdit($id)
    {
        $model = FooterLink::find()->multilingual()->andWhere(['id' => $id])->one();
        if ($model === null) {
            $this->flash('error', Yii::t('easyii', 'Not found'));
            return $this->redirect(['/admin/' . $this->module->id]);
        }

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {
                $model->updated_at = time();
                if ($model->save()) {
                    $this->flash('success', Yii::t('easyii', 'FooterLink updated'));
                } else {
                    $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
                }
                return $this->redirect('index');
            }
        } else {
            $footerLinks = FooterLink::getFooterLinks();
            $footerLinks = ArrayHelper::map($footerLinks, 'id', 'title');
            return $this->render('edit', [
                'model' => $model,
                'footerLinks' => $footerLinks
            ]);
        }
    }

    public function actionPhotos($id)
    {
        if (!($model = FooterLink::findOne($id))) {
            return $this->redirect(['/admin/' . $this->module->id]);
        }

        return $this->render('photos', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        if (($model = FooterLink::findOne($id))) {
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii', 'FooterLink deleted'));
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
        return $this->changeStatus($id, FooterLink::STATUS_ON);
    }

    public function actionOff($id)
    {
        return $this->changeStatus($id, FooterLink::STATUS_OFF);
    }
}