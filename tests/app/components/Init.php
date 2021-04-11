<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/30/2018
 * Time: 12:14 PM
 */

namespace app\components;

use app\models\Contacts;
use app\models\user\VerificationCodeForm;
use yii;
use app\models\Page;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

class Init
{
    public static function init($event)
    {
        $lang = yii::$app->language;

        setlocale(LC_ALL, $lang.'_'.strtoupper($lang).'utf8');
        date_default_timezone_set('Asia/Baku');

        yii::$container->set('yii\widgets\MaskedInput', [
                'clientOptions'=>[
                    'clearIncomplete'=>true
                ]
        ]);

        $controller = yii::$app->controller;

        $session = yii::$app->session;

        $session->remove('page_id');

        if($slug = yii::$app->request->get('page_slug'))
        {
            $page_id = (new yii\db\Query())
                ->select(['page_id'])
                ->from('easyii_pages_lang')
                ->where(['slug' => $slug])
                ->one();

            $session->set('page_id', $page_id['page_id']);
        }

        // Get page title, short, text

        yii::$app->cache->set('content', [
            'title' => '',
            'short' => '',
            'text' => '',
            'parent_title' => '',
        ]);

        if(isset($page_id)) {

            $page = Page::find()
                ->select('
                easyii_pages.parent_id,
                easyii_pages_lang.title,
                easyii_pages_lang.short,
                easyii_pages_lang.text,
            ')
                ->leftJoin('easyii_pages_lang', 'easyii_pages.id = easyii_pages_lang.page_id')
                ->where([
                    'easyii_pages.id' => $page_id,
                    'easyii_pages_lang.language' => yii::$app->language
                ])
                ->asArray()
                ->one();

            $content = [
                'title' => Html::encode($page['title']),
                'short' => HtmlPurifier::process($page['short']),
                'text' => HtmlPurifier::process($page['text']),
            ];

            if ($page['parent_id']){

                $parent = Page::find()
                    ->select('easyii_pages_lang.title')
                    ->where([
                        'easyii_pages.id' => $page['parent_id'],
                        'language' => yii::$app->language
                    ])
                    ->leftJoin('easyii_pages_lang', 'easyii_pages_lang.page_id = easyii_pages.id')
                    ->asArray()
                    ->one();

                $content['parent_title'] = Html::encode($parent['title']);
            }

            yii::$app->cache->set('content', $content);
        }

        yii::$app->cache->set('contacts', Contacts::all());

        $session->set('isHome', ($controller->id == yii::$app->defaultRoute && $controller->action->id == $controller->defaultAction));
    }
}