<?php
namespace yii\easyii\modules\address\api;

use Yii;
use yii\data\ActiveDataProvider;
use yii\easyii\models\Tag;
use yii\easyii\widgets\Fancybox;
use yii\widgets\LinkPager;

use yii\easyii\modules\address\models\Address as AddressModel;

/**
 * partners module API
 * @package yii\easyii\modules\partners\api
 *
 * @method static partnersObject get(mixed $id_slug) Get partners object by id or slug
 * @method static array items(array $options = []) Get list of partners as partnersObject objects
 * @method static mixed last(int $limit = 1) Get last partners
 * @method static void plugin() Applies FancyBox widget on photos called by box() function
 * @method static string pages() returns pagination html generated by yii\widgets\LinkPager widget.
 * @method static \stdClass pagination() returns yii\data\Pagination object.
 */

class Address extends \yii\easyii\components\API
{
    private $_adp;
    private $_last;
    private $_items;
    private $_item = [];

    public function api_items($options = [])
    {
        if(!$this->_items){
            $this->_items = [];

            $with = ['seo'];
            if(Yii::$app->getModule('admin')->activeModules['address']->settings['enableTags']){
                $with[] = 'tags';
            }
            $query = AddressModel::find()->with($with)->status(AddressModel::STATUS_ON);

            if(!empty($options['where'])){
                $query->andFilterWhere($options['where']);
            }
            if(!empty($options['tags'])){
                $query
                    ->innerJoinWith('tags', false)
                    ->andWhere([Tag::tableName() . '.title' => (new AddressModel)->filterTagValues($options['tags'])])
                    ->addGroupBy('id');
            }
            if(!empty($options['orderBy'])){
                $query->orderBy($options['orderBy']);
            } else {
                $query->sortDate();
            }

            $this->_adp = new ActiveDataProvider([
                'query' => $query,
                'pagination' => !empty($options['pagination']) ? $options['pagination'] : []
            ]);

            foreach($this->_adp->models as $model){
                $this->_items[] = new AddressObject($model);
            }
        }
        return $this->_items;
    }

    public function api_get($id_slug)
    {
        if(!isset($this->_item[$id_slug])) {
            $this->_item[$id_slug] = $this->findAddress($id_slug);
        }
        return $this->_item[$id_slug];
    }

    public function api_last($limit = 1)
    {
        if($limit === 1 && $this->_last){
            return $this->_last;
        }

        $with = ['seo'];
        if(Yii::$app->getModule('admin')->activeModules['Address']->settings['enableTags']){
            $with[] = 'tags';
        }

        $result = [];
        foreach(AddressModel::find()->with($with)->status(AddressModel::STATUS_ON)->sortDate()->limit($limit)->all() as $item){
            $result[] = new AddressObject($item);
        }

        if($limit > 1){
            return $result;
        } else {
            $this->_last = count($result) ? $result[0] : null;
            return $this->_last;
        }
    }

    public function api_plugin($options = [])
    {
        Fancybox::widget([
            'selector' => '.easyii-box',
            'options' => $options
        ]);
    }

    public function api_pagination()
    {
        return $this->_adp ? $this->_adp->pagination : null;
    }

    public function api_pages()
    {
        return $this->_adp ? LinkPager::widget(['pagination' => $this->_adp->pagination]) : '';
    }

    private function findAddress($id_slug)
    {
        $address = AddressModel::find()->where(['or', 'id=:id_slug', 'slug=:id_slug'], [':id_slug' => $id_slug])->status(AddressModel::STATUS_ON)->one();
        if($address) {
            $address->updateCounters(['views' => 1]);
            return new AddressObject($address);
        } else {
            return null;
        }
    }
}