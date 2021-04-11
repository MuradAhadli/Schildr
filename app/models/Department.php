<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/3/2018
 * Time: 11:30 AM
 */

namespace app\models;

use yii;
use yii\helpers\VarDumper;

class Department extends yii\easyii\modules\department\models\Department
{
    public function rules()
    {
        return [];
    }

    public static function getDepartments($limit = '', $home = ''){

        return parent::find()
            ->select(
                'image, 
                easyii_department.id,
                easyii_department_lang.name,
                easyii_department_lang.slug,
                easyii_department_lang.short
                ')
            ->leftJoin('easyii_department_lang','easyii_department_lang.department_id = easyii_department.id')
            ->where([
                'status' => 1,
                'language' => yii::$app->language
            ])
            ->andWhere(['like', 'show_in_home', $home])
            ->limit($limit)
            ->orderBy('easyii_department_lang.name ASC')
            ->asArray()
            ->all();
    }

    public static function getAllDepartments()
    {
        $query = parent::find()
            ->select(
                'easyii_department.image, 
                easyii_department.id,
                dl.name,
                dl.slug,
                dl.short
                ')
            ->leftJoin('easyii_department_lang dl','dl.department_id = easyii_department.id')
            ->where(['status' => 1])
            ->andWhere(['language' => yii::$app->language])
            ->orderBy('dl.name ASC');

        $countQuery = clone $query;
        $pages = new yii\data\Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => 50
        ]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return [
            'models' => $models,
            'pages' => $pages,
        ];
    }

    public static function getFooterDepartments()
    {
        $arr = self::find()
            ->select('
                easyii_department.id,
                dl.name,
                dl.slug,
            ')
            ->leftJoin('easyii_department_lang dl','dl.department_id = easyii_department.id')
            ->where(['status' => 1])
            ->andWhere(['language' => yii::$app->language])
            ->orderBy('time DESC')
            ->asArray()
            ->all();

        return array_chunk($arr, intval(ceil(count($arr) / 2)));
    }

    public static function getDepartmentsCount()
    {
        return parent::find()
            ->where(['status' => 1])
            ->count();
    }

    public static function getDepartmentsID($id)
    {
        return Department::find()
            ->select('
            easyii_department.id,
            easyii_department_lang.slug,
            easyii_department_lang.name,
             
             ')
            ->leftJoin('easyii_department_lang','easyii_department_lang.department_id = easyii_department.id')
//            ->where(['<>','easyii_department.id', $id])
            ->andWhere(['language' => yii::$app->language])
            ->asArray()
            ->all();
    }

    public static function getDepartmentNameAz($slug)
    {
        $department = Department::find()
            ->select('easyii_department_lang.name')
            ->leftJoin('easyii_department_lang','easyii_department_lang.department_id = easyii_department.id')
            ->where(['easyii_department_lang.slug' => $slug])
            ->andWhere(['language' => 'az'])
            ->asArray()
            ->one();

        return $department['name'];
    }

    public static function getDepartmentsIN($id)
    {
        $count = Doctor::find()
            ->where(['department_id' => $id])
            ->count();


        $model = Department::find()
                ->select('
            easyii_department.id as dep_id,
            easyii_department.phone,
            easyii_department.mobile,
             easyii_department.status, 
             easyii_doctor.id,
            easyii_department_lang.name,
            easyii_department_lang.text,
            easyii_department_lang.detail_name,
             easyii_doctor_lang.name as doc_name,
             easyii_doctor_lang.slug
             ')
                ->leftJoin('easyii_department_lang','easyii_department_lang.department_id = easyii_department.id')
//            ->joinWith('doctors')
                ->leftJoin('easyii_doctor','easyii_doctor.department_id = easyii_department.id')
                ->leftJoin('easyii_doctor_lang','easyii_doctor_lang.doctor_id = easyii_doctor.id')
                ->where([
                    'easyii_department.status' => 1,
                    'easyii_department.id' => $id,
                    'easyii_department_lang.language' => yii::$app->language,
                ]);
       if ($count != 0) {
          $model = $model->andWhere(['easyii_doctor_lang.language' => yii::$app->language]);
       }
        $model = $model->asArray()
                ->one();

        return $model;
    }

    public function getDoctors()
    {
        return $this->hasMany(Doctor::className(), ['department_id' => 'id'])
            ->select('easyii_doctor.department_id, easyii_doctor_lang.name, easyii_doctor.id')
            ->leftJoin('easyii_doctor_lang', 'easyii_doctor_lang.doctor_id = easyii_doctor.id')
            ->where([
                'easyii_doctor.status' => 1,
                'easyii_doctor_lang.language' => yii::$app->language,
            ]);
    }

    public static function getDepDoctors($id)
    {
        return Doctor::find()
            ->select('easyii_doctor.id, easyii_doctor_lang.name, easyii_doctor_lang.slug')
            ->where([
                'easyii_doctor.status' => 1,
                'easyii_doctor_lang.language' => yii::$app->language,
                'easyii_doctor.department_id' => $id
            ])
            ->leftJoin('easyii_doctor_lang', 'easyii_doctor_lang.doctor_id = easyii_doctor.id')
            ->asArray()
            ->all();
    }

    public static function getDoctorsOptGroup()
    {
        $departments = Department::find()
            ->select('dl.name, easyii_department.id')
            ->leftJoin('easyii_department_lang dl','dl.department_id = easyii_department.id')
            ->joinWith('doctors')
            ->where(['dl.language' => yii::$app->language])
            ->asArray()
            ->all();

        $x = [];
        foreach ($departments as $k => $v) {

            $x[$v['name']] = yii\helpers\ArrayHelper::map($v['doctors'], 'id', 'name');
        }

        return $x;

    }

}