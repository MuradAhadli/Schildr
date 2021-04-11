<?php

use yii\easyii\modules\productcategory\models\ProductCategory;
use yii\helpers\Url;
use app\models\Page;
use yii\widgets\Breadcrumbs;

$controller = yii::$app->controller->id;
$pageName = Page::getParentNav(yii::$app->request->get('page_slug'));
$site = yii::$app->request->getHostName();
$this->title = 'Products - Schildr Outdoor Solutions, New Jersey ';

?>

<!--top-->

<div class="container-fluid main_top">
    <!--Carouse-->
    <div class="carousel">

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
        <!--                </ul>-->
        <!--            </div>-->
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

        <div class="carousel_right_zone">
            <div class="carousel_right_zone_inner">
                <h2><?= yii::t('db', 'Projects') ?></h2>
                <p><?= yii::t('db', 'All categories'); ?></p>
            </div>
            <div class="solid_item">
            </div>
            <div class="carousel_right_zone_inner">
                <ul>
                    <li><a href="<?= Url::to(['project/recidental']) ?>">RESIDENTIAL</a></li>
                    <li><a href="<?= Url::to(['project/commercial']) ?>">COMMERCIAL</a></li>
                </ul>
            </div>
            <span class="open_right">
                <i class="fa fa-angle-right"></i>
            </span>
        </div>

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

                    <div class="slide-element"
                         style="background-image: linear-gradient(to bottom, #000000 -24%, #ffffff00 35%), url(<?= yii::getAlias('@web') . $val['file_name'] ?>)">
                        <div class="bread-div"><div class="bread-bottom"><span disabled></span> <h1> Get ready for the ultimate outdoor solutions. </h1></div></div>

                    </div>
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

<div class="container-fluid main_center">
    <div class="inner_main_center">
        <!--page breadCrumb-->
        <div class="bread">
            <div class="_bread_crumb_other_page">
                <?= Breadcrumbs::widget([
                    'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
                    'links' => [

                        'label' => 'Projects',
                    ],

                ]); ?>
            </div>
        </div>
        <div class="main_center">
            <div class="col-md-4 text-uppercase" style="border-top: 1px solid #7396ae;  padding-left: 0;">
                <h1 class="text-uppercase" style="font-size: 45.7px; font-family: 'Barlow', sans-serif; font-weight: normal; color: #232323; margin-top: 30px;"><?= yii::t('db', 'PROJECTS') ?></h1>
            </div>
<!--            <div class="col-lg-7 col-md-8 recidental_text" style="padding-right: 0;">-->
<!--                <h4 class="text-uppercase">-->
<!--                    --><?//= $pageName['title'] ?>
<!--                </h4>-->
<!--                <p>-->
<!--                    --><?//= $pageName['text'] ?>
<!--                </p>-->
<!--            </div>-->
        </div>

        <!--Page Title-->
        <!--        <div class="page_title">-->
        <!--            <div class="row">-->
        <!--                <div class="col-md-4 text-uppercase">-->
        <!--                    <h1 class="text-uppercase">PRODUCTS</h1>-->
        <!--                </div>-->
        <!--                <div class="col-lg-7 col-md-8">-->
        <!--                    <h4 class="text-uppercase page_name"> --><?//= $pageName['title'] ?><!--</h4>-->
        <!--                    --><?//= $pageName['text'] ?>
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->

        <!--Product-->
        <!--        <div class="project border_1">-->
        <!--            <div class="row product_item_closest">-->
        <!--                --><?php //foreach ($productCategories as $key => $val): ?>
        <!--                    <div class="col-md-6 project_item" data-id= --><?//= $val['order_num'] ?><!--
                     <a style="margin-bottom: 30px" href="--><?//= Url::to(['product-category/view', 'page_slug' => 'product', 'slug' => $val['slug'], 'id' => $val['id']]) ?><!--">-->
        <!--                            <img class="img-responsive" src="--><?//= yii::getAlias('@web') . $val['image'] ?><!--"-->
        <!--                                 alt="--><?//= $val['title'] ?><!--">-->
        <!--                        </a>-->
        <!--                        <h1 class="text-left bg-white mb-0">-->
        <!--                            <a class="prj-text" href="--><?//= Url::to(['product-category/view', 'page_slug' => 'product', 'slug' => $val['slug'], 'id' => $val['id']]) ?><!--">--><?//= $val['title'] ?><!--</a>-->
        <!--                        </h1>-->
        <!--                        <p class="prj-title">--><?//= $val['subtitle'] ?><!--</p>-->
        <!--                    </div>-->
        <!---->
        <!--                --><?php //endforeach; ?>
        <!--            </div>-->
        <!---->
        <!--            --><?php
        //            $count = count(ProductCategory::getParentCategory());
        //
        //            if ($count > ProductCategory::APPEND_CATEGORY_LIMIT): ?>
        <!--                <button class="load_more" id="load_more_pr">LOAD MORE</button>-->
        <!--            --><?php //endif; ?>
        <!--        </div>-->

        <!--#Page main content-->
    </div>
    <div class="project" style="width: 100%">
        <div class="products">
            <div class="project-item projects-item" data-id= "<?= $residential['ordering'] ?>">
                <a href="<?= Url::to(['project/recidental']) ?>">
                    <div class="project-img projects-img">
                        <img src="<?= yii::getAlias('@web') . $residential['image'] ?>" alt="<?= $residential['title'] ?>">
                    </div>
                    <div class="prj-info">
                        <a class="prj-text" href="<?= Url::to(['project/recidental']) ?>"><?= $residential['title'] ?></a>
                        <p class="prj-title"><?= $residential['description'] ?></p>
                    </div>
                </a>
            </div>
            <div class="project-item projects-item" data-id= "<?= $commercial['ordering'] ?>">
                <a href="<?= Url::to(['project/commercial']) ?>">
                    <div class="project-img projects-img">
                        <img src="<?= yii::getAlias('@web') . $commercial['image'] ?>" alt="<?= $commercial['title'] ?>">
                    </div>
                    <div class="prj-info">
                        <a class="prj-text" href="<?= Url::to(['project/commercial']) ?>"><?= $commercial['title'] ?></a>
                        <p class="prj-title"><?= $commercial['description'] ?></p>
                    </div>
                </a>
            </div>
        </div>

    </div>
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

<script async defer data-pin-hover="true" data-pin-tall="true" data-pin-square="true"
        src="//assets.pinterest.com/js/pinit.js"></script>
