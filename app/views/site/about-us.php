<?php

use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\models\Page;

$pageName = Page::getParentNav(yii::$app->request->get('page_slug'));
$site = yii::$app->request->getHostName();
$this->title = $pageName['title'] . " - Schildr Outdoor Solution, New Jersey ";

$slug = yii::$app->request->get('page_slug');

?>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<!--top-->
<style>
    .about_text h4{
        font-family: 'Barlow', sans-serif;
        font-size: 30px;
        padding-bottom: 30px;
        font-style: normal;
        font-stretch: condensed;
        font-weight: normal;
        color: #232323;
    }

    .about_text p{
        font-family: 'Barlow', sans-serif !important;
        font-size: 17px !important;
        font-weight: 300 !important;
        color: #7d7d7d !important;
    }
</style>
<div class="main_top">
    <!--Carousel-->
    <div class="carousel" style="height: 87.5vh">
        <!--Main page left menu-->
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

        <?php if (count($carousel) > 1): ?>
            <div class="slick-arrows-helper">
                <button id="prev"></button>
                <button id="next"></button>
            </div>
            <div class="slide">
                <?php foreach ($carousel as $key => $val): ?>
                    <div class="slide-element"
                         style="background-image: background-image: linear-gradient(to bottom, #000000 -24%, #ffffff00 35%), url(<?= yii::getAlias('@web') . $val['file_name'] ?>)">
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg_top"
                 style="background-image: linear-gradient(to bottom, #000000 -24%, #ffffff00 35%), url(<?= yii::getAlias('@web') . $carousel[0]['file_name'] ?>); ">
                <div class="bg_layer">
                </div>
            </div>
        <?php endif; ?>

        <div class="logo">
            <a href="<?= Url::to(['/']) ?>">
                <img src="<?= yii::getAlias('@web') . '/app/media/img/logo_white.png' ?>" alt="Schildr - Logo">
            </a>
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

<div class="container-fluid main_center" >
    <div class="bread" style="margin-top: 15px" >
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
            <div class="main_center">
                <div class="col-md-4 text-uppercase" style="border-top: 1px solid #7396ae;  padding-left: 0;">
                    <h1 class="text-uppercase" style="font-size: 45.7px; font-family: 'Barlow', sans-serif; font-weight: normal; color: #232323; margin-top: 30px;"><?= yii::t('db', 'About us') ?></h1>
                </div>
                <div class="col-lg-12 col-md-12 about_text" style="padding: 0;">
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

<!--Page statistic-->
<div class="container-fluid statistic" style="margin-top: 100px; width: calc(100% - 50px);display: flex;justify-content: center;">
    <div class="about_bottom">
        <div class=" statistic__inner d-flex " style="width: calc(100% - 50px)">
            <div class="col-lg-4 col-md-4 statistic_left" style="padding-left: 0;">
                <img src="<?= yii::getAlias('@web') . '/app/media/img/bitmap-man.png' ?>" alt="statistic"
                     class="img-responsive">
            </div>
            <div class="col-lg-8 col-md-8 statistic_left" style="height: 100%;">
                    <div class="col-md-4 col-sm-4 statistic_item">
                        <span class="counter"><?= $yearsExperience['value'] ?></span>
                        <p>
                            <u><?= yii::t('db', explode(' ', $yearsExperience['title'])[0]) ?></u><br>
                            <u><?= yii::t('db', explode(' ', $yearsExperience['title'])[1]) ?></u>
                        </p>
                    </div>
                    <div class="col-md-4 col-sm-4 statistic_item">
                        <span class="counter"><?= $productRange['value'] ?></span>
                        <p>
                            <u><?= yii::t('db', explode(' ', $productRange['title'])[0]) ?></u><br>
                            <u><?= yii::t('db', explode(' ', $productRange['title'])[1]) ?></u>
                        </p>
                    </div>
                    <div class="col-md-4 col-sm-4 statistic_item">
                        <span class="counter"><?= $partnerBrands['value'] ?></span>
                        <p>
                            <u><?= yii::t('db', explode(' ', $partnerBrands['title'])[0]) ?></u><br>
                            <u><?= yii::t('db', explode(' ', $partnerBrands['title'])[1]) ?></u>
                        </p>
                    </div>
                    <div class="col-xs-12 statistic_content text-center">
                        <p>
                            <?= yii::t('db', 'Glass Construction LLC has been carrying out its activities since 2007 offering the all types of modern glass and glass systems in Azerbaijani market. Taking into consideration the global technological development and increasing consumers’ demand, Glass Construction brought the modern and comfortable Glass Balcony'); ?>
                        </p>
                    </div>
            </div>
        </div>
    </div>
