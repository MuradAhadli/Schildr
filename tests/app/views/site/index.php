<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use yii\widgets\Breadcrumbs;
use app\models\Page;

//\app\assets\HomeAsset::register($this);
$pageName = Page::getParentNav(yii::$app->request->get('page_slug'));

//\yii\helpers\VarDumper::dump($pagesystems,10,1);

$e = 0;
?>

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

<!--center-->
<div class="container-fluid main_center">
    <div class="inner_main_center mt-0 pb-415-0">
        <div class="_bread_crumb">

             <a><?= Yii::t('db', 'Home') ?></a>

<!--            --><?//=  Breadcrumbs::widget([
//                'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
//
//
//            ]); ?>
        </div>

        <?php foreach ($pagesystems as $key => $val) : ?>
            <?php if ($key % 2 == 0) : ?>

                <div class="row odd_item">

                    <div class="col-lg-6 col-md-12 col-sm-12 main_center_content">

                        <h2><?= $val['title'] ?></h2>

                        <p><?= $val['text'] ?></p>


                        <a href="<?= Url::to('about-us')?>" class="btn_more">MORE</a>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 main_center_video">

                        <?php if (isset($val['youtube_embed']) && !empty($val['youtube_embed'])): ?>

                            <iframe width="100%" height="600px"
                                    src="https://www.youtube.com/embed/<?= $val['youtube_embed'] .'?rel=0' ?>"
                                    frameborder="0"></iframe>

                        <?php else: ?>
                            <span class="play_btn">
                                <i class="far fa-play-circle"></i>
                            </span>
                            <span class="pause_btn">
                                <i class="far fa-pause-circle"></i>
                            </span>
                            <video class="home_page_video">
                                <source src="<?= $val['file'] ?>"
                                        type="video/mp4">
                                <source src="<?= $val['file'] ?>"
                                        type="video/ogg">
                            </video>
                        <?php endif; ?>

                    </div>
                </div>
            <?php else: ?>

                <div class="row even_item">

                    <div class="col-lg-6 col-md-12 col-sm-12 main_center_video">
                        <?php if (isset($val['youtube_embed']) && !empty($val['youtube_embed'])): ?>

                            <iframe width="100%" height="600px"
                                    src="https://www.youtube.com/embed/<?= $val['youtube_embed'] . '?rel=0' ?>"
                                    frameborder="0"></iframe>

                        <?php else: ?>
                            <span class="play_btn">
                                <i class="far fa-play-circle"></i>
                            </span>
                            <span class="pause_btn">
                                <i class="far fa-pause-circle"></i>
                            </span>
                            <video class="home_page_video">
                                <source src="<?= $val['file'] ?>"
                                        type="video/mp4">
                                <source src="<?= $val['file'] ?>"
                                        type="video/ogg">
                            </video>
                        <?php endif; ?>
                    </div>

                    <div class="col-lg-6 col-md-12 col-sm-12 main_center_content">

                        <h2><?= $val['title'] ?></h2>

                        <p><?= $val['text'] ?></p>

                        <a href="<?= Url::to('about-us')?>" class="btn_more">MORE</a>
                    </div>

                </div>
            <?php endif; ?>
        <?php endforeach; ?>
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
                            <div class="col-xs-4 col-lg-2 col-lg-offset-1  col-md-3 ratings_item_head">

                                <img class="img-responsive" src="<?= yii::getAlias('@web') . $val['image'] ?>" alt="">

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