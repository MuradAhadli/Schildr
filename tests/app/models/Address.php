<?php
namespace app\models;

use yii;

class Address extends \yii\easyii\modules\address\models\Address
{

    public static function tableName()
    {
        return 'easyii_address';
    }

    public function rules()
    {
        return [];
    }

    public static function getAllAddress()
    {
        return parent::find()
            ->select('
            easyii_address.id,
            easyii_address.general_address,
            easyii_address.title,
            easyii_address.phone,
            easyii_address.email,
            easyii_address.web,
            easyii_address.image,
            easyii_address.coor_x,
            easyii_address.coor_y,
            ')
            ->where([
                'status' => 1
            ])
            ->orderBy('order_num DESC')
            ->asArray()
            ->all();

    }


}