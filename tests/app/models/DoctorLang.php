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

class DoctorLang extends yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'easyii_doctor_lang';
    }

    public function rules()
    {
        return [];
    }

}