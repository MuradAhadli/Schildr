<?php
/**
 * Created by PhpStorm.
 * User: Qulam Alisoy
 * Date: 3/24/2018
 * Time: 10:54 AM
 */


use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\models\Contacts;
use app\models\Page;
use yii\widgets\Breadcrumbs;
use yii\easyii\modules\productmodels\api\Productmodels;
$site = yii::$app->request->getHostName();

$pageName = Page::getParentNav(yii::$app->request->get('page_slug'));

\app\assets\ContactAsset::register($this);


//$attr = $model->attributeLabels();


$this->title =  $pageName['title']. " - Schildr Outdoor Solution, New Jersey ";


?>


<!--top-->
<link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<div class="container-fluid main_top">
    <!--Carouse-->

    <div class="carousel" style="height: 47.5vh;">
        <div class="logo">
            <a href="<?= Url::to(['/']) ?>">
                <img src="<?= yii::getAlias('@web') . '/app/media/img/logo_footer.png' ?>" alt="Schildr - Logo">
            </a>
        </div>

        <div class="bg_top"
            <?php
            $files = array_values($product['files']);
            $realImage = '';
            foreach ($product['files'] as $file) {
                if ($file['is_base'] == 1) {
                    $realImage = $file['file'];
                }
            }
            if ($realImage == '') {
                if (isset($files[0]) && !empty($files[0])) {
                    $realImage = $files[0]['file'];
                };
            }
            ?>
             style="background-image:  linear-gradient(to bottom, #000000 -24%, #ffffff00 35%), url(<?php if(isset($product)):?> <?= $realImage ?> <?php else: ?><?= yii::getAlias('@web') . $carousel[0]['file_name'] ?><?php endif?>)">
            <div class="bg_layer">

            </div>
        </div>

    </div>
    <!-- /Carousel -->
    <div class="contact_main">
        <div class="contact-menu">
            <p class="menu-text">MENU</p>
        </div>
        <div class="contact-x">
            <div class="contact-parts">
                <div class="contact-part">
                    <a href="<?= Url::to(['site/about-us', 'page_slug' => 'about-us']) ?>">ABOUT US</a>
                </div>
                <div class="contact-part" >
                    <a href="<?= Url::to(['project/index', 'page_slug' => 'projects']) ?>" >
                        PROJECTS
                        <span class="show_sub_menu arr" id="project-menu" style="padding-right: 15px;padding-left: 15px"><i class="fas fa-chevron-right "></i></span>
                    </a>
                </div>
                <div class="sub-prj">
                    <a href="<?= Url::to(['project/recidental']) ?>">RESIDENTIAL</a>
                </div>
                <div class="sub-prj">
                    <a href="<?= Url::to(['project/commercial']) ?>">COMMERCIAL</a>
                </div>
                <div class="contact-part">
                    <a href="<?= Url::to(['product-category/index', 'page_slug' => 'product']) ?>" class="span">
                        PRODUCTS
                        <span class="show_sub_menu arr" id="product-menu" style="padding-left: 15px;padding-right: 15px;"><i class="fas fa-chevron-right"></i></span>
                    </a>
                </div>
                <?php foreach ($productCategories as $k => $v): ?>
                    <div class="sub-prd">
                        <a href="<?= Url::to(['product-category/view', 'page_slug' => 'product', 'slug' => $v['slug'], 'id' => $v['id']]) ?>"><?= $v['title'] ?></a>
                    </div>
                <?php endforeach; ?>
                <div class="contact-part">
                    <a href="<?= Url::to(['site/contact', 'page_slug' => 'contact']) ?>">CONTACTS</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid main_center" style="padding-top: 100px;">
    <div class="bread">
        <div class="bread_crumb">
            <?= Breadcrumbs::widget([
                'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
                'links' => [

                    $pageName['title']
                ],

            ]); ?>
        </div>

    </div>
    <div class="inner_main_center for_about">

        <!--Page Title-->
        <div class="page_title pb-0 pl_992_0" style="padding: 0;">
            <div class="main-center">
                <div class="col-md-12" style="border-top: 1px solid #7396ae;  padding-left: 0;">
                    <h1 class="text-uppercase" style="font-size: 45.7px; font-family: 'Barlow', sans-serif; font-weight: normal; color: #232323; margin-top: 30px;"><?= $pageName['title'] ?></h1
                    <h4>
                        <?= $pageName['short'] ?>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Page main content-->

<!--Contact Form-->
<div class="container-fluid main_center">

        <div class="project" style="width: 100%">
            <div class="products">
                <?php foreach ($blogs as $key => $val): ?>
                    <div class="project-item" style="max-height: 809px;overflow: hidden">
                        <a href="<?= Url::to(['/static/'.$val['id']]) ?>">
                            <div class="project-img">
                                <img src="<?= yii::getAlias('@web') . $val['image'] ?>" alt="<?= $val['title'] ?>">
                            </div>
                            <div class="prj-info blog-title" style="flex-wrap: nowrap">
                                <a class="prj-text" href="<?= Url::to(['/static/'.$val['id']]) ?>"><?= $val['title'] ?></a>
                                <p class="prj-title "><?= $val['text'] ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

</div>


<!--bottom-->
<div class="container-fluid main_bottom">
    <div class="main_bottom_inner">
        <div class="row bottom_inner__flex">
            <div class="col-lg-6 col-xs-6 clients">
                <h3>Happy clients</h3>
                <div class="clients_left"><img src="<?= yii::getAlias('@web') . '/app/media/img/arrow-black-left-svg.svg' ?>" alt="Left Arrow"></div>
                <div class="clients_right"><img src="<?= yii::getAlias('@web') . '/app/media/img/arrow-black-right-svg.svg' ?>" alt="Right Arrow"></div>
                <div class="clients_inner">
                    <?php foreach ($clients as $client): ?>
                        <div class="item-helper-small">
                            <div class="col-xs-2 clients_item">
                                <a href="javascript:void(0)">
                                    <img src="<?= yii::getAlias('@web') . $client['image'] ?>" alt="Clients">
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
            <div class="col-lg-6 col-xs-6 ratings">
                <h3>Reviews and ratings</h3>
                <span class="ratings_left"><img src="<?= yii::getAlias('@web') . '/app/media/img/arrow-black-left-svg.svg' ?>" alt="Left Arrow"></span>
                <span class="ratings_right"><img src="<?= yii::getAlias('@web') . '/app/media/img/arrow-black-right-svg.svg' ?>" alt="Right Arrow"></span>
                <div class="ratings_item">
                    <?php foreach ($partners as $key => $val) : ?>
                        <div class="row">
                            <div class="col-xs-4 col-md-3 col-lg-2 col-lg-offset-1 ratings_item_head">
                                <img class="img-responsive" src="<?= yii::getAlias('@web') . $val['image'] ?>" alt="<?= $val['full_name'] ?>">
                                <?php for ($i = 0; $i < $val['rating']; $i++) : ?>
                                    <?= "<i class='fa fa-star' aria-hidden='true'></i>" ?>
                                <?php endfor; ?>
                            </div>
                            <div class="col-xs-8 col-md-6 col-lg-8 ratings_item_content">
                                <h5><?= $val['full_name'] ?></h5>
                                <p><?= $val['position'] ?></p>
                                <p><?= $val['review'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>