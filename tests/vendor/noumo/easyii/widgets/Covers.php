<?php
namespace yii\easyii\widgets;

use Yii;
use yii\base\Widget;
use yii\base\InvalidConfigException;
use yii\easyii\models\Cover;

class Covers extends Widget
{
    public $model;

    public function init()
    {
        parent::init();

        if (empty($this->model)) {
            throw new InvalidConfigException('Required `model` param isn\'t set.');
        }
    }

    public function run()
    {
        $covers = Cover::find()
            ->multilingual()
            ->andWhere([
                'class' => get_class($this->model),
                'item_id' => $this->model->primaryKey
            ])
            ->orderBy('order_num DESC')
            ->all();

        echo $this->render('covers', [
            'covers' => $covers
        ]);
    }
}