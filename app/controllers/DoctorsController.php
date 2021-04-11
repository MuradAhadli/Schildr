<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 3/23/2018
 * Time: 3:28 PM
 */

namespace app\controllers;


use app\components\ModuleTextBehavior;
use app\models\Department;
use app\models\Doctor;
use app\models\Page;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii;

class DoctorsController extends Controller
{
    public $content_actions = ['index'];

    public function behaviors()
    {
        return [
            ModuleTextBehavior::className()
        ];
    }

    public function actionIndex()
    {
        $id = yii::$app->request->get('category_id');

        $doctor = Doctor::getAllDoctors($id);

        return $this->render('index', [
            'models' => $doctor['models'],
            'pages' => $doctor['pages'],
            'departments' => Department::getDepartments(),
            'text' => $this->content
        ]);
    }

    public function actionView($id)
    {
        $module = Doctor::find()
            ->select(
                'easyii_doctor.id,
                 easyii_user.image,
                 easyii_user.email,
                 easyii_doctor_lang.text, 
                 easyii_doctor_lang.short, 
                 easyii_doctor_lang.name,
                 easyii_doctor_lang.slug,
                 easyii_doctor.social,
                ')
            ->joinWith('doctorWorkHours')
            ->leftJoin('easyii_doctor_lang', 'easyii_doctor_lang.doctor_id = easyii_doctor.id')
            ->leftJoin('easyii_user', 'easyii_user.id = easyii_doctor.user_id')
            ->where([
                'easyii_doctor.status' => 1,
                'easyii_doctor.id' => $id,
                'language' => yii::$app->language
            ])
            ->asArray()
            ->one();

        if($module) {
            return $this->render('view',[
                'module' => $module
            ]);
        }

        throw new yii\web\NotFoundHttpException();
    }
}