<?php

namespace yii\easyii\modules\productcategory\controllers;
use Yii;
use yii\data\ActiveDataProvider;
use yii\easyii\components\Controller;
use yii\easyii\helpers\Image;
use yii\easyii\behaviors\SortableController;
use yii\easyii\behaviors\StatusController;
use yii\easyii\modules\productcategory\models\ProductCategory;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;
use tpmanc\imagick\Imagick;

class AController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => SortableController::className(),
                'model' => ProductCategory::className()
            ],
            [
                'class' => StatusController::className(),
                'model' => ProductCategory::className()
            ]
        ];
    }


    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => ProductCategory::find()
                ->orderBy('order_num DESC'),
        ]);

        $productCategories = ProductCategory::getProductCategoriesWithParent();

        return $this->render('index', [
            'data' => $data,
            'productCategories' => $productCategories,
        ]);
    }

    public function actionCreate()
    {
        $model = new ProductCategory();
        $post = yii::$app->request->post();

        if ($model->load($post) && $model->validate()) {

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {
                if (isset($_FILES)) {

                    $model->image = UploadedFile::getInstance($model, 'image');
                    if ($model->image && $model->validate(['image'])) {
                        $model->image = Image::upload($model->image, 'productcategory', ProductCategory::IMAGE_MIN_WIDTH, ProductCategory::IMAGE_MIN_HEIGHT, true);
                    }


                    if(isset($_FILES['ProductCategory']['name']['second_image']) && !empty($_FILES['ProductCategory']['name']['second_image'])){
                        $model->second_image = UploadedFile::getInstance($model, 'second_image');
                        if ($model->second_image && $model->validate(['second_image'])) {
                            $model->second_image = Image::upload($model->second_image, 'productcategory', ProductCategory::IMAGE_MIN_WIDTH, ProductCategory::IMAGE_MIN_HEIGHT, true);
                        }
                    }else{
                        $model->second_image = '';
                    }

                } else {
                    $model->image = '';
                }
                $model->created_at = time();
                if ($model->save()) {
                    $this->flash('success', Yii::t('easyii', 'PageBlockChild created'));
                    return $this->redirect(['index']);
                } else {
                    $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
            }

        } else {
            $parents = ProductCategory::getProductCategory(0);
            $parents = ArrayHelper::map($parents, 'id', 'title');

            return $this->render('create', [
                'model' => $model,
                'parents' => $parents,
            ]);
        }

    }

    public function actionEdit($id)
    {
        $model = ProductCategory::find()->multilingual()->where(['id' => $id])->one();
        $oldImage = $model->image;
        $oldSecondImage = $model->second_image;
        $post = yii::$app->request->post();

        if ($model === null) {
            $this->flash('error', Yii::t('easyii', 'Not found'));
            return $this->redirect(['/admin/' . $this->module->id]);
        }

        if (yii::$app->request->post()) {

            if (isset($_FILES['ProductCategory']['name']['image']) && empty($_FILES['ProductCategory']['name']['image'])) {
                $image = $model->image;
            }

            if (isset($_FILES['ProductCategory']['name']['second_image']) && empty($_FILES['ProductCategory']['name']['second_image'])) {
                $second_image = $model->second_image;
            }

            if ($model->load($post) && $model->validate()) {
                if (Yii::$app->request->isAjax) {
                    yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                } else {

                    if (
                        (isset($_FILES['ProductCategory']['name']['image']) && !empty($_FILES['ProductCategory']['name']['image']))
                        || (!isset($_FILES['ProductCategory']['name']['second_image']) && !empty($_FILES['ProductCategory']['name']['second_image']))
                    ) {
                        $model->image = UploadedFile::getInstance($model, 'image');
                        if ($model->image && $model->validate('image')) {
                            @unlink(Yii::getAlias('@webroot') . $oldImage);
                            $model->image = Image::upload($model->image, 'productcategory', ProductCategory::IMAGE_MIN_WIDTH, ProductCategory::IMAGE_MIN_HEIGHT, true);
                        }

                        $model->second_image = UploadedFile::getInstance($model, 'second_image');
                        if ($model->second_image && $model->validate('second_image')) {
                            @unlink(Yii::getAlias('@webroot') . $oldSecondImage);
                            $model->second_image = Image::upload($model->second_image, 'productcategory', ProductCategory::IMAGE_MIN_WIDTH, ProductCategory::IMAGE_MIN_HEIGHT, true);
                        }
                    } else {
                        $model->image = $image;
                        $model->second_image = $second_image;
                    }

                    $model->updated_at = time();
                    if ($model->save()) {
                        $this->flash('success', Yii::t('easyii', 'PageBlockChild updated'));
                        return $this->redirect('index');

                    } else {
                        $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
                        return $this->refresh();
                    }
                }

            } else {
                $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
                return $this->refresh();
            }

        } else {
            $modelParents = ProductCategory::getProductCategory(0);
            $modelParents = ArrayHelper::map($modelParents, 'id', 'title');
            $parents = [];

            $id = yii::$app->request->get('id');


            foreach ($modelParents as $key => $val) {
                if ($key !== $id) {
                    $parents[$key] = $val;
                }
            }

            return $this->render('edit', [
                'model' => $model,
                'parents' => $parents,
            ]);

        }
    }

    public function actionDelete($id)
    {
        if (($model = ProductCategory::findOne($id))) {
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii', 'Product Category item deleted'));
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
        return $this->changeStatus($id, ProductCategory::STATUS_ON);
    }

    public function actionOff($id)
    {
        return $this->changeStatus($id, ProductCategory::STATUS_OFF);
    }
}