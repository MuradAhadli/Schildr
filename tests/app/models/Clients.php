<?php

namespace app\models;

use yii;

class Clients extends \yii\easyii\modules\clients\models\Clients
{
    public static function tableName()
    {
        return 'easyii_clients';
    }

    public function rules()
    {
        return [];
    }

    public static function getClients()
    {
        return Parent::getAllClients();
    }

}