<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 3/17/2018
 * Time: 3:35 PM
 */

namespace app\widgets\Media;

use yii\base\Widget;
use yii\easyii\models\Photo;
use yii\easyii\modules\page\models\Page;
use yii\helpers\VarDumper;

class MediaWidget extends Widget
{
    public $class_name;
    public $item_id;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $models = Photo::find()
            ->select('thumb, image, item_id, type, youtube_id')
            ->where([
                'class' => $this->class_name,
                'item_id' => $this->item_id
            ])
            ->asArray()
            ->orderBy('order_num DESC')
            ->all();

        if ($models){
            return $this->render('index',[
                'models' => $models
            ]);
        }

    }
}