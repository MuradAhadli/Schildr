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
$site = yii::$app->request->getHostName();

$pageName = Page::getParentNav(yii::$app->request->get('page_slug'));

\app\assets\ContactAsset::register($this);


$attr = $model->attributeLabels();


$this->title =  $pageName['title']. " - Schildr Outdoor Solution, New Jersey  " ;

?>


<!--top-->
<link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<div class="container-fluid main_top">
    <!--Carouse-->

    <div class="carousel" style="height: 87.5vh;">

        <!--Main page left menu-->
<!--        <div class="main_menu_left">-->
<!--            <div class="menu-head">Menu</div>-->
<!--            <div class="menu_inner">-->
<!--                <ul>-->
<!--                    <li><a href="--><?//= Url::to(['site/about-us', 'page_slug' => 'about-us']) ?><!--">ABOUT US</a></li>-->
<!---->
<!--                    <li>-->
<!---->
<!--                        <span class="nav-list-parent no-select show_sub_menu">-->
<!--                            PROJECTS-->
<!--                            <span><i class="fas fa-chevron-right ml-18"></i></span>-->
<!--                        </span>-->
<!--                        <ul class="menu_child">-->
<!--                            <li><a href="--><?//= Url::to(['project/recidental']) ?><!--">residential</a></li>-->
<!--                            <li><a href="--><?//= Url::to(['project/commercial']) ?><!--">commercial</a></li>-->
<!--                        </ul>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="--><?//= Url::to(['product-category/index', 'page_slug' => 'product']) ?><!--"-->
<!--                           class="nav-list-parent no-select ">-->
<!--                            PRODUCTS-->
<!--                            <span class="show_sub_menu"><i class="fas fa-chevron-right ml-18"></i></span>-->
<!--                        </a>-->
<!--                        <ul class="menu_child">-->
<!--                            --><?php //foreach ($productCategories as $k => $v): ?>
<!--                                <li>-->
<!--                                    <a href="--><?//= Url::to(['product-category/view', 'page_slug' => 'product', 'slug' => $v['slug'], 'id' => $v['id']]) ?><!--">--><?//= $v['title'] ?><!--</a>-->
<!--                                </li>-->
<!--                            --><?php //endforeach; ?>
<!--                        </ul>-->
<!--                    </li>-->
<!--                    <li><a href="--><?//= Url::to(['site/contact', 'page_slug' => 'contact']) ?><!--">CONTACTS</a></li>-->
<!---->
<!--                </ul>-->
<!--            </div>-->
<!---->
<!--        </div>-->
        <!--        <div class="contact-x">-->
        <!--            <div class="contact-parts">-->
        <!--                <div class="contact-part">-->
        <!--                    <a href="--><?//= Url::to(['site/about-us', 'page_slug' => 'about-us']) ?><!--">About Us</a>-->
        <!--                </div>-->
        <!--                <div class="contact-part" id="project-menu">-->
        <!--                    <span>Projects</span>-->
        <!--                </div>-->
        <!--                <div class="sub-prj">-->
        <!--                    <a href="--><?//= Url::to(['project/recidental']) ?><!--">Residential</a>-->
        <!--                </div>-->
        <!--                <div class="sub-prj">-->
        <!--                    <a href="--><?//= Url::to(['project/commercial']) ?><!--">Commercial</a>-->
        <!--                </div>-->
        <!--                <div class="contact-part" id="product-menu">-->
        <!--                    <span>Products</span>-->
        <!--                </div>-->
        <!--                --><?php //foreach ($productCategories as $k => $v): ?>
        <!--                    <div class="sub-prd">-->
        <!--                        <a href="--><?//= Url::to(['product-category/view', 'page_slug' => 'product', 'slug' => $v['slug'], 'id' => $v['id']]) ?><!--">--><?//= $v['title'] ?><!--</a>-->
        <!--                    </div>-->
        <!--                --><?php //endforeach; ?>
        <!--                <div class="contact-part">-->
        <!--                    <a href="--><?//= Url::to(['site/contact', 'page_slug' => 'contact']) ?><!--">Contact</a>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <div class="contact-menu">-->
        <!--                <p class="menu-text">Menu</p>-->
        <!--            </div>-->
        <!--        </div>-->
        <!-- / Main page left menu-->

        <div class="logo">
            <a href="<?= Url::to(['/']) ?>">
                <img src="<?= yii::getAlias('@web') . '/app/media/img/logo_footer.png' ?>" alt="Schildr - Logo">
            </a>
        </div>

        <?php if (count($carousel) > 1): ?>
            <div class="slick-arrows-helper">
                <button id="prev"></button>
                <button id="next"></button>
            </div>
            <div class="slide">
                <?php foreach ($carousel as $key => $val): ?>
                    <div class="slide-element" style=" background-image: linear-gradient(to bottom, #000000 -24%, #ffffff00 35%),url(<?= yii::getAlias('@web') . $val['file_name'] ?>)"></div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg_top"
                 style="background-image:  linear-gradient(to bottom, #000000 -24%, #ffffff00 35%), url(<?= yii::getAlias('@web') . $carousel[0]['file_name'] ?>)">
                <div class="bg_layer"></div>
            </div>
        <?php endif; ?>

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
                <div class="col-md-8" style="border-top: 1px solid #7396ae;  padding-left: 0;">
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
    <div class="inner_main_center for_about border_1">
        <?php

        ActiveForm::begin([
            'method' => 'POST',
            'id' => 'became-dealer',
            'fieldConfig' => [
                'errorOptions' => [
                    'class' => 'invalid-feedback'
                ],
                'enableLabel' => false
            ]
        ])

        ?>
        <div class="row contact_form">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" name="first_name" required placeholder="First name">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="last_name" required placeholder="Last name">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="company_name" required placeholder="Company name">
                </div>
                <div class="form-group">
                    <input type="email" required class="form-control" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="tel_no" required placeholder="Phone">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <select class="form-control" name="question-1" required >
                        <option selected  disabled value="">Do you currently resell and/or install awning products</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" name="question-2" required >
                        <option selected  disabled value="">Do you own and operate a shop or showroom ? </option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="areas" required placeholder="What areas do you serve? *">
                </div>
                <div class="form-group">
                        <textarea style="height: 106px;" class="form-control" name="message" required id="" cols="30" rows="7" placeholder="Additional Comments"></textarea>
                </div>
            </div>
            <div class="container-fluid row" style=" margin-top: 20px">
                <div class="col-md-12" style="margin-bottom: 30px">
                    <div class="g-recaptcha" data-sitekey="6LdmC5MaAAAAALHcRZP0RAt_PfgehM3exYijypp7"></div>
                </div>
                <div class="col-md-12 d-flex align-items-center">
                    <div class="form-group button_group">
                        <button  class="contener btn_more" type="submit" style="margin: 0; border: none;">
                            <div  class="txt_button">SEND FORM</div>
                            <div class="circle">&nbsp;</div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end();?>
    </div>
