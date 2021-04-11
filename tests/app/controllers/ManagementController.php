<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/12/2018
 * Time: 3:03 PM
 */

namespace app\controllers;


use app\components\ModuleTextBehavior;
use yii\easyii\modules\management\models\Management;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii;

class ManagementController extends Controller
{
    public $content_actions = ['index', 'view'];

    public function behaviors()
    {
        return [
            ModuleTextBehavior::className()
        ];
    }

    public function actionIndex()
    {

        $models = Management::find()
            ->select('
            easyii_management.id,
            easyii_management.image,
            easyii_management_lang.username, 
            easyii_management_lang.short,
            easyii_management_lang.position,
            easyii_management_lang.slug
            ')
            ->leftJoin('easyii_management_lang', 'easyii_management_lang.management_id = easyii_management.id')
            ->where([
                'status' => 1,
                'language' => yii::$app->language
            ])
            ->orderBy('time DESC')
            ->asArray()
            ->all();

        return $this->render('index',[
            'models' => $models,
            'text' => $this->content
        ]);
    }

    public function actionView($id)
    {

        $model = Management::find()
            ->select('
            easyii_management.image,
            easyii_management.social,
            easyii_management_lang.username, 
            easyii_management_lang.short,
            easyii_management_lang.text,
            easyii_management_lang.position,
            easyii_management.email,
            ')
            ->leftJoin('easyii_management_lang', 'easyii_management_lang.management_id = easyii_management.id')
            ->where([
                'easyii_management.status' => 1,
                'easyii_management_lang.language' => yii::$app->language,
                'easyii_management.id' => $id
            ])
            ->asArray()
            ->all();

//        VarDumper::dump($model[0],10,1); die();
        return $this->render('view',[
            'model' => $model[0],
            'content' => $this->content
        ]);
    }
}