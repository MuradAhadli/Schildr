<?php
namespace yii\easyii\modules\checkupform\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\easyii\behaviors\SortableDateController;
use yii\easyii\modules\checkupform\CheckupFormModule;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

use yii\easyii\components\Controller;
use yii\easyii\helpers\Image;
use yii\easyii\behaviors\StatusController;
use \yii\easyii\modules\checkupform\models\CheckUp;

class AController extends Controller
{
    public function actionIndex()
    {
        $query = CheckUp::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $datas = $query->offset($pages->offset)
            ->select('
            easyii_checkup_form.id as form_id,
            easyii_checkup_form.created_at,
            easyii_checkup_form.status,
            easyii_checkup_form.username,
            easyii_checkup_lang.name as checkup_name,
            ')
            ->where(['easyii_checkup_lang.language' => yii::$app->language])
//            ->joinWith('checkupsName')
                ->leftJoin('easyii_checkup','easyii_checkup.id = easyii_checkup_form.checkup_id')
                ->leftJoin('easyii_checkup_lang','easyii_checkup_lang.checkup_id = easyii_checkup.id')
            ->orderBy(['easyii_checkup_form.created_at' => SORT_DESC])
            ->limit($pages->limit)
            ->asArray()
            ->all();

//        VarDumper::dump($datas,10,1); die();
        return $this->render('index', [
            'datas' => $datas,
            'pages' => $pages,
        ]);
    }

    public function actionEdit($id){

        $model_status = CheckUp::findOne($id);

        if ($model_status->status == 0){
            $model_status->status = 1;
            $model_status->save();
        }

        $model = CheckUp::find()
            ->select('
            easyii_checkup_form.id as form_id,
            easyii_checkup_form.created_at,
            easyii_checkup_form.status,
            easyii_checkup_form.username,
            easyii_checkup_form.text,
            easyii_checkup_form.email,
            easyii_checkup_form.phone,
            easyii_checkup_form.birthday,
            easyii_checkup_lang.name as checkup_name,
            ')
            ->where([
                'easyii_checkup_lang.language' => yii::$app->language,
                'easyii_checkup_form.id' => $id
            ])
            ->leftJoin('easyii_checkup','easyii_checkup.id = easyii_checkup_form.checkup_id')
            ->leftJoin('easyii_checkup_lang','easyii_checkup_lang.checkup_id = easyii_checkup.id')
            ->orderBy(['easyii_checkup_form.status' => SORT_ASC])
            ->asArray()
            ->one();

//        VarDumper::dump($model,10,1); die();
        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    public function actionStatus($id)
    {
        $model = CheckUp::findOne($id);

        if ($model->status == 1){
            $model->status = 2;
            $model->save();
        }
        return $this->redirect(yii::$app->request->referrer);
    }
}