</div>
<!-- #Page statistic-->

<!--Projects Has Been Done -->
<!--<div class="container-fluid main_center about_text" style="padding-top: 100px;">-->
<!--    <div class="title for_about">-->
<!--        <div class="project_done">-->
<!--            <div class="title">-->
<!--                <div class="inner_main_center mt-0 pb-415-0">-->
<!--                    <div class=" oddd_item d-flex flex-row" >-->
<!--                        <div class=" main_center d-flex flex-column aligin-items-start">-->
<!--                            <div class="Path-3-Copy-36"></div>-->
<!--                            <div style="width: 400px ; margin-top: 30px;">-->
<!--                                <p class="Enjoy-the-serenity-Copy">What prove we move forward</p>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="title">-->
<!--                <div class="page_title_prd">-->
<!--                    <div class=" text-uppercase">-->
<!--                        <h1 class="text-uppercase">PROJECTS HAVE BEEN DONE</h1>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="title">-->
<!--                <div class="about_bottom" >-->
<!--                    <div class="col-xs-12 col-sm-4 project_done_item">-->
<!--                        <span class="counter">--><?//= $recidentalProjects['value'] ?><!--</span>-->
<!--                        <h4>--><?//= yii::t('db', $recidentalProjects['title']) ?><!--</h4>-->
<!--                        <p>-->
<!--                            --><?//= yii::t('db', 'recidental_project') ?>
<!--                        </p>-->
<!--                    </div>-->
<!--                    <div class="col-xs-12 col-sm-4 project_done_item">-->
<!--                        <span class="counter">--><?//= $commercialProjects['value'] ?><!--</span>-->
<!--                        <h4>--><?//= yii::t('db', $commercialProjects['title']) ?><!--</h4>-->
<!--                        <p>-->
<!--                            --><?//= yii::t('db', 'commercial_project') ?>
<!--                        </p>-->
<!--                    </div>-->
<!--                    <div class="col-xs-12 col-sm-4 project_done_item">-->
<!--                        <span class="counter">--><?//= $totalProjects['value'] ?><!--</span>-->
<!--                        <h4>--><?//= yii::t('db', $totalProjects['title']) ?><!--</h4>-->
<!--                        <p>-->
<!--                            --><?//= yii::t('db', 'total_project') ?>
<!--                        </p>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <a href="--><?//= Url::to(['project/recidental']) ?><!--" class="btn_more">MORE</a>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!-- #Projects Has Been Done -->


<?php foreach ($pageBlocks as $key => $val): ?>
    <div class="container-fluid main_center about_text">
        <div class="title for_about">
            <div class="mission border_1">
                <div class="title">
                    <div class="inner_main_center mt-0 pb-415-0">
                        <div class=" oddd_item d-flex flex-row" >
                            <div class=" main_center d-flex flex-column aligin-items-start">
                                <div class="Path-3-Copy-36"></div>
                                <div class="Enjoy-div">
                                    <p class="Enjoy-the-serenity-Copy">What prove we move forward</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="title">
                    <div class="page_title_prd">
                        <div class=" text-uppercase">
                            <h1 class="text-uppercase"><?= $key ?></h1>
                        </div>
                    </div>
                </div>
                <div class="title">
                    <div class="inner_main_center">
                        <div class="title mission-title">
                            <?php foreach ($val as $item): ?>
                                <div class="mission_item">
                                    <h5><?= $item['title'] ?></h5>
                                    <img class="img-responsive"
                                         src="<?= yii::getAlias('@web') . $item['image'] ?>"
                                         alt="<?= $item['short'] ?>">
                                    <p><?= $item['short'] ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

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
</div>