<?php
namespace yii\easyii\modules\media\api;

use Yii;
use yii\easyii\components\API;
use yii\easyii\helpers\Data;
use yii\easyii\modules\media\models\Media as MediaModel;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Media module API
 * @package yii\easyii\modules\media\api
 * @method static string widget(int $width, int $height, array $clientOptions = []) Bootstrap media widget
 * @method static array items() array of all Media items as MediaObject objects. Useful to create media on other widgets.
 */

class Media extends API
{
    public $clientOptions = ['interval' => 5000];

    private $_items = [];

    public function init()
    {
        parent::init();

        $this->_items = Data::cache(MediaModel::CACHE_KEY, 3600, function(){
            $items = [];
            foreach(MediaModel::find()->status(MediaModel::STATUS_ON)->sort()->all() as $item){
                $items[] = new MediaObject($item);
            }
            return $items;
        });
    }

    public function api_widget($width, $height, $clientOptions = [])
    {
        if(!count($this->_items)){
            return LIVE_EDIT ? Html::a(Yii::t('easyii/media/api', 'Create Media'), ['/admin/media/a/create'], ['target' => '_blank']) : '';
        }
        if(count($clientOptions)){
            $this->clientOptions = array_merge($this->clientOptions, $clientOptions);
        }

        $items = [];
        foreach($this->_items as $item){
            $temp = [
                'content' => Html::img($item->thumb($width, $height)),
                'caption' => ''
            ];
            if($item->link) {
                $temp['content'] = Html::a($temp['content'], $item->link);
            }
            if($item->title){
                $temp['caption'] .= '<h3>' . $item->title . '</h3>';
            }
            if($item->text){
                $temp['caption'] .= '<p>'.$item->text.'</p>';
            }
            $items[] = $temp;
        }

        $widget = \yii\bootstrap\Media::widget([
            'options' => ['class' => 'slide'],
            'clientOptions' => $this->clientOptions,
            'items' => $items
        ]);

        return LIVE_EDIT ? API::liveEdit($widget, Url::to(['/admin/media']), 'div') : $widget;
    }

    public function api_items()
    {
        return $this->_items;
    }
}