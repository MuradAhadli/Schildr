<?php
namespace yii\easyii\modules\mailaddresses\api;

use Yii;
use yii\easyii\helpers\Data;
use yii\easyii\modules\mailaddresses\models\mailaddresses as MailaddressesModel;


/**
 * Mailaddresses module API
 * @package yii\easyii\modules\Mailaddresses\api
 *
 * @method static array items() list of all Mailaddresses as MailaddressesObject objects
 */

class Mailaddresses extends \yii\easyii\components\API
{
    public function api_items()
    {
        return Data::cache(MailaddressesModel::CACHE_KEY, 3600, function(){
            $items = [];
            foreach(MailaddressesModel::find()->select(['mailaddresses_id', 'question', 'answer'])->status(MailaddressesModel::STATUS_ON)->sort()->all() as $item){
                $items[] = new MailaddressesObject($item);
            }
            return $items;
        });
    }
}