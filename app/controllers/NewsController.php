<?php
/**
 * Created by PhpStorm.
 * User: Qulam
 * Date: 5/3/2018
 * Time: 4:25 PM
 */

namespace app\controllers;


use app\components\ModuleTextBehavior;
use app\models\News;
use yii\web\Controller;
use yii;

class NewsController extends Controller
{
    public $content_actions = ['index', 'view'];

    public function behaviors()
    {
        return [
            ModuleTextBehavior::className()
        ];
    }

    public function actionIndex()
    {
        $query = News::find()
            ->select('
                n.id,
                n.image,
                n.time,
                nl.news_id,
                nl.title,
                nl.short,
                nl.slug
            ')
            ->from('easyii_news n')
            ->leftJoin('easyii_news_lang nl', 'nl.news_id = n.id')
            ->where([
                'status' => 1,
                'language' => yii::$app->language
            ])
            ->orderBy('time DESC');

        $count = $query->count();

        $pagination = new yii\data\Pagination(['totalCount' => $count, 'defaultPageSize' => 12]);

        $news = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();

//        yii\helpers\VarDumper::dump($news,10,1); die();

        return $this->render('index', [
            'text' => $this->content,
            'models' => $news,
            'pagination' => $pagination
        ]);
    }

    public function actionView($id, $slug)
    {

        $news = News::getNewsIn($id, $slug);

        $other_news = News::getOtherNews($id);

        return $this->render('view', [
            'news' => $news,
            'other_news' => $other_news,
            'content' => $this->content
        ]);
    }
}