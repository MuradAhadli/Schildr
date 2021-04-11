<?php

use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\models\Page;

$pageName = Page::getParentNav(yii::$app->request->get('page_slug'));
$site = yii::$app->request->getHostName();
$this->title = $pageName['title'] . " » " . $site;

$slug = yii::$app->request->get('page_slug');

?>

<!--top-->
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
        <div class="page_title pb-0 pl_992_0">
            <div class="row">
                <div class="col-md-4 text-uppercase">
                    <h1 class="text-uppercase"><?= yii::t('db', 'About us') ?></h1>
                </div>
                <div class="col-lg-7 col-md-8">
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
<div class="container-fluid statistic">
    <div class="row mr-0 statistic__inner">
        <div class="col-lg-4 col-md-4 statistic_left">
            <img src="<?= yii::getAlias('@web') . '/app/media/img/bitmap-man.png' ?>" alt="statistic"
                 class="img-responsive">
        </div>
        <div class="col-lg-7 col-md-7 statistic_left">
            <div class="">
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
                <div class="col-xs-12 statistic_content">
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
<div class="container-fluid main_center">
    <div class="inner_main_center for_about">
        <div class="project_done">
            <h1 class="mt-0 section_title"><?= yii::t('db', 'PROJECTS HAVE BEEN DONE') ?></h1>
            <span class="short"><?= yii::t('db', 'what prove we move forward') ?></span>
            <div class="row mr-0 ml-0">
                <div class="col-xs-12 col-sm-4 project_done_item">
                    <span class="counter"><?= $recidentalProjects['value'] ?></span>
                    <h4><?= yii::t('db', $recidentalProjects['title']) ?></h4>
                    <p>
                        <?= yii::t('db', 'recidental_project') ?>
                    </p>
                </div>
                <div class="col-xs-12 col-sm-4 project_done_item">
                    <span class="counter"><?= $commercialProjects['value'] ?></span>
                    <h4><?= yii::t('db', $commercialProjects['title']) ?></h4>
                    <p>
                        <?= yii::t('db', 'commercial_project') ?>
                    </p>
                </div>
                <div class="col-xs-12 col-sm-4 project_done_item">
                    <span class="counter"><?= $totalProjects['value'] ?></span>
                    <h4><?= yii::t('db', $totalProjects['title']) ?></h4>
                    <p>
                        <?= yii::t('db', 'total_project') ?>
                    </p>
                </div>
            </div>
            <a href="<?= Url::to(['project/recidental']) ?>" class="btn_more">MORE</a>
        </div>
    </div>
</div>
<!-- #Projects Has Been Done -->


<?php foreach ($pageBlocks as $key => $val): ?>
    <div class="container-fluid main_center">
        <div class="inner_main_center for_about">
            <div class="mission border_1">
                <h1 class="section_title mt-0"><?= $key ?></h1>
                <div class="row">
                    <?php foreach ($val as $item): ?>
                        <div class="col-lg-6 mission_item">
                            <h5><?= $item['title'] ?></h5>
                            <img class="img-responsive"
                                 src="<?= yii::getAlias('@web') . $item['image'] ?>"
                                 alt="">
                            <p><?= $item['short'] ?></p>
                        </div>
                    <?php endforeach; ?>
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