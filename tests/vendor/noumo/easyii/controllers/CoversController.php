<?php
namespace yii\easyii\controllers;

use Yii;
use yii\easyii\models\Cover;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\web\Response;

use yii\easyii\helpers\Image;
use yii\easyii\components\Controller;
use yii\easyii\behaviors\SortableController;

class CoversController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ],
            ],
            [
                'class' => SortableController::className(),
                'model' => Cover::className(),
            ]
        ];
    }

    public function actionUpload($class, $item_id)
    {
        $success = null;

        $cover = new Cover;
        $cover->class = $class;
        $cover->item_id = $item_id;
        $cover->image = UploadedFile::getInstance($cover, 'image');

        if($cover->image && $cover->validate(['image'])){
            $cover->image = Image::upload($cover->image, 'covers', Cover::PHOTO_MIN_WIDTH, Cover::PHOTO_MAX_HEIGHT, true);

            if($cover->image){
                if($cover->save()){
                    $success = [
                        'message' => Yii::t('easyii', 'Cover uploaded'),
                        'cover' => [
                            'id' => $cover->primaryKey,
                            'image' => $cover->image,
                            'description' => ''
                        ]
                    ];
                }
                else{
                    @unlink(Yii::getAlias('@webroot') . str_replace(Url::base(true), '', $cover->image));
                    $this->error = Yii::t('easyii', 'Create error. {0}', $cover->formatErrors());
                }
            }
            else{
                $this->error = Yii::t('easyii', 'File upload error. Check uploads folder for write permissions');
            }
        }
        else{
            if($cover->hasErrors('image')) {
                $this->error = $cover->getErrors('image')[0];
            }
            else {
                $this->error = Yii::t('easyii', 'File is incorrect');
            }
        }

        return $this->formatResponse($success);
    }

    public function actionDescription($id)
    {
        if($model = Cover::find()->multilingual()->andWhere(['id' => $id])->one())
        {
            if($model->load(yii::$app->request->post()) && $model->save())
            {
                $this->error = '';
            }
            else{
                $this->error = Yii::t('easyii', 'Bad response');
            }
        }
        else{
            $this->error = Yii::t('easyii', 'Not found');
        }

        return $this->formatResponse(Yii::t('easyii', 'Cover description saved'));
    }

    public function actionImage($id)
    {
        $success = null;

        if(($cover = Cover::findOne($id)))
        {
            $oldImage = $cover->image;

            $cover->image = UploadedFile::getInstance($cover, 'image');

            if($cover->image && $cover->validate(['image'])){

                $cover->image = Image::upload($cover->image, 'covers', Cover::PHOTO_MIN_WIDTH, Cover::PHOTO_MAX_HEIGHT, true);

                if($cover->image){
                    if($cover->save()){
                        @unlink(Yii::getAlias('@webroot').$oldImage);

                        $success = [
                            'message' => Yii::t('easyii', 'Cover uploaded'),
                            'cover' => [
                                'image' => $cover->image,
                            ]
                        ];
                    }
                    else{
                        @unlink(Yii::getAlias('@webroot').$cover->image);

                        $this->error = Yii::t('easyii', 'Update error. {0}', $cover->formatErrors());
                    }
                }
                else{
                    $this->error = Yii::t('easyii', 'File upload error. Check uploads folder for write permissions');
                }
            }
            else{
                if($cover->hasErrors('image')) {
                    $this->error = $cover->getErrors('image')[0];
                }
                else {
                    $this->error = Yii::t('easyii', 'File is incorrect');
                }
            }

        }
        else{
            $this->error =  Yii::t('easyii', 'Not found');
        }

        return $this->formatResponse($success);
    }

    public function actionDelete($id)
    {
        if(($model = Cover::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii', 'Cover deleted'));
    }

    public function actionUp($id, $class, $item_id)
    {
        return $this->move($id, 'up', ['class' => $class, 'item_id' => $item_id]);
    }

    public function actionDown($id, $class, $item_id)
    {
        return $this->move($id, 'down', ['class' => $class, 'item_id' => $item_id]);
    }
}