<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/3/2018
 * Time: 3:58 PM
 */

namespace app\models;

use yii;
class Carousel extends \yii\easyii\modules\carousel\models\Carousel
{
    const TYPE_VIDEO = 1;
    const TYPE_IMAGE = 0;

    public function rules()
    {
        return [];
    }

    /**
     * @return array|yii\db\ActiveRecord[]
     */
    public static function getCarousel()
    {
        return parent::find()
            ->select('
                easyii_carousel.id, 
                easyii_carousel.image,
                easyii_carousel.link,
                easyii_carousel.type,
                easyii_carousel_lang.language,
                easyii_carousel_lang.title,
                easyii_carousel_lang.short,
            ')
            ->leftJoin('easyii_carousel_lang', 'easyii_carousel_lang.carousel_id = easyii_carousel.id')
            ->where([
                'language' => yii::$app->language,
                'status' => 1
            ])
            ->orderBy('order_num DESC')
            ->asArray()
            ->all();
    }

    /**
     * @param $page_id
     * @return array|yii\db\ActiveRecord[]
     */
    public static function getCarouselByPage($page_id)
    {
        return parent::getCarouselByPage($page_id);
    }

    /**
     * @param $category_id
     * @return array|yii\db\ActiveRecord[]
     */
    public static function getCarouselByCategory($category_id)
    {
        return parent::getCarouselByCategory($category_id);
    }

}