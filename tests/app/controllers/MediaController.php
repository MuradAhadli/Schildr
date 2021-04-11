<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/12/2018
 * Time: 3:03 PM
 */

namespace app\controllers;


use app\components\ModuleTextBehavior;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii;
use yii\easyii\modules\media\models\Media;
use yii\data\Pagination;
use yii\easyii\modules\video\models\Video;
use app\models\Page;

class MediaController extends Controller
{
    public $module_route = [
        'photo' => 'media',
        'video' => 'video'
    ];

    public $content_actions = ['photo', 'video', '360'];

    public function behaviors()
    {
        return [
            ModuleTextBehavior::className()
        ];
    }

    public function actionPhoto()
    {
        $req = yii::$app->request;

        $query = Media::find()
            ->select('
                easyii_media.id,
                image, thumb,
                ml.title
            ')
            ->leftJoin('easyii_media_lang ml', 'ml.media_id = easyii_media.id')
            ->where(['status' => 1])
            ->groupBy('easyii_media.id')
            ->orderBy('order_num DESC');

        if($cat_id = $req->get('cat_id')) {

            $query = $query->andWhere(['category_id' => $cat_id]);
        }

        $countQuery = clone $query;

        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => 18
            ]);

        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();

        return $this->render('photo', [
            'models' => $models,
            'pages' => $pages,
            'content' => $this->content,
            'cat_id' => $cat_id ? $cat_id : ''
        ]);
    }

    public function actionVideo()
    {
        $req = yii::$app->request;

        $query = Video::find()
            ->select('link, title')
            ->groupBy('easyii_video.id')
            ->orderBy('order_num DESC')
            ->where(['status' => 1]);

        if($cat_id = $req->get('cat_id')) {

            $query = $query->andWhere(['category_id' => $cat_id]);
        }

        $countQuery = clone $query;

        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => 18
        ]);

        $models = $query->offset($pages->offset)
            ->asArray()
            ->limit($pages->limit)
            ->all();

        return $this->render('video', [
            'models' => $models,
            'pages' => $pages,
            'content' => $this->content,
            'cat_id' => $cat_id ? $cat_id : ''
        ]);
    }

    public function action360()
    {
        return $this->render('360', [
            'content' => $this->content,
        ]);
    }

}