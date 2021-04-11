<?php

use yii\easyii\modules\productcategory\models\ProductCategory;
use yii\helpers\Url;
use app\models\Page;
use yii\widgets\Breadcrumbs;

$controller = yii::$app->controller->id;
$pageName = Page::getParentNav(yii::$app->request->get('page_slug'));
$site = yii::$app->request->getHostName();
$this->title = 'Products' . " » " . $site;

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
                           class="nav-list-parent">
                            PRODUCTS
                            <span class="<?= ($controller == 'product-category') ? 'hide_child' : 'show_sub_menu'; ?> "><i
                                        class="fas fa-chevron-right ml-18"></i></span>
                        </a>
                        <ul class="menu_child <?= ($controller == 'product-category') ? 'show' : ''; ?>">
                            <?php foreach ($productCategoriesForLink as $k => $v): ?>
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

        <div class="carousel_right_zone">
            <div class="carousel_right_zone_inner">
                <h2><?= yii::t('db', 'Products') ?></h2>
                <p><?= yii::t('db', 'All categories'); ?></p>
            </div>
            <div class="solid_item">
            </div>
            <div class="carousel_right_zone_inner">
                <ul>
                    <?php foreach ($productCategoriesForRightZone as $item): ?>
                        <li><?= $item ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <span class="open_right">
                <i class="fa fa-angle-right"></i>
            </span>
        </div>

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
                    <div class="slide-element"
                         style="background-image: url(<?= yii::getAlias('@web') . $val['file_name'] ?>)"></div>
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
    <div class="inner_main_center mt-0 pb-415-0">
        <!--page breadCrumb-->
        <div class="_bread_crumb_other_page">
            <?= Breadcrumbs::widget([
                'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
                'links' => [

                    'label' => 'Products',
                ],

            ]); ?>
        </div>

        <!--Page Title-->
        <div class="page_title">
            <div class="row">
                <div class="col-md-4 text-uppercase">
                    <h1 class="text-uppercase">PRODUCTS</h1>
                </div>
                <div class="col-lg-7 col-md-8">
                    <h4 class="text-uppercase"> <?= $pageName['title'] ?></h4>
                    <?= $pageName['text'] ?>
                </div>
            </div>
        </div>

        <!--Product-->
        <div class="project border_1">
            <div class="row product_item_closest">
                <?php foreach ($productCategories as $key => $val): ?>

                    <div class="col-md-6 project_item" data-id= <?= $val['order_num'] ?>>
                        <a href="<?= Url::to(['product-category/view', 'page_slug' => 'product', 'slug' => $val['slug'], 'id' => $val['id']]) ?>">
                            <img class="img-responsive" src="<?= yii::getAlias('@web') . $val['image'] ?>"
                                 alt="<?= $val['title'] ?>">
                        </a>
                        <h1 class="text-left bg-white mb-0">
                            <a href="<?= Url::to(['product-category/view', 'page_slug' => 'product', 'slug' => $val['slug'], 'id' => $val['id']]) ?>"><?= $val['title'] ?></a>
                        </h1>
                        <p><?= $val['subtitle'] ?></p>
                    </div>

                <?php endforeach; ?>
            </div>

            <?php
            $count = count(ProductCategory::getParentCategory());

            if ($count > ProductCategory::APPEND_CATEGORY_LIMIT): ?>
                <button class="load_more" id="load_more_pr">LOAD MORE</button>
            <?php endif; ?>
        </div>

        <!--#Page main content-->
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

<script async defer data-pin-hover="true" data-pin-tall="true" data-pin-square="true"
        src="//assets.pinterest.com/js/pinit.js"></script>
