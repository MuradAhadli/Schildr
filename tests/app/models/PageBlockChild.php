<?php
/**
 * Created by PhpStorm.
 * User: Qulam ALisoy
 * Date: 4/3/2018
 * Time: 3:58 PM
 */

namespace app\models;

use yii;
class PageBlockChild extends \yii\easyii\modules\pageblockchild\models\PageBlockChild
{
    const TYPE_VIDEO = 1;
    const TYPE_IMAGE = 0;

    public function rules()
    {
        return [];
    }

    public static function getAllPageBlockChild()
    {
        return parent::getAllPageBlockChild();
    }
    


}