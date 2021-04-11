<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 3/17/2018
 * Time: 3:35 PM
 */

namespace app\widgets\Sections;

use yii\base\Widget;
use yii\easyii\modules\page\models\Page;
use yii\helpers\VarDumper;

class SectionsWidget extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('index',[
            'models' => \app\models\Page::getSection(),
        ]);
    }
}