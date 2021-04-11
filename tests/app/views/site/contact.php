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


$this->title =  $pageName['title']. " » " .$site;

?>


<!--top-->
<div class="container-fluid main_top">
    <!--Carouse-->
    <div class="carousel">

        <!--Main page left menu-->
        <div class="main_menu_left">
            <div class="menu_inner">
                <ul>
                    <li><a href="<?= Url::to(['site/about-us', 'page_slug' => 'about-us']) ?>">ABOUT US</a></li>

                    <li>
                        <span class="nav-list-parent no-select show_sub_menu">
                            PROJECTS
                            <span><i class="fas fa-chevron-right ml-18"></i></span>
                        </span>
                        <ul class="menu_child">
                            <li><a href="<?= Url::to(['project/recidental']) ?>">residential</a></li>
                            <li><a href="<?= Url::to(['project/commercial']) ?>">commercial</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?= Url::to(['product-category/index', 'page_slug' => 'product']) ?>"
                           class="nav-list-parent no-select">
                            PRODUCTS
                            <span class="show_sub_menu"><i class="fas fa-chevron-right ml-18"></i></span>
                        </a>
                        <ul class="menu_child">
                            <?php foreach ($productCategories as $k => $v): ?>
                                <li>
                                    <a href="<?= Url::to(['product-category/view', 'page_slug' => 'product', 'slug' => $v['slug'], 'id' => $v['id']]) ?>"><?= $v['title'] ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li><a href="<?= Url::to(['site/contact', 'page_slug' => 'contact']) ?>">CONTACTS</a></li>

                </ul>
            </div>
        </div>
        <!-- / Main page left menu-->

        <div class="logo">
            <a href="<?= Url::to(['/']) ?>">
                <img src="<?= yii::getAlias('@web') . '/app/media/img/logo_footer.png' ?>" alt="">
            </a>
        </div>

        <?php if (count($carousel) > 1): ?>
            <div class="slick-arrows-helper">
                <button id="prev"></button>
                <button id="next"></button>
            </div>
            <div class="slide">
                <?php foreach ($carousel as $key => $val): ?>
                    <div class="slide-element" style="background-image: url(<?= yii::getAlias('@web') . $val['file_name'] ?>)"></div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg_top"
                 style="background-image: url(<?= yii::getAlias('@web') . $carousel[0]['file_name'] ?>)">
                <div class="bg_layer"></div>
            </div>
        <?php endif; ?>

    </div>
    <!-- /Carousel -->
</div>

<div class="container-fluid main_center">
    <div class="inner_main_center for_about">
        <!--page breadCrumb-->
        <div class="_bread_crumb_other_page">
            <?= Breadcrumbs::widget([
                'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
                'links' => [

                    $pageName['title']
                ],

            ]); ?>
        </div>

        <!--Page Title-->
        <div class="page_title pb-0">
            <div class="row">
                <div class="col-md-4 text-uppercase">
                    <h1 class="text-uppercase">CONTACT US</h1>
                </div>
                <div class="col-lg-8 col-md-8">
                    <h4 class="text-uppercase">
                        <?= $pageName['short'] ?>
                    </h4>
                    <p>
                        <?= $pageName['text'] ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Page main content-->

<!--Contact Form-->
<div class="container-fluid main_center">
    <div class="inner_main_center for_about border_1">
        <h1 class="section_title text-uppercase mt-0">CONTACT FORM</h1>
        <?php

        ActiveForm::begin([
            'method' => 'POST',
            'id' => 'contact-us',
            'fieldConfig' => [
                'errorOptions' => [
                    'class' => 'invalid-feedback'
                ],
                'enableLabel' => false
            ]
        ])

        ?>
        <div class="row contact_form">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" class="form-control" name="firs_name" required placeholder="First name">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="last_name" required placeholder="Last name">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="street" required placeholder="Street / house no name">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="zip_code" required placeholder="Zip or postal code">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="city" required placeholder="City">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" class="form-control" name="tel_no" required placeholder="Tel no">
                </div>
                <div class="form-group">
                    <input type="email" required class="form-control" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                        <textarea class="form-control" name="message" required id="" cols="30" rows="8"
                                  placeholder="Your message"></textarea>
                </div>
            </div>
            <div class="col-md-4">
                <label for="">Can we call you back? (mo-fr)</label>
                <div class="form-group checkbox_item">
                    <input type="checkbox" name="morning" id="morning" value="morning">
                    <label for="morning" class="label_span no-select"><?=Yii::t('db', 'Morning: 08:00 am - 12:00 am')?></label><br>
                    <input type="checkbox" name="afternoon" id="afternoon" value="afternoon">
                    <label for="afternoon" class="label_span no-select"><?=Yii::t('db', 'Afternoon: 02.00 pm - 05:00 pm')?></label>
                </div>
                <label for="">Subscribe to newsletters</label>
                <div class="form-group checkbox_item">
                    <input type="checkbox" id="subscripe" name="subscripe">
                    <label for="subscripe" class="label_span d-block no-select">
                        Yes, I would like to receive further information by e-mail in the future
                    </label>
                </div>
                <div class="form-group button_group">
                    <button type="submit" class="btn_more">SEND FORM</button>
                    <button type="button" id="form_reset" class="btn_more bg_gray">RESET FROM</button>
                </div>
            </div>
        </div>
        <?php ActiveForm::end();?>
        <h4 id="map-block" class="contact_foot_title">Address</h4>
        <div class="row contacts_helper">
            <?php foreach ($address as $key => $val) : ?>
                <!--First item-->
                <div class="col-md-6 col-lg-3 contacts_item" id="contact-<?=$val['id']?>">
                    <div class="contacts_item__header">
                        <div class="item__header___flag">
                            <div class="left">
                            <span>  
                                <img class="img-responsive"
                                     src="<?= yii::getAlias('@web') . $val['image'] ?>" alt="">
                            </span>
                                <span><?= $val['title'] ?></span>
                            </div>
                            <div class="right">
                            <span>
                                <img src="<?= yii::getAlias('@web') . '/app/media/img/contacts/location.svg' ?>" alt="">
                            </span>
                                <span data-id="branches_map" onclick="goMap(<?=$val['id']?>, <?=$val['coor_x']?>, <?=$val['coor_y']?>);">show in map</span>
                            </div>
                        </div>
                        <div class="contacts_item__body">
                            <p><?= $val['general_address'] ?></p>
                            <p>T.: <?= $val['phone'] ?></p>
                            <p>email: <a href=""><?= $val['email'] ?> </a></p>
                            <p>web: <a href=""><?= $val['web'] ?> </a></p>
                        </div>
                    </div>
                </div>
                <!-- /First item-->

            <?php endforeach; ?>

        </div>
    </div>
    <!--#Contact Form-->

    <!--Google map For Contact Form-->
    <div class="main_center">
        <div id="branches_map" class="inner_main_center for_about border_1 pb-620-0">
            <h1 class="text-uppercase section_title mt-0 mb-0">OUR SHOWROOMS</h1>

            <div id="map" style="height: 400px"></div>

        </div>
    </div>
    <!--#Google map For Contact Form-->
