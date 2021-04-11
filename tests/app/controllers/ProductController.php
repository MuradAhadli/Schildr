<?php
/**
 * Created by PhpStorm.
 * User: Qulam Alisoy
 * Date: 3/24/2018
 * Time: 10:53 AM
 */

namespace app\controllers;

use yii;
use app\components\ModuleTextBehavior;
use app\components\UserVerifyBehavior;
use app\models\Clients;
use app\models\Partners;
use yii\easyii\modules\product\models\Product;
use yii\easyii\modules\productcategory\models\ProductCategory;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class ProductController extends Controller
{
    public $content_actions = ['index'];

    public function behaviors()
    {
        return [
            ModuleTextBehavior::className(),

            'user-verify' => [
                'class' => UserVerifyBehavior::className(),
                'actions' => ['index'],
            ]
        ];
    }

}