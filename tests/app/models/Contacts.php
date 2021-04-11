<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 5/17/2018
 * Time: 4:06 PM
 */

namespace app\models;

use yii;
class Contacts extends \yii\easyii\modules\contacts\models\Contacts
{
    public static function all($limit = '')
    {
        $x = self::find()
            ->select('cl.name, easyii_contacts.type')
            ->leftJoin('easyii_contacts_lang cl', 'cl.contact_id = easyii_contacts.id')
            ->where([
                'status' => 1,
                'language' => yii::$app->language
            ])
            ->orderBy('time DESC')
            ->limit($limit)
            ->asArray()
            ->all();

        foreach ($x as $k => $v) {

            $arr[$v['type']][] = $v;
        }

        return $arr;
    }
}