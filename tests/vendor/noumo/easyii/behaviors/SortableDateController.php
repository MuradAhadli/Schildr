<?php
namespace yii\easyii\behaviors;

use Yii;
use yii\helpers\VarDumper;

class SortableDateController extends \yii\base\Behavior
{
    public $model;

    public function move($id, $direction, $condition = [])
    {
        $modelClass = $this->model;
        $success = '';
        if(($model = $modelClass::findOne($id))){
            if($direction === 'up'){
                $eq = '>';
                $orderDir = 'ASC';
            } else {
                $eq = '<';
                $orderDir = 'DESC';
            }

            if(isset($model->parent_id) && $model->parent_id == '0') {
                $query = $modelClass::find()->where(['parent_id' => 0])->orderBy('time ' . $orderDir)->limit(1);
            }
            elseif (isset($model->parent_id) && $model->parent_id != '0') {
                $query = $modelClass::find()->where(['<>', 'parent_id', 0])->orderBy('time ' . $orderDir)->limit(1);
            }
            else {
                $query = $modelClass::find()->orderBy('time ' . $orderDir)->limit(1);
            }

            $where = [$eq, 'time', $model->time];
            if(count($condition)){
                $where = ['and', $where];
                foreach($condition as $key => $value){
                    $where[] = [$key => $value];
                }
            }
            $modelSwap = $query->where($where)->one();

            if(!empty($modelSwap))
            {
                $newOrderNum = $modelSwap->time;

                $modelSwap->time = $model->time;
                $modelSwap->update(true, ['time']);

                $model->time = $newOrderNum;
                $model->update(true, ['time']);

                $success = ['swap_id' => $modelSwap->primaryKey];
            }
        }
        else{
            $this->owner->error = Yii::t('easyii', 'Not found');
        }

        return $this->owner->formatResponse($success);
    }
}