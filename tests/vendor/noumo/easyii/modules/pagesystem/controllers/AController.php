<?php

namespace yii\easyii\modules\pagesystem\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\easyii\behaviors\SortableController;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

use yii\easyii\components\Controller;
use yii\easyii\modules\pagesystem\models\PageSystem;
use yii\easyii\helpers\Image;
use yii\easyii\behaviors\StatusController;

class AController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => SortableController::className(),
                'model' => PageSystem::className(),
            ],
            [
                'class' => StatusController::className(),
                'model' => PageSystem::className()
            ]
        ];
    }

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => PageSystem::find()->orderBy('order_num DESC'),
        ]);

        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate()
    {
        $model = new PageSystem;
        $model->created_at = time();
        $post = yii::$app->request->post();

        if ($model->load($post)) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {
                $youtube_embed = $post['PageSystem']['youtube_embed'];

                if (isset($youtube_embed) && !empty($youtube_embed)) {

                    $content = file_get_contents("http://youtube.com/get_video_info?video_id=" . $model->youtube_embed, false, stream_context_create($model->ssl));
                    parse_str($content, $ytarr);

                    if ($ytarr['status'] == 'fail') {
                        $this->flash('error', 'Please add valid youtube valid');

                        return $this->render('create', [
                            'model' => $model
                        ]);
                    } else {
                        $model->youtube_embed = $youtube_embed;
                    }

                } else {
                    $files = $_FILES;

                    if (isset($files)) {
                        $uploadDir = 'uploads/pagesystem/';
                        $tmp_name = $files['PageSystem']['tmp_name']['file'];
                        $fileName = $files['PageSystem']['name']['file'];

                        $str = explode('.', $fileName);
                        $fileName = $str[0];
                        $ext = $str[1];

                        $fileNewName = $uploadDir . $str[1] . time() . '.' . $ext;

                        if (move_uploaded_file($tmp_name, $fileNewName)) {
                            $model->file = yii::getAlias('@web') . '/' . $fileNewName;
                        } else {
                            $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                            return $this->refresh();
                        }

                    }
                }


                if ($model->save()) {
                    $this->flash('success', Yii::t('easyii', 'PageSystem created'));
                    return $this->redirect(['/admin/' . $this->module->id]);
                } else {
                    $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
            }
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    public function actionEdit($id)
    {
        $model = PageSystem::find()->multilingual()->andWhere(['id' => $id])->one();
        $oldImage = $model->file;
        $post = yii::$app->request->post();

        if ($model === null) {
            $this->flash('error', Yii::t('easyii', 'Not found'));
            return $this->redirect(['/admin/' . $this->module->id]);
        }

        if ($model->load($post)) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {
                $model->updated_at = time();
                $youtube_embed = $post['PageSystem']['youtube_embed'];

                if (isset($youtube_embed) && !empty($youtube_embed)) {

                    $content = file_get_contents("http://youtube.com/get_video_info?video_id=" . $model->youtube_embed, false, stream_context_create($model->ssl));
                    parse_str($content, $ytarr);

                    if ($ytarr['status'] == 'fail') {
                        $this->flash('error', 'Please add valid youtube valid');

                        return $this->render('create', [
                            'model' => $model
                        ]);
                    } else {
                        $model->youtube_embed = $youtube_embed;
                    }

                } else {

                    $model->youtube_embed = '';
                    $files = $_FILES;
                    if (isset($files['PageSystem']['name']['file']) && !empty($files['PageSystem']['name']['file'])) {
                        $uploadDir = 'uploads/pagesystem/';
                        $tmp_name = $files['PageSystem']['tmp_name']['file'];
                        $fileName = $files['PageSystem']['name']['file'];

                        $str = explode('.', $fileName);
                        $fileName = $str[0];
                        $ext = $str[1];

                        $fileNewName = $uploadDir . $str[1] . time() . '.' . $ext;

                        if (move_uploaded_file($tmp_name, $fileNewName)) {
                            $model->file = yii::getAlias('@web') . '/' . $fileNewName;
                        } else {
                            $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                            return $this->redirect('index');
                        }
                    }
                }


                if (empty($model->file)) {
                    $model->file = $oldImage;
                }

                if ($model->save()) {

                    unlink(yii::getAlias('@web') . $oldImage);
                    $this->flash('success', Yii::t('easyii', 'PageSystem created'));
                    return $this->redirect(['/admin/' . $this->module->id]);
                } else {
                    $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
            }
        } else {
            return $this->render('edit', [
                'model' => $model
            ]);
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $settings = Yii::$app->getModule('admin')->activeModules['pagesystems']->settings;
            $this->short = StringHelper::truncate($settings['enableShort'] ? $this->short : strip_tags($this->text), $settings['shortMaxLength']);

            if (!$insert && $this->image != $this->oldAttributes['file'] && $this->oldAttributes['file']) {
                @unlink(Yii::getAlias('@webroot') . $this->oldAttributes['file']);
            }
            return true;
        } else {
            return false;
        }
    }


    public function actionPhotos($id)
    {
        if (!($model = PageSystem::findOne($id))) {
            return $this->redirect(['/admin/' . $this->module->id]);
        }

        return $this->render('photos', [
            'model' => $model,
        ]);
    }

    public
    function actionDelete($id)
    {
        if (($model = PageSystem::findOne($id))) {
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii', 'PageSystem deleted'));
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
        return $this->changeStatus($id, PageSystem::STATUS_ON);
    }

    public function actionOff($id)
    {
        return $this->changeStatus($id, PageSystem::STATUS_OFF);
    }
}