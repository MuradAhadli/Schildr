<?php

namespace yii\easyii\behaviors;

use Yii;

class SortableController extends \yii\base\Behavior
{
    public $model;

    public function move($id, $direction, $condition = [])
    {
        $modelClass = $this->model;
        $success = '';
        if (($model = $modelClass::findOne($id))) {
            if ($direction === 'up') {
                $eq = '>';
                $orderDir = 'ASC';
            } else {
                $eq = '<';
                $orderDir = 'DESC';
            }

            if (isset($model->parent_id) && $model->parent_id == '0') {

                $query = $modelClass::find()->where(['parent_id' => 0])->orderBy('order_num ' . $orderDir)->limit(1);
            } elseif (isset($model->parent_id) && $model->parent_id != '0') {

                $query = $modelClass::find()->where(['<>', 'parent_id', 0])->orderBy('order_num ' . $orderDir)->limit(1);
            } else {
                $query = $modelClass::find()->orderBy('order_num ' . $orderDir)->limit(1);
            }

            $where = [$eq, 'order_num', $model->order_num];
            if (count($condition)) {
                $where = ['and', $where];
                foreach ($condition as $key => $value) {
                    $where[] = [$key => $value];
                }
            }
            $modelSwap = $query->andWhere($where)->one();

            if (!empty($modelSwap)) {

                $newOrderNum = $modelSwap->order_num;

                $modelSwap->order_num = $model->order_num;
                $modelSwap->update(true, ['order_num']);

                $model->order_num = $newOrderNum;
                $model->update(true, ['order_num']);

                $success = ['swap_id' => $modelSwap->primaryKey];
            }
        } else {
            $this->owner->error = Yii::t('easyii', 'Not found');
        }

        return $this->owner->formatResponse($success);
    }
}