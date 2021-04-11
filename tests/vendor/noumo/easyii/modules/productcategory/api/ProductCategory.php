<?php
namespace yii\easyii\modules\productcategory\api;

use Yii;
use yii\easyii\components\API;
use yii\easyii\helpers\Data;
use yii\easyii\modules\productcategory\models\ProductCatgeory as ProductCatgeorylModel;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Carousel module API
 * @package yii\easyii\modules\carousel\api
 * @method static string widget(int $width, int $height, array $clientOptions = []) Bootstrap carousel widget
 * @method static array items() array of all Carousel items as CarouselObject objects. Useful to create carousel on other widgets.
 */

class ProductCategory extends API
{
    public $clientOptions = ['interval' => 5000];

    private $_items = [];

    public function init()
    {
        parent::init();

        $this->_items = Data::cache(ProductCatgeoryModel::CACHE_KEY, 3600, function(){
            $items = [];
            foreach(ProductCatgeoryModel::find()->status(ProductCatgeoryModel::STATUS_ON)->sort()->all() as $item){
                $items[] = new ProductCatgeoryObject($item);
            }
            return $items;
        });
    }

    public function api_widget($width, $height, $clientOptions = [])
    {
        if(!count($this->_items)){
            return LIVE_EDIT ? Html::a(Yii::t('easyii/productcategory/api', 'Create product category'), ['/admin/productcategory/a/create'], ['target' => '_blank']) : '';
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

        $widget = \yii\bootstrap\ProductCatgeory::widget([
            'options' => ['class' => 'slide'],
            'clientOptions' => $this->clientOptions,
            'items' => $items
        ]);

        return LIVE_EDIT ? API::liveEdit($widget, Url::to(['/admin/productcategory']), 'div') : $widget;
    }

    public function api_items()
    {
        return $this->_items;
    }
}