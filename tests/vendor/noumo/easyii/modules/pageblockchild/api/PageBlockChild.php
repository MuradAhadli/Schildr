<?php
namespace yii\easyii\modules\pageblockchild\api;

use Yii;
use yii\data\ActiveDataProvider;
use yii\easyii\models\Tag;
use yii\easyii\widgets\Fancybox;
use yii\widgets\LinkPager;

use yii\easyii\modules\pageblockchild\models\PageBlockChild as PageBlockChildModel;

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

class PageBlockChild extends \yii\easyii\components\API
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
            if(Yii::$app->getModule('admin')->activeModules['pageblockchild']->settings['enableTags']){
                $with[] = 'tags';
            }
            $query = PageBlockChildModel::find()->with($with)->status(PageBlockChildModel::STATUS_ON);

            if(!empty($options['where'])){
                $query->andFilterWhere($options['where']);
            }
            if(!empty($options['tags'])){
                $query
                    ->innerJoinWith('tags', false)
                    ->andWhere([Tag::tableName() . '.name' => (new PageBlockChildModel)->filterTagValues($options['tags'])])
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
                $this->_items[] = new PageBlockChildObject($model);
            }
        }
        return $this->_items;
    }

    public function api_get($id_slug)
    {
        if(!isset($this->_item[$id_slug])) {
            $this->_item[$id_slug] = $this->findPageBlockChild($id_slug);
        }
        return $this->_item[$id_slug];
    }

    public function api_last($limit = 1)
    {
        if($limit === 1 && $this->_last){
            return $this->_last;
        }

        $with = ['seo'];
        if(Yii::$app->getModule('admin')->activeModules['PageBlockChild']->settings['enableTags']){
            $with[] = 'tags';
        }

        $result = [];
        foreach(PageBlockChildModel::find()->with($with)->status(PageBlockChildModel::STATUS_ON)->sortDate()->limit($limit)->all() as $item){
            $result[] = new PageBlockChildObject($item);
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

    private function findPageBlockChild($id_slug)
    {
        $pageblockchild = PageBlockChildModel::find()->where(['or', 'id=:id_slug', 'slug=:id_slug'], [':id_slug' => $id_slug])->status(PageBlockChildModel::STATUS_ON)->one();
        if($pageblockchild) {
            $pageblockchild->updateCounters(['views' => 1]);
            return new PageBlockChildObject($pageblockchild);
        } else {
            return null;
        }
    }
}