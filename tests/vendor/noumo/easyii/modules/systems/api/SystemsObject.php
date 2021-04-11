<?php
namespace yii\easyii\modules\systems\api;

use Yii;
use yii\easyii\components\API;
use yii\helpers\Html;
use yii\helpers\Url;

class SystemsObject extends \yii\easyii\components\ApiObject
{
    public $image;
    public $description;

    public function box($width, $height){
        $img = Html::img($this->thumb($width, $height));
        $a = Html::a($img, $this->image, [
            'class' => 'easyii-box',
            'rel' => 'systems-'.$this->model->item_id,
            'title' => $this->description
        ]);
        return LIVE_EDIT ? API::liveEdit($a, $this->editLink) : $a;
    }

    public function getEditLink(){
        return Url::to(['/admin/systems/a/photos', 'id' => $this->model->item_id]).'#photo-'.$this->id;
    }
}