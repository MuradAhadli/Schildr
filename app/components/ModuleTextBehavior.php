<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/30/2018
 * Time: 10:42 AM
 */

namespace app\components;

use yii;
use yii\base\Behavior;
use yii\web\Controller;

class ModuleTextBehavior extends Behavior
{
    public $content;

    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
    }

    public function beforeAction($event)
    {
        if(!isset($this->owner->content_actions)) {

            throw new yii\base\InvalidConfigException('You must set $content_actions property to you controller');
        }

        if(in_array($event->action->id, $this->owner->content_actions)) {

            $this->content = [
                'title' => '',
                'short' => '',
                'text' => '',
                'parent_title' => '',
            ];

            if(yii::$app->cache->exists('content')) {

                $this->content = yii::$app->cache->get('content');
            }
        }
    }
}