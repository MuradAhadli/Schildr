<?php

namespace app\controllers;

use app\components\ModuleTextBehavior;
use app\components\UserVerifyBehavior;
use app\models\Address;
use app\models\Carousel;
use app\models\Clients;
use app\models\PageBlock;
use app\models\PageSystem;
use app\models\Partners;
use app\models\ContactForm;
use app\models\Page;
use yii\easyii\models\Setting;
//use yii\easyii\modules\address\api\Address;
use yii\easyii\modules\productcategory\models\ProductCategory;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii;
use yii\helpers\Html;

class SiteController extends Controller
{
    public $content_actions = ['contact', 'page', 'partners'];

    public function behaviors()
    {
        return [
            ModuleTextBehavior::className(),

            'user-verify' => [
                'class' => UserVerifyBehavior::className(),
                'actions' => ['contact'],
            ]
        ];
    }

    public function actionError()
    {
        $this->view->title = yii::t('db', 'Error');
        $carousel = Carousel::getCarouselByPage(51);
        $productCategories = ProductCategory::getProductCategory(0);
        $clients = Clients::getAllClients();
        $partners = Partners::getPartners();


        return $this->render('error', [
            'clients' => $clients,
            'partners' => $partners,
            'productCategories' => $productCategories,
            'carousel' => $carousel,
        ]);
    }

    public function actionIndex()
    {
        $this->view->title = 'Glass Construction';
        $clients = Clients::getAllClients();
        $partners = Partners::getPartners();
        $carousel = Carousel::getCarouselByPage(50);
        $productCategories = ProductCategory::getProductCategory(0);
        $pagesystems = PageSystem::getAllPageSystemPageSystems();

        return $this->render('index', [
            'clients' => $clients,
            'partners' => $partners,
            'productCategories' => $productCategories,
            'carousel' => $carousel,
            'pagesystems' => $pagesystems,
        ]);
    }

    public function actionAboutUs()
    {
        $this->view->title = yii::t('db', 'About Us'); //Yii translate **

        $yearsExperience = Setting::find()
            ->where(['name' => 'years_experience'])
            ->asArray()
            ->one();

        $productRange = Setting::find()
            ->where(['name' => 'product_range'])
            ->asArray()
            ->one();

        $partnerBrands = Setting::find()
            ->where(['name' => 'partner_brands'])
            ->asArray()
            ->one();

        $recidentalProjects = Setting::find()
            ->where(['name' => 'Residential_projects'])
            ->asArray()
            ->one();

        $commercialProjects = Setting::find()
            ->where(['name' => 'Commercial_projects'])
            ->asArray()
            ->one();

        $totalProjects = Setting::find()
            ->where(['name' => 'Total_projects'])
            ->asArray()
            ->one();

        $clients = Clients::getAllClients();
        $partners = Partners::getPartners();
        $pageBlocks = PageBlock::getAllBlock();
        $carousel = Carousel::getCarouselByPage(12);
        $productCategories = ProductCategory::getProductCategory(0);
//        $productCategoriesForLink = ArrayHelper::map($productCategories, 'id', 'title');

        return $this->render('about-us', [
            'clients' => $clients,
            'partners' => $partners,
            'yearsExperience' => $yearsExperience,
            'productRange' => $productRange,
            'partnerBrands' => $partnerBrands,
            'recidentalProjects' => $recidentalProjects,
            'commercialProjects' => $commercialProjects,
            'totalProjects' => $totalProjects,
            'pageBlocks' => $pageBlocks,
            'carousel' => $carousel,
            'productCategories' => $productCategories,
        ]);
    }

    public function actionPage()
    {
        $lang = yii::$app->language;


        $model = Page::findPageBySlug(yii::$app->request->get('page_slug'));
//        VarDumper::dump($lang,10,1);die();
        if (!$model) {

            throw new yii\web\NotFoundHttpException();
        }

        if ($model['language'] != $lang) {

            $slug = Page::findPageById($model['id'], $lang);

            return $this->redirect(['', 'page_slug' => $slug['slug']]);
        }

        if ($model['parent_id'] != '0') {

            $parent = Page::findParent($model['parent_id'], $lang);
        }

        return $this->render('page', [
            'model' => $model,
            'title' => isset($parent) ? $model['title'] : ''
        ]);
    }

    public function actionContact()
    {
        $model = new ContactForm();
        $clients = Clients::getAllClients();
        $partners = Partners::getPartners();
        $carousel = Carousel::getCarouselByPage(18);
        $address = Address::getAllAddress();

        $user = yii::$app->user->identity;
        $post = yii::$app->request->post();

        if ($post) {
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type: text/plain; charset=iso-8859-1\n";

            $text = '
            Ad:' . $post['first_name'] . '
            Soyad:' . $post['last_name'] . '
            Email:' . $post['email'] . '
            Telefon:' . $post['tel_no'] . '
            Küçə:' . $post['street'] . '
            Zip kod:' . $post['zip_code'] . '
            Əlavə məlumat:' . $post['message'];


            $message = Yii::$app->mailer->compose()
                ->setTo(yii::$app->params['adminEmail'])
                ->setFrom(yii::$app->params['noReplyEmail'])
                ->setTextBody($text)
                ->setSubject('Glass Construction - Feedback');

            if ($message->send()) {
                yii::$app->session->setFlash('success', Html::encode(yii::t('db', 'Thanks for contacting us! We will be in touch with you shortly.')));
            }

            return $this->redirect('contact');
        } else {

            $productCategories = ProductCategory::getProductCategory(0);

            return $this->render('contact', [
                'text' => $this->content,
                'contacts' => yii::$app->cache->get('contacts'),
                'model' => $model,
                'user' => $user,
                'clients' => $clients,
                'partners' => $partners,
                'carousel' => $carousel,
                'productCategories' => $productCategories,
                'address' => $address,
            ]);
        }
    }

}