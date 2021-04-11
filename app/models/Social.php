<?php
/**
 * Created by PhpStorm.
 * User: Qulam Alisoy
 * Date: 4/4/2018
 * Time: 12:26 PM
 */

namespace app\models;


class Social extends \yii\easyii\modules\social\models\Social
{
    public static function getSocial()
    {
        return Social::find()
            ->where(['status' => 1])
            ->orderBy('time DESC')
            ->asArray()
            ->all();
    }
}