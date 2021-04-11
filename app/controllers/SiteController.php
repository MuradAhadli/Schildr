<?php

namespace app\controllers;

use app\components\ModuleTextBehavior;
use app\components\UserVerifyBehavior;
use app\models\Address;
use app\models\Carousel;
use app\models\Clients;
use app\models\DealerForm;
use app\models\PageBlock;
use app\models\PageSystem;
use app\models\Partners;
use app\models\ContactForm;
use app\models\Page;
use app\models\QuoteForm;
use yii\easyii\models\Setting;
//use yii\easyii\modules\address\api\Address;
use yii\easyii\modules\productcategory\models\ProductCategory;
use yii\easyii\modules\product\models\Product;
use yii\easyii\modules\productmodels\models\Productmodels;
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
    public function actionSuccess()
    {
        $this->view->title = yii::t('db', 'Success');
        $carousel = Carousel::getCarouselByPage(58);
        $productCategories = ProductCategory::getProductCategory(0);
        $clients = Clients::getAllClients();
        $partners = Partners::getPartners();


        return $this->render('success', [
            'clients' => $clients,
            'partners' => $partners,
            'productCategories' => $productCategories,
            'carousel' => $carousel,
        ]);
    }

    public function actionIndex()
    {
        $this->view->title = 'Schildr Outdoor Solutions, New Jersey ';
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
    public function actionBlog()
    {
        $this->view->title = 'Schildr Outdoor Solutions, New Jersey ';
        $clients = Clients::getAllClients();
        $partners = Partners::getPartners();
        $carousel = Carousel::getCarouselByPage(58);
        $productCategories = ProductCategory::getProductCategory(0);
        $pagesystems = PageSystem::getAllPageSystemPageSystems();
        $blogs = Page::getAllBlogPages();

        return $this->render('blog', [
            'blogs'=>$blogs,
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

    public function actionDealer()
    {
        $model = new DealerForm();
        $clients = Clients::getAllClients();
        $partners = Partners::getPartners();
        $carousel = Carousel::getCarouselByPage(58);
        $address = Address::getAllAddress();

        $user = yii::$app->user->identity;

        $post = yii::$app->request->post();
        $secretKey = '6LdmC5MaAAAAAEeNRx_fEElI4jGxKuvfZYGHKjLF';
        $responseKey = $post['g-recaptcha-response'];
        $userIP = $_SERVER['REMOTE_ADDR'];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
        $response = file_get_contents($url);
        $response = json_decode($response);
        if ($post) {
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type: text/plain; charset=iso-8859-1\n";

            $text = '
            Name : ' . $post['first_name'] . '
            Last Name : ' . $post['last_name'] . '
            Company Name : ' . $post['company_name'] . '
            Email Address : ' . $post['email'] . '
            Phone : ' . $post['tel_no'] . '
            Do you currently resell and/or install awning products ? ' . $post['question-1'] . '
            Do you own and operate a shop or showroom ? ' . $post['question-2'] . '
            Serving Areas : ' . $post['areas'] . '
            Additional Comments : ' . $post['message'];
            $message = Yii::$app->mailer->compose()
                ->setTo(yii::$app->params['adminEmail'])
                ->setFrom(yii::$app->params['noReplyEmail'])
                ->setTextBody($text)
                ->setSubject('Schildr - Become a dealer');

            if ($response->success){
                if ($message->send()) {
                    return $this->redirect('success');
//                $model->save();
//                    yii::$app->session->setFlash('success', Html::encode(yii::t('db', 'Thanks for contacting us! We will be in touch with you shortly.')));
                }
            }
            else{
                yii::$app->session->setFlash('error', Html::encode(yii::t('db', 'ReCaptcha failed.')));
                return $this->redirect('become-a-dealer');
            }

        } else {

            $productCategories = ProductCategory::getProductCategory(0);

            return $this->render('dealer', [
                'text' => $this->content,
                'contacts' => yii::$app->cache->get('dealer'),
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
    public function actionStatic($id)
    {
        $page = Page::getPageById($id);
        $clients = Clients::getAllClients();
        $partners = Partners::getPartners();
        $carousel = Carousel::getCarouselByPage($id);
        $address = Address::getAllAddress();

        return $this->render('static', [
            'page' => $page,
            'clients' => $clients,
            'partners' => $partners,
            'carousel' => $carousel,
            'address' => $address,
        ]);
    }
    public function actionQuote($id)
    {
        $model = new QuoteForm();
        $clients = Clients::getAllClients();
        $partners = Partners::getPartners();
        $carousel = Carousel::getCarouselByPage(58);
        $address = Address::getAllAddress();

        $user = yii::$app->user->identity;
        $post = yii::$app->request->post();

        if ($post) {
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type: text/plain; charset=iso-8859-1\n";
            $secretKey = '6LdmC5MaAAAAAEeNRx_fEElI4jGxKuvfZYGHKjLF';
            $responseKey = $post['g-recaptcha-response'];
            $userIP = $_SERVER['REMOTE_ADDR'];
            $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
            $response = file_get_contents($url);
            $response = json_decode($response);
            $text = '
            Product : '.$post['product'].',
            Model : '. implode(" , " , $post['model']).',
            Name : ' . $post['first_name'] . '
            Last Name : ' . $post['last_name'] . '
            Zip Code : ' . $post['zip_code'] . '
            Email Address : ' . $post['email'] . '
            Phone : ' . $post['tel_no'] . '
            Width ' . $post['width'] . '
            Depth  ' . $post['projection'] . '
            Additional Comments : ' . $post['message'];
            $message = Yii::$app->mailer->compose()
                ->setTo(yii::$app->params['adminEmail'])
                ->setFrom(yii::$app->params['noReplyEmail'])
                ->setTextBody($text)
                ->setSubject('Schildr - Get Quote');
            if ($response->success){
                if ($message->send()) {
                    return $this->redirect('/success');
//                $model->save();
//                    yii::$app->session->setFlash('success', Html::encode(yii::t('db', 'Thanks for contacting us! We will be in touch with you shortly.')));
                }
            }
            else{
                yii::$app->session->setFlash('error', Html::encode(yii::t('db', 'ReCaptcha failed.')));
                return $this->redirect('/get-quote/'.$id);
            }
//            return $this->redirect('/get-quote/'.$id);
        } else {

            $productCategories = ProductCategory::getProductCategory(0);
            $product = Product::getProduct($id);
            $productmodels = Productmodels::getQuoteProductModelByParent($id);
            return $this->render('quote', [
                'text' => $this->content,
                'contacts' => yii::$app->cache->get('quote'),
                'model' => $model,
                'user' => $user,
                'clients' => $clients,
                'partners' => $partners,
                'carousel' => $carousel,
                'productCategories' => $productCategories,
                'product' => $product,
                'productmodels' =>$productmodels,
                'address' => $address,
            ]);
        }
    }
    public function actionQuotes()
    {
        $model = new QuoteForm();
        $clients = Clients::getAllClients();
        $partners = Partners::getPartners();
        $carousel = Carousel::getCarouselByPage(58);
        $address = Address::getAllAddress();

        $user = yii::$app->user->identity;
        $post = yii::$app->request->post();

        if ($post) {
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type: text/plain; charset=iso-8859-1\n";
            $secretKey = '6LdmC5MaAAAAAEeNRx_fEElI4jGxKuvfZYGHKjLF';
            $responseKey = $post['g-recaptcha-response'];
            $userIP = $_SERVER['REMOTE_ADDR'];
            $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
            $response = file_get_contents($url);
            $response = json_decode($response);
            $text = '
            Product: '. implode(" , " , $post['product']).'
            Model: '. implode(" , " , $post['model']).'
            Name:' . $post['first_name'] . '
            Last Name:' . $post['last_name'] . '
            Zip Code:' . $post['zip_code'] . '
            Email Address:' . $post['email'] . '
            Phone :' . $post['tel_no'] . '
            Width ' . $post['width'] . '
            Depth  ' . $post['projection'] . '
            Additional Comments:' . $post['message'];
            $message = Yii::$app->mailer->compose()
                ->setTo(yii::$app->params['adminEmail'])
                ->setFrom(yii::$app->params['noReplyEmail'])
                ->setTextBody($text)
                ->setSubject('Schildr - Get Quote');

            if ($response->success){
                if ($message->send()) {
                    return $this->redirect('/success');
//                $model->save();
//                    yii::$app->session->setFlash('success', Html::encode(yii::t('db', 'Thanks for contacting us! We will be in touch with you shortly.')));
                }
            }
            else{
                yii::$app->session->setFlash('error', Html::encode(yii::t('db', 'ReCaptcha failed.')));
                return $this->redirect('get-quote');
            }


        } else {

            $productCategories = ProductCategory::getProductCategory(0);
            return $this->render('quote', [
                'text' => $this->content,
                'contacts' => yii::$app->cache->get('quote'),
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

    public function actionContact()
    {
        $model = new ContactForm();
        $clients = Clients::getAllClients();
        $partners = Partners::getPartners();
        $carousel = Carousel::getCarouselByPage(18);
        $address = Address::getAllAddress();

        $user = yii::$app->user->identity;
        $post = yii::$app->request->post();
        $secretKey = '6LdmC5MaAAAAAEeNRx_fEElI4jGxKuvfZYGHKjLF';
        $responseKey = $post['g-recaptcha-response'];
        $userIP = $_SERVER['REMOTE_ADDR'];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
        $response = file_get_contents($url);
        $response = json_decode($response);

        if ($post) {
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type: text/plain; charset=iso-8859-1\n";

            $text = '
            Name:' . $post['first_name'] . '
            Last name:' . $post['last_name'] . '
            Email:' . $post['email'] . '
            Phone:' . $post['tel_no'] . '
            Street :' . $post['street'] . '
            Zip code :' . $post['zip_code'] . '
            Message :' . $post['message'];


            $message = Yii::$app->mailer->compose()
                ->setTo(yii::$app->params['adminEmail'])
                ->setFrom(yii::$app->params['noReplyEmail'])
                ->setTextBody($text)
                ->setSubject('Schildr - Feedback');

            if ($response->success){
                if ($message->send()) {
                    return $this->redirect('success');
//                $model->save();
//                    yii::$app->session->setFlash('success', Html::encode(yii::t('db', 'Thanks for contacting us! We will be in touch with you shortly.')));
                }
            }
            else{
                yii::$app->session->setFlash('error', Html::encode(yii::t('db', 'ReCaptcha failed.')));
                return $this->redirect('contact');
            }


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