</div>

<!--Our partners-->
<!--<div class="container-fluid main_center">-->
<!--    <div class="inner_main_center">-->
<!--        <h1 class="section_title mt-30 for_partners">Our Partners</h1>-->
<!--        <div class="partners_inner">-->
<!--            <div class="item-helper-small">-->
<!--                <div class="col-xs-2 partners_item">-->
<!--                    <a href="javascript:void(0)">-->
<!--                        <img src="--><?//= yii::getAlias('@web') . '/app/media/img/partners/aluminuimm.jpg' ?><!--">-->
<!--                    </a>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="item-helper-small">-->
<!--                <div class="col-xs-2 partners_item">-->
<!--                    <a href="javascript:void(0)">-->
<!--                        <img src="--><?//= yii::getAlias('@web') . '/app/media/img/partners/dormaa.jpg' ?><!--">-->
<!--                    </a>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="item-helper-small">-->
<!--                <div class="col-xs-2 partners_item">-->
<!--                    <a href="javascript:void(0)">-->
<!--                        <img src="--><?//= yii::getAlias('@web') . '/app/media/img/partners/C9E7E15A-120A-44C4-BA19-B53239D5E016.png' ?><!--">-->
<!--                    </a>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="item-helper-small">-->
<!--                <div class="col-xs-2 partners_item">-->
<!--                    <a href="javascript:void(0)">-->
<!--                        <img src="--><?//= yii::getAlias('@web') . '/app/media/img/partners/Gezee.jpg' ?><!--">-->
<!--                    </a>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="item-helper-small">-->
<!--                <div class="col-xs-2 partners_item">-->
<!--                    <a href="javascript:void(0)">-->
<!--                        <img src="--><?//= yii::getAlias('@web') . '/app/media/img/partners/guardiann.jpg' ?><!--">-->
<!--                    </a>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="item-helper-small">-->
<!--                <div class="col-xs-2 partners_item">-->
<!--                    <a href="javascript:void(0)">-->
<!--                        <img src="--><?//= yii::getAlias('@web') . '/app/media/img/partners/pbb.jpg' ?><!--">-->
<!--                    </a>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="item-helper-small">-->
<!--                <div class="col-xs-2 partners_item">-->
<!--                    <a href="javascript:void(0)">-->
<!--                        <img src="--><?//= yii::getAlias('@web') . '/app/media/img/partners/schuco.png' ?><!--">-->
<!--                    </a>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="item-helper-small">-->
<!--                <div class="col-xs-2 partners_item">-->
<!--                    <a href="javascript:void(0)">-->
<!--                        <img src="--><?//= yii::getAlias('@web') . '/app/media/img/partners/starwoodd.png' ?><!--">-->
<!--                    </a>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!--bottom-->
<div class="container-fluid main_bottom">
    <div class="main_bottom_inner">
        <div class="row bottom_inner__flex">
            <div class="col-lg-6 col-xs-12 clients">
                <h3>Happy clients</h3>
                <div class="clients_inner">
                    <?php foreach ($clients as $client): ?>
                        <div class="item-helper-small">
                            <div class="col-xs-2 clients_item">
                                <a href="javascript:void(0)">
                                    <img src="<?= yii::getAlias('@web') . $client['image'] ?>">
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-lg-6 col-xs-12 ratings">
                <h3>Reviews and ratings</h3>
                <span class="ratings_left"><img
                            src="<?= yii::getAlias('@web') . '/app/media/img/arrow-black-left-svg.svg' ?>"
                            alt=""></span>
                <span class="ratings_right"><img
                            src="<?= yii::getAlias('@web') . '/app/media/img/arrow-black-right-svg.svg' ?>"
                            alt=""></span>
                <div class="ratings_item">
                    <?php foreach ($partners as $key => $val) : ?>
                        <div class="row">
                            <div class="col-xs-4 col-lg-2 col-lg-offset-1 col-md-3 ratings_item_head">
                                <img class="img-responsive" src="<?= $val['image'] ?>" alt="">

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