<?php
/**
 * Created by PhpStorm.
 * User: Qulam Alisoy
 * Date: 4/3/2018
 * Time: 11:30 AM
 */

namespace app\models;

use yii;
use yii\helpers\VarDumper;

class FooterLink extends yii\easyii\modules\footerlink\models\FooterLink
{
    public function rules()
    {
        return [];
    }


    public static function getLinks()
    {
        $footerLinks = parent::getAllFooterLinks();

        $Arr = [];
        foreach ($footerLinks as $key => $val) {
            if ($val['parent_id'] == 0) {

                foreach ($footerLinks as $item) {

                    if ($val['id'] == $item['parent_id']) {
                        $Arr[$val['title']][] = $item;
                    }
                }

                if(empty($Arr[$val['title']])){
                    $Arr[$val['title']][] = $val;
                }

            }
        }

        return $Arr;
    }


}