<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/10/2018
 * Time: 12:41 PM
 */

namespace yii\easyii\controllers;


use yii\web\Controller;

class TemplateController extends Controller
{
    public function actionDepartment()
    {
        return $this->renderPartial('index');
    }
}