</div>


<!--bottom-->
<div class="container-fluid main_bottom">
    <div class="main_bottom_inner">
        <div class="row bottom_inner__flex">
            <div class="col-lg-6 col-xs-6 clients">
                <h3>Happy clients</h3>
                <div class="clients_left"><img src="<?= yii::getAlias('@web') . '/app/media/img/arrow-black-left-svg.svg' ?>" alt="Arrow Left"></div>
                <div class="clients_right"><img src="<?= yii::getAlias('@web') . '/app/media/img/arrow-black-right-svg.svg' ?>" alt="Arrow Right"></div>
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
                <span class="ratings_left"><img src="<?= yii::getAlias('@web') . '/app/media/img/arrow-black-left-svg.svg' ?>" alt="Arrow Left"></span>
                <span class="ratings_right"><img src="<?= yii::getAlias('@web') . '/app/media/img/arrow-black-right-svg.svg' ?>" alt="Arrow Right"></span>
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

<!--    'headerEmail' => 'schildr.marketing@gmail.com',-->
<!--    'adminEmail' => 'abes2go@gmail.com',-->
<!--    'noReplyEmail' => 'schildr.marketing@gmail.com',-->
<!--    'sitePhone' => '833 724 4533',-->
<!--    'senderName' => 'Schildr',-->
<!--    'user.passwordResetTokenExpire' => 3600,-->
<!--    'supportEmail' => 'schildr.marketing@gmail.com',-->
<!--    'defaultLanguage' => 'en',-->
</div>