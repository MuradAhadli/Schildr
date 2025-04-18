<?php
namespace yii\easyii\controllers;

use Yii;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;
use yii\web\Response;

use yii\easyii\helpers\Image;
use yii\easyii\components\Controller;
use yii\easyii\models\Photo;
use yii\easyii\behaviors\SortableController;

class PhotosController extends Controller
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
                'model' => Photo::className(),
            ]
        ];
    }

    public function actionUpload($class, $item_id)
    {
        $success = null;

        $photo = new Photo;
        $photo->class = $class;
        $photo->item_id = $item_id;
        $photo->type = Photo::TYPE_PHOTO;
        $photo->image = UploadedFile::getInstance($photo, 'image');

        if($photo->image && $photo->validate(['image'])){
            $photo->image = Image::upload($photo->image, 'photos', Photo::PHOTO_MAX_WIDTH, Photo::PHOTO_MAX_HEIGHT);
            $photo->thumb = Image::thumb($photo->image, Photo::PHOTO_THUMB_WIDTH, Photo::PHOTO_THUMB_HEIGHT, true);

            if($photo->image){
                if($photo->save()){
                    $success = [
                        'message' => Yii::t('easyii', 'Photo uploaded'),
                        'photo' => [
                            'id' => $photo->primaryKey,
                            'image' => $photo->image,
                            'thumb' => $photo->thumb,
                            'description' => ''
                        ]
                    ];
                }
                else{
                    @unlink(Yii::getAlias('@webroot') . str_replace(Url::base(true), '', $photo->image));
                    @unlink(Yii::getAlias('@webroot') . str_replace(Url::base(true), '', $photo->thumb));
                    $this->error = Yii::t('easyii', 'Create error. {0}', $photo->formatErrors());
                }
            }
            else{
                $this->error = Yii::t('easyii', 'File upload error. Check uploads folder for write permissions');
            }
        }
        else{
            print_r($photo->getErrors()); die();
            if($photo->hasErrors('image')) {
                $this->error = $photo->getErrors('image')[0];
            }
            else {
                $this->error = Yii::t('easyii', 'File is incorrect');
            }
        }

        return $this->formatResponse($success);
    }

    public function actionUploadVideo()
    {
        if ($get = yii::$app->request->get()){

//            VarDumper::dump($get,10,1); die();
            $video = new Photo();

//            VarDumper::dump($video,10,1); die();
            $video->class = $get['class'];
            $video->item_id = $get['item_id'];
            $video->youtube_id = $get['youtubeID'];
            $video->type = Photo::TYPE_VIDEO;

            if ($video->save()){
                return 'success';
            }
        }

    }

    public function actionDescription($id)
    {
        if($model = Photo::find()->multilingual()->andWhere(['photo_id' => $id])->one())
        {
            if($model->load(yii::$app->request->post()) && $model->save())
            {
                $this->error = '';
            }
            else{

                $this->error = Yii::t('easyii', 'Bad response');
            }

//            print_r($model->getErrors()); die();
        }
        else{
            $this->error = Yii::t('easyii', 'Not found');
        }

        return $this->formatResponse(Yii::t('easyii', 'Photo description saved'));
    }

    public function actionImage($id)
    {
        $success = null;

        if(($photo = Photo::findOne($id)))
        {
            $oldImage = $photo->image;
            $oldThumb = $photo->thumb;

            $photo->image = UploadedFile::getInstance($photo, 'image');

            if($photo->image && $photo->validate(['image'])){

                $photo->image = Image::upload($photo->image, 'photos', Photo::PHOTO_MAX_WIDTH, Photo::PHOTO_MAX_HEIGHT);
                $photo->thumb = Image::thumb($photo->image, Photo::PHOTO_THUMB_WIDTH, Photo::PHOTO_THUMB_HEIGHT, true);

                if($photo->image){
                    if($photo->save()){
                        @unlink(Yii::getAlias('@webroot').$oldImage);
                        @unlink(Yii::getAlias('@webroot').$oldThumb);

                        $success = [
                            'message' => Yii::t('easyii', 'Photo uploaded'),
                            'photo' => [
                                'image' => $photo->image,
                                'thumb' => $photo->thumb
                            ]
                        ];
                    }
                    else{
                        @unlink(Yii::getAlias('@webroot').$photo->image);
                        @unlink(Yii::getAlias('@webroot').$photo->thumb);

                        $this->error = Yii::t('easyii', 'Update error. {0}', $photo->formatErrors());
                    }
                }
                else{
                    $this->error = Yii::t('easyii', 'File upload error. Check uploads folder for write permissions');
                }
            }
            else{
                if($photo->hasErrors('image')) {
                    $this->error = $photo->getErrors('image')[0];
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
        if(($model = Photo::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii', 'Photo deleted'));
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