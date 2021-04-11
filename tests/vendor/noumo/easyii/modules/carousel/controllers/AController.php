<?php

namespace yii\easyii\modules\carousel\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Command;
use yii\debug\models\search\Db;
use yii\easyii\modules\carousel\models\CarouselUploads;
use yii\easyii\modules\page\models\Page;
use yii\easyii\modules\productcategory\models\ProductCategory;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

use yii\easyii\components\Controller;
use yii\easyii\modules\carousel\models\Carousel;
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
                'model' => Carousel::className()
            ],
            [
                'class' => StatusController::className(),
                'model' => Carousel::className()
            ]
        ];
    }

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => Carousel::find()
//                ->leftJoin('easyii_pages_lang', 'easyii_pages_lang.page_id = easyii_carousel.page_id')
                ->orderBy('order_num DESC'),
            'pagination' => [
                'pageSize' => 20,
            ],

        ]);

        return $this->render('index', [
            'data' => $data,
        ]);
    }

    public function actionCreate()
    {
        $db = yii::$app->db;
        $post = yii::$app->request->post();
        $model = new Carousel;

        if (Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post())) {
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                } else {
                    //VarDumper::dump(Yii::$app->request->post()['Carousel']['category_id_help'],6,1); die();
                    if (isset($_FILES)) {
                        $modelUploads = new CarouselUploads();
                        $model->status = Carousel::STATUS_ON;

                        if(isset(Yii::$app->request->post()['Carousel']['category_id_help'])){
                            $model->category_id = Yii::$app->request->post()['Carousel']['category_id_help'];
                        }elseif(isset(Yii::$app->request->post()['Carousel']['category_id'])){
                            $model->category_id = Yii::$app->request->post()['Carousel']['category_id'];
                        }else{
                            $model->category_id = 0;
                        }

                        if ($model->save(false)) {
                            $this->flash('success', Yii::t('easyii', 'Carousel created'));
                        } else {
                            $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                        }
                        foreach ($_FILES['Carousel']['name']['image'] as $key => $val) {
                            $modelUploadsId = $model->id;
                            $fileInstanse = UploadedFile::getInstance($model, 'image[' . $key . ']');
                            $modelUploads->file_name = $fileInstanse;
                            if ($modelUploads->validate(['file_name'])) {
                                if ($modelUploads->file_name) {
                                    $modelUploads->file_name = Image::upload($modelUploads->file_name, 'carousel', Carousel::IMAGE_MIN_WIDTH, Carousel::IMAGE_MAX_HEIGHT, true);
                                    $modelUploads->carousel_id = $modelUploadsId;
                                    $db->createCommand()
                                        ->batchInsert('easyii_carousel_uploads', ['file_name', 'carousel_id'], [[$modelUploads->file_name, $model->id],])
                                        ->execute();
                                }

                            } else {
                                $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                            }
                        }

                    }
                    return $this->redirect('index');
                }
            }
        } else {
            $pages = ArrayHelper::map(Page::getAllPages(), 'id', 'title');
            $categories = ArrayHelper::map(ProductCategory::getProductCategory(0), 'id', 'title');
            $altCategory = ArrayHelper::map(ProductCategory::getChildCategory(),'id','title');
            return $this->render('create', [
                'model' => $model,
                'pages' => $pages,
                'categories' => $categories,
                'altCategory' => $altCategory,
            ]);
        }
    }

    public function actionEdit($id)
    {
        $db = yii::$app->db;
        $post = yii::$app->request->post();
        $model = Carousel::find()->multilingual()->andWhere(['id' => $id])->one();
        if ($model === null) {
            $this->flash('error', Yii::t('easyii', 'Not found'));
            return $this->redirect(['/admin/' . $this->module->id]);
        }

        $oldPageId = $model->page_id;
        $oldCategoryId = $model->category_id;

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {

                //Check out model page id and category id ...
                if(isset($post['page_id']) && !empty($post['page_id'])){
                    $model->page_id = $post['page_id'];
                }else{
                    $model->page_id = $oldPageId;
                }

                if(isset($post['category_id']) && !empty($post['category_id'])){
                    $model->category_id = $post['category_id'];
                }else{
                    $model->category_id = $oldCategoryId;
                }
                /** /check**/

                if (isset($_FILES)) {
                    $modelUploads = new CarouselUploads();
                    $model->status = Carousel::STATUS_ON;

                    if(Yii::$app->request->post()['Carousel']['category_id_help'] > 0){
                        $model->category_id = Yii::$app->request->post()['Carousel']['category_id_help'];
                    }elseif(Yii::$app->request->post()['Carousel']['category_id'] > 0){
                        $model->category_id = Yii::$app->request->post()['Carousel']['category_id'];
                    }else{
                        $model->category_id = 0;
                    }

                    if ($model->save(false)) {
                        $this->flash('success', Yii::t('easyii', 'Carousel created'));
                    } else {
                        $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                    }

                    if (isset($_FILES['Carousel']['name']['image'][0]) && !empty($_FILES['Carousel']['name']['image'][0])) {

                        foreach ($_FILES['Carousel']['name']['image'] as $key => $val) {
                            $modelUploadsId = $model->id;
                            $fileInstanse = UploadedFile::getInstance($model, 'image[' . $key . ']');
                            $modelUploads->file_name = $fileInstanse;
                            if ($modelUploads->validate(['file_name'])) {
                                if ($modelUploads->file_name) {
                                    $modelUploads->file_name = Image::upload($modelUploads->file_name, 'carousel', Carousel::IMAGE_MIN_WIDTH, Carousel::IMAGE_MAX_HEIGHT, true);
                                    $modelUploads->carousel_id = $modelUploadsId;

                                    $db->createCommand()
                                        ->batchInsert('easyii_carousel_uploads', ['file_name', 'carousel_id'], [[$modelUploads->file_name, $model->id],])
                                        ->execute();
                                }

                            } else {
                                $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                            }
                        }
                    }
                    return $this->redirect('index');
                }
            }
        } else {
            $pages = Page::getAllPages();
            $pages = ArrayHelper::map($pages, 'id', 'title');
            $carouselUploads = CarouselUploads::getCarouselUploads($id);
            $categories = ArrayHelper::map(ProductCategory::getProductCategory(), 'id', 'title');
            $altCategory = ArrayHelper::map(ProductCategory::getChildCategory(),'id','title');

            return $this->render('edit', [
                'model' => $model,
                'pages' => $pages,
                'carouselUploads' => $carouselUploads,
                'categories' => $categories,
                'altCategory' => $altCategory,
            ]);
        }
    }

    public function actionDelete($id)
    {
        if (($model = Carousel::findOne($id))) {
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii', 'Carousel item deleted'));
    }


    public function actionDeleteCarouselItem()
    {
        $id = yii::$app->request->post('id');
        $model = CarouselUploads::find()
            ->where(['id' => $id])
            ->one();
        if ($model->delete()) {
            return true;
        }
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
        return $this->changeStatus($id, Carousel::STATUS_ON);
    }

    public function actionOff($id)
    {
        return $this->changeStatus($id, Carousel::STATUS_OFF);
    }
}