<?php

use yii\helpers\Html;
use yii\helpers\Url;

//$this->title = Html::encode( yii::t('db', 'Page not found'));
//\yii\helpers\VarDumper::dump($carousel,10,1);die();

?>

<div class="container-fluid main_top">
    <!--Carousel-->
    <div class="carousel">

        <!--Main page left menu-->
        <div class="main_menu_left no-select">
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

        <div class="logo">
            <a href="<?= Url::to(['/']) ?>">
                <img src="<?= yii::getAlias('@web') . '/app/media/img/logo_footer.png' ?>" alt="">
            </a>
        </div>
    </div>
    <!-- /Carousel -->
</div>


<div class="container-fluid">
    <div class="error_page">
        <h1> 404 not found</h1>
    </div>
    <div class="back-main">
        <a href="<?= Url::to(['/']) ?>"> <?= Yii::t('db', 'Go to home page') ?> </a>
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

                                <?php for ($i = 0; $i <= $val['rating']; $i++) : ?>

                                    <?= "<i class='fa fa-star' aria-hidden='true'></i>" ?>

                                <?php endfor; ?>

                            </div>
                            <div class="col-xs-8 col-md-6 col-lg-8  ratings_item_content">
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