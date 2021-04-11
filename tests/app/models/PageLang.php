<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/18/2018
 * Time: 3:18 PM
 */

namespace app\models;


use yii\db\ActiveRecord;

class PageLang extends ActiveRecord
{
    public static function tableName()
    {
        return 'easyii_pages_lang';
    }
}