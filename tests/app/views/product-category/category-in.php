<?php

use yii\easyii\modules\product\models\ProductFiles;
use yii\easyii\modules\productcategory\models\ProductCategory;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\widgets\Breadcrumbs;
use app\models\Page;

$page = yii::$app->controller->id;
$pageName = (explode('-', $page));
$pageNames = $pageName[0];
$productName = ProductCategory::getProductCategory(null, yii::$app->request->get('id'), yii::$app->request->get('slug'));
$id = $productName[0]['parent_id'];

$site = yii::$app->request->getHostName();
$this->title = $productName[0]['title'] . " » " . $productCat[0]['title'] . " » " . 'Products' . " » " . $site;

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
                        <span class="nav-list-parent show_sub_menu">
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


        <div class="carousel_right_zone">
            <div class="carousel_right_zone_inner">
                <h2><?= $productCat[0]['title'] ?></h2>
                <p><?= $productName[0]['title'] ?></p>
            </div>
            <div class="solid_item">
            </div>
            <div class="carousel_right_zone_inner">
                <ul>

                    <?php foreach ($products as $key => $val): ?>
                        <li><a href="#item-<?= $key ?>" class="scrollLink"><?= $val['title']; ?></a></li>
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

        <div class=" _bread_crumb_other_page">
            <?= Breadcrumbs::widget([
                'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
                'links' => [
                    [
                        'label' => 'Products',
                        'url' => ['product-category/index', 'page_slug' => 'product'],
                    ],
//                    [
//                        'label' => $productCat[0]['title'],
//                        'url' => ['product-category/view', 'page_slug' => 'product-category', 'slug' => $productCat[0]['slug'], 'id' => $id],
//                    ],
                    [
                        'label' => $productName[0]['title'],
                    ]

                ],
            ]); ?>
        </div>
    </div>


    <!--Page Title-->
    <div class="page_title">
        <div class="row">
            <div class="col-md-4 text-uppercase">
                <h1><?= $productName[0]['title'] ?></h1>
            </div>
            <div class="col-lg-7 col-md-8">
                <h4 class="text-uppercase"><?= $productName[0]['title'] ?></h4>
                <p>
                    <?= $productName[0]['short'] ?>
                    <!--                    Winter Gardens are the systems, covered with glasses at your gardens,-->
                    <!--                    cafees and restaurants. The main advantage of the winter gardens, is to-->
                    <!--                    feel all seasons from at your places. You can open windows and sit in the-->
                    <!--                    open air in any time you want. We can cover the roofs of winter gardens with-->
                    <!--                    rolling and glass roofs also. And the side points can be covered with fully-->
                    <!--                    deployable glass systems. (Glass balconies, Folding doors, sliding systems)-->
                </p>
            </div>
        </div>
    </div>

    <!--Complex Page Systems-->
    <div class="container-fluid main_bottom pb-620-0 pl-620-0 pr-620-0 pb_992_0 bg-white">
        <div class="main_bottom_inner width-100">

            <!--First item-->
            <?php $index = 0;
            foreach ($products as $key => $val): ?>

                <div class="page_complex_system" id="item-<?= $index ?>">
                    <h3 class="text-center" id="<?= $val['slug'] ?>"><?= $val['title'] ?></h3>
                    <div class="complex_system_carousel" style="position:relative;">
                        <div class="rect-helper"></div>
                        <div class="row complex_system_carousel_inner">
                            <!--/Thumb Slider-->

                            <div class="complex_carousel_helper">
                                <div class="slick_arrow">
                                    <span id="slick-left-<?= $key ?>" class="slick_left">
                                        <img src="<?= yii::getAlias('@web') . '/app/media/img/arrow-black-left-svg.svg' ?>"
                                             alt="">
                                    </span>
                                    <span id="slick-right-<?= $key ?>" class="slick_right">
                                        <img src="<?= yii::getAlias('@web') . '/app/media/img/arrow-black-right-svg.svg' ?>"
                                             alt="">
                                    </span>
                                </div>
                                <div id="SlickNav-<?= $key ?>"
                                     class="complex_carousel_nav col-xs-12 col-sm-12 col-md-8">

                                    <?php foreach ($val['files'] as $k => $v): ?>

                                        <?php if ($v['type'] == ProductFiles::IMAGE_TYPE): ?>
                                            <div>
                                                <img class="img-responsive"
                                                     src="<?= yii::getAlias('@web') . $v['file'] ?>"
                                                     alt="<?= $val['title'] ?>">
                                            </div>
                                        <?php else: ?>

                                            <div class="col-lg-6 col-md-12 col-sm-12 main_center_video">
                                                <video class="home_page_video">
                                                    <source src="<?= yii::getAlias('@web') . $v['file'] ?>"
                                                            type="video/mp4">
                                                    <source src="<?= yii::getAlias('@web') . $v['file'] ?>"
                                                            type="video/ogg">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>

                                        <?php endif; ?>

                                    <?php endforeach; ?>

                                </div>
                                <div class="content_helper">
                                    <div class="absolute__content">
                                        <h1 class="text-uppercase"><?= yii::t('db', 'Design features'); ?></h1>
                                        <?= $val['customization'] ?>
                                    </div>
                                    <div class="absolute__file">

                                        <?php foreach (unserialize($val['downloads']) as $k => $v): ?>

                                            <div class="item">
                                                <div class="file_img">
                                                    <img src="<?= yii::getAlias('@web') . '/app/media/img/pdf.svg' ?>"
                                                         alt="">
                                                </div>
                                                <div class="link">
                                                    <a target="_blank"
                                                       href="<?= yii::getAlias('@web') . '/' . $v['pdf'] ?>">
                                                        <?= $v['title'] ?>
                                                    </a>
                                                </div>
                                            </div>

                                        <?php endforeach; ?>

                                    </div>
                                </div>
                            </div>
                            <!--/Thumb Slider-->

                            <!--Big Slider-->

                            <div id="SlickFor-<?= $key ?>"
                                 class="complex_carousel_for col-xs-12 col-sm-12 col-md-8">
                                <?php foreach ($val['files'] as $k => $v): ?>

                                    <?php if ($v['type'] == ProductFiles::IMAGE_TYPE): ?>
                                        <div>
                                            <img class="img-responsive"
                                                 src="<?= yii::getAlias('@web') . $v['file'] ?>"
                                                 alt="<?= $val['title'] ?>">
                                        </div>
                                    <?php else: ?>

                                        <div class="col-lg-6 col-md-12 col-sm-12 main_center_video">
                                            <span class="play_btn">
                                                <i class="far fa-play-circle"></i>
                                            </span>
                                            <span class="pause_btn">
                                                <i class="far fa-pause-circle"></i>
                                            </span>
                                            <video class="home_page_video">
                                                <source src="<?= yii::getAlias('@web') . $v['file'] ?>"
                                                        type="video/mp4">
                                                <source src="<?= yii::getAlias('@web') . $v['file'] ?>"
                                                        type="video/ogg">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>

                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </div>
                            <!-- /Big Slider-->

                        </div>


                    </div>
                </div>
                <?php $index++; endforeach ?>

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
<div class="container-fluid main_bottom" id="a">
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