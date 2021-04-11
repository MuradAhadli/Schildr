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

class Doctor extends yii\easyii\modules\doctor\models\Doctor
{
    public function rules()
    {
        return [];
    }

    public static function getDoctors($limit = '', $home = '')
    {
        return parent::find()
            ->select('
                easyii_doctor.id as doc_id,
                easyii_doctor_lang.position,
                easyii_doctor_lang.name,
                easyii_doctor_lang.slug,
                easyii_user.image,
                easyii_user.id as us_id
            ')
            ->leftJoin('easyii_doctor_lang', 'easyii_doctor_lang.doctor_id = easyii_doctor.id')
            ->leftJoin('easyii_user', 'easyii_user.id = easyii_doctor.user_id')
            ->where([
                'easyii_doctor.status' => 1,
                'language' => yii::$app->language,
            ])
            ->andWhere(['like', 'show_in_home', $home])
            ->limit($limit)
            ->orderBy('easyii_doctor_lang.name ASC')
            ->asArray()
            ->all();

    }

    public static function getAllDoctors($id = ''){
//        echo $id; die();
        $query = parent::find()
            ->select('
                easyii_doctor.id as doc_id,
                dl.position,
                dl.slug,
                dl.name,
                easyii_user.image,
                easyii_user.id as user_id,
                
            ')
            ->leftJoin('easyii_doctor_lang dl', 'dl.doctor_id = easyii_doctor.id')
            ->leftJoin('easyii_user', 'easyii_user.id = easyii_doctor.user_id')
            ->where([
                'easyii_doctor.status' => 1,
                'language' => yii::$app->language,
            ])
            ->orderBy(['time' => SORT_DESC]);

        if($id) {

            $query->andWhere(['easyii_doctor.department_id' => $id]);
        }

        //$query->orderBy('dl.name ASC')
        $query->asArray();

        $countQuery = clone $query;
        $pages = new yii\data\Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => 24
        ]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return [
            'models' => $models,
            'pages' => $pages,
        ];

    }

    public static function getDoctorsCount()
    {
        return parent::find()
            ->where(['status' => 1])
            ->count();
    }

    public function getDoctorWorkHours(){
        return $this->hasMany(yii\easyii\modules\doctorworkhours\models\DoctorWorkHours::className(), ['doctor_id' => 'id']);
    }

    public function getLangs()
    {
        return $this->hasOne(DoctorLang::className(), ['doctor_id' => 'id']);
    }
}