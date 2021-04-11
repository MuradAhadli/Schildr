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
use yii\easyii\modules\examination\models\Examination;

class CheckUp extends yii\easyii\modules\checkup\models\CheckUp
{
    public function rules()
    {
        return [];
    }

    public static function getCheckUps(){

        return parent::find()
            ->select('
            easyii_checkup.id,
            easyii_checkup.price,
            easyii_checkup_lang.name,
            easyii_checkup_lang.slug
            ')
            ->leftJoin('easyii_checkup_lang','easyii_checkup_lang.checkup_id = easyii_checkup.id')
            ->where([
                'status' => 1,
                'language' => yii::$app->language,
            ])
            ->orderBy('time DESC')
            ->asArray()
            ->all();
    }

    public static function getCheckup($id){

        return parent::find()
            ->select('
            easyii_checkup.id,
            easyii_checkup.price,
            easyii_checkup.discount_price,
            easyii_checkup_lang.name,
            easyii_checkup_lang.slug,
            easyii_checkup_lang.text
            ')
            ->leftJoin('easyii_checkup_lang','easyii_checkup_lang.checkup_id = easyii_checkup.id')
            ->where([
                'status' => 1,
                'language' => yii::$app->language,
            ])
            ->andWhere(['easyii_checkup.id' => $id])
            ->orderBy('time DESC')
            ->asArray()
            ->one();
    }

    public static function getExaminations($id){

        $model = parent::find()
            ->where(['id' => $id])
            ->one()['examination_id'];

        $model = unserialize($model);

        return Examination::find()
            ->select('easyii_examination_lang.name')
            ->leftJoin('easyii_examination_lang','easyii_examination_lang.examination_id = easyii_examination.id')
            ->where(['in','easyii_examination.id',$model])
            ->andWhere(['language' => yii::$app->language])
            ->orderBy('time DESC')
            ->asArray()
            ->all();

    }
}




















