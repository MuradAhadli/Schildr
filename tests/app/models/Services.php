<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 5/10/2018
 * Time: 10:51 AM
 */

namespace app\models;

use yii;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;

class Services extends \yii\easyii\modules\services\models\Services
{
    public static function all($fixed_column = false)
    {
        $models = self::find()
            ->select('
                s.id,
                s.parent_id,
                sl.name,
                sl.text,
                sl.slug,
            ')
            ->from('easyii_services s')
            ->where([
                'status' => 1,
                'language' => yii::$app->language
            ])
            ->leftJoin('easyii_services_lang sl','sl.service_id = s.id')
            ->orderBy('sl.name ASC')
            ->asArray()
            ->all();


        foreach ($models as $k => $v) {

            $arrr[$v['parent_id']][] = $v;
        }

        // Max items in per column
        $c = intval(count($models) / 3);


        $i = 0;
        $x = 0;

        foreach ($models as $k => $v) {

            if($v['parent_id'] == '0') {

//                if($i >= $c) {
//
//                    $i = 0;
//                    $x++;
//                }

                $arr[$v['parent_id']][] = array_merge($v, ['count' => isset($arrr[$v['id']]) ? count($arrr[$v['id']]) : 0]);
            }
            else {
                $arr['childs'][$v['parent_id']][] = $v;
            }


            $i++;
        }


        /*for ($i = 0; $i < count($arr[0]); $i++) {

            $x = 0;

            foreach ($arr[0][$i] as $key => $val) {

                $x += $val['count'];

                if($val['count'] == 0) {

                    $arr['single'][$val['id']] = $val;

                    unset($arr[0][$i][$key]);
                }
                else {
                    $a[] = $val;
                }


                if($x >= $c) {

                    $y = $i;

                    $y++;

                    if(isset($arr[0][$y])) {

                        array_unshift($arr[0][$y], $val);

                        unset($arr[0][$i][$key]);
                    }
                }
            }
        }*/
        $x = 0;
        $y = 0;

        foreach ($arr[0] as $k => $v) {

            if($x >= $c) {

                $y++;

                $x = 0;
            }

            if($v['count'] == 0) {

                $arr['single'][$v['id']] = $v;

                unset($arr[0][$k]);
            }
            else {
                $arr['parents'][$y][] = $v;
            }
            $x += $v['count'];
        }


        /*if($fixed_column) {

            $arr[0] = array_chunk($a, 3);
        }*/

        return $arr;
    }

    public static function getService($id = '')
    {
        return self::find()
            ->select('
                s.id,
                s.parent_id,
                sl.service_id,
                sl.name,
                sl.text,
                sl.slug
            ')
            ->from('easyii_services s')
            ->leftJoin('easyii_services_lang sl', 'sl.service_id = s.id')
            ->where([
                'status' => 1,
                's.id' => $id,
                'language' => yii::$app->language
            ])
            ->asArray()
            ->one();
    }
}