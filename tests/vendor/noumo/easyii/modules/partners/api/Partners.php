<?php
namespace yii\easyii\modules\partners\api;

use Yii;
use yii\data\ActiveDataProvider;
use yii\easyii\models\Tag;
use yii\easyii\widgets\Fancybox;
use yii\widgets\LinkPager;

use yii\easyii\modules\partners\models\Partners as PartnersModel;

/**
 * partners module API
 * @package yii\easyii\modules\partners\api
 *
 * @method static ProductmodelsObject get(mixed $id_slug) Get partners object by id or slug
 * @method static array items(array $options = []) Get list of partners as partnersObject objects
 * @method static mixed last(int $limit = 1) Get last partners
 * @method static void plugin() Applies FancyBox widget on photos called by box() function
 * @method static string pages() returns pagination html generated by yii\widgets\LinkPager widget.
 * @method static \stdClass pagination() returns yii\data\Pagination object.
 */

class Partners extends \yii\easyii\components\API
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
            if(Yii::$app->getModule('admin')->activeModules['partners']->settings['enableTags']){
                $with[] = 'tags';
            }
            $query = PartnersModel::find()->with($with)->status(PartnersModel::STATUS_ON);

            if(!empty($options['where'])){
                $query->andFilterWhere($options['where']);
            }
            if(!empty($options['tags'])){
                $query
                    ->innerJoinWith('tags', false)
                    ->andWhere([Tag::tableName() . '.name' => (new PartnersModel)->filterTagValues($options['tags'])])
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
                $this->_items[] = new ProductmodelsObject($model);
            }
        }
        return $this->_items;
    }

    public function api_get($id_slug)
    {
        if(!isset($this->_item[$id_slug])) {
            $this->_item[$id_slug] = $this->findPartners($id_slug);
        }
        return $this->_item[$id_slug];
    }

    public function api_last($limit = 1)
    {
        if($limit === 1 && $this->_last){
            return $this->_last;
        }

        $with = ['seo'];
        if(Yii::$app->getModule('admin')->activeModules['Partners']->settings['enableTags']){
            $with[] = 'tags';
        }

        $result = [];
        foreach(PartnersModel::find()->with($with)->status(PartnersModel::STATUS_ON)->sortDate()->limit($limit)->all() as $item){
            $result[] = new ProductmodelsObject($item);
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

    private function findPartners($id_slug)
    {
        $partners = PartnersModel::find()->where(['or', 'id=:id_slug', 'slug=:id_slug'], [':id_slug' => $id_slug])->status(PartnersModel::STATUS_ON)->one();
        if($partners) {
            $partners->updateCounters(['views' => 1]);
            return new ProductmodelsObject($partners);
        } else {
            return null;
        }
    }
}