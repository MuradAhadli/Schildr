<?php

use app\models\Page;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\easyii\modules\productcategory\models\ProductCategory;
use yii\easyii\modules\carousel\models\CarouselUploads;

$slug = yii::$app->request->get('slug');
$controller = yii::$app->controller->id;
$pageName = Page::getParentNav(yii::$app->request->get('page_slug'));
$productName = ProductCategory::getProductCategorybySlug(yii::$app->request->get('slug', 'parent_id'));

$site = yii::$app->request->getHostName();
$this->title = $productName['title'] ." - Schildr Outdoor Solutions, New Jersey ";
?>

<!--top-->

<link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<div class="container-fluid main_top">
    <!--Carouse-->
    <div class="carousel" >

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


        <div class="carousel_right_zone">
            <div class="carousel_right_zone_inner">
                <h2><?= yii::t('db', 'Products'); ?></h2>
                <p><?= $productCategory[0]['title']; ?></p>
            </div>
            <div class="solid_item">
            </div>
            <div class="carousel_right_zone_inner">
                <ul>
                    <?php foreach ($products as $key => $val): ?>
                    <?php
                        $slug = yii::$app->request->get('slug');
                        $id = $val['id'];
                        ?>
                        <li><a href="<?= Url::to([
                                'product-category/category-in',
                                'page_slug' => 'product',
                                'id' => $id,
                                'slug' => $slug,
                                'key' => 'explore',
                            ]) . '#' . $val['slug'] ?>"><?= $val['title']; ?></a></li>
                    <?php endforeach; ?>
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
            <div class="bread-div">
                <div class="bread-bottom" style="flex-wrap: wrap">
                    <h1 style="width: 100%;font-size: 60px;line-height: normal"><?=$productCategory[0]['title']?></h1>
                    <br>
                     <h1 style="font-size: 20px ;width: 100%"><?= $productCategory[0]['subtitle'] ?> </h1>
                </div>
            </div>
            <div class="slide">
                <?php foreach ($carousel as $key => $val): ?>
                <?php if ($val['type'] == 1): ?>
                        <div class="slide-element"
                             style="background-image: linear-gradient(to bottom, #000000 -24%, #ffffff00 35%) ">
                            <video loop autoplay muted id="myVideo" style="height: auto !important; width: 100%">
                                <source src="<?= yii::getAlias('@web') . $val['file_name'] ?>" type="video/mp4">
                            </video>

                        </div>
                <?php else: ?>
                        <div class="slide-element" style="background-image: linear-gradient(to bottom, #000000 -24%, #ffffff00 35%), url(<?= yii::getAlias('@web') . $val['file_name'] ?>)"></div>
                <?php endif ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <?php if ($carousel[0]['type'] == 0): ?>
                <div class="bg_top"
                     style="background-image: linear-gradient(to bottom, #000000 -24%, #ffffff00 35%), url(<?= yii::getAlias('@web') . $carousel[0]['file_name'] ?>)">
                    <div class="bread-div">
                        <div class="bread-bottom" style="flex-wrap: wrap">
                            <h1 style="width: 100%;font-size: 60px;line-height: normal"><?=$productCategory[0]['title']?></h1>
                            <br>
                            <h1 style="font-size: 20px ;width: 100%"><?= $productCategory[0]['subtitle'] ?> </h1>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg_top bg_top_video"
                     style="background-image: linear-gradient(to bottom, #000000 -24%, #ffffff00 35%); height: 88.1vh;">
                    <div class="bg_layer">
                        <div class="overlay"></div>
                    <video class="slider-video" autoplay loop muted id="myVideo" style="height: auto !important;">
                        <source src="<?= yii::getAlias('@web') . $carousel[0]['file_name'] ?>" type="video/mp4">
                    </video>
                        <div class="bread-div">
                            <div class="bread-bottom" style="flex-wrap: wrap">
                                <h1 style="width: 100%;font-size: 60px;line-height: normal"><?=$productCategory[0]['title']?></h1>
                                <br>
                                <h1 style="font-size: 20px ;width: 100%"><?= $productCategory[0]['subtitle'] ?> </h1>
                            </div>
                        </div>
                    </div>

                </div>
            <?php endif ?>

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

    <div class="inner_main_center mt-0 pb-415-0">
        <!--page breadCrumb-->
<!--        <div class="_bread_crumb_other_page">-->
<!---->
<!--            --><?//= Breadcrumbs::widget([
//                'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
//                'links' => [
//                    [
//                        'label' => 'Products',
//                        'url' => ['product-category/index', 'page_slug' => 'product']
//                    ],
//                    [
//                        'label' => $productName['title'],
//                    ]
//                ],
//            ]); ?>
<!--        </div>-->

        <!--Page Title-->
<!--        <div class="page_title">-->
<!--            <div class="row">-->
<!--                <div class="col-md-4 text-uppercase">-->
<!--                    <h1 class="text-uppercase">--><?//=$productName['title']?><!--</h1>-->
<!--                </div>-->
<!--                <div class="col-lg-7 col-md-8">-->
<!--                    <h4 class="text-uppercase">--><?//= $productCategory[0]['subtitle'] ?><!--</h4>-->
<!--                    <p>-->
<!--                        --><?//= $productCategory[0]['short'] ?>
<!--                    </p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
        <div class="page_titles pb-0 pl_992_0" style="padding: 0; ">
            <div class="bread">
                <div class="_bread_crumb_other_page ">
                    <?= Breadcrumbs::widget([
                        'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
                        'links' => [
                            [
                                'label' => 'Products',
                                'url' => ['product-category/index', 'page_slug' => 'product']
                            ],
                            [
                                'label' => $productName['title'],
                            ]
                        ],

                    ]); ?>
                </div>
            </div>
            <div class="main_center">
                <div class="col-md-12 text-uppercase" style="border-top: 1px solid #7396ae;  padding-left: 0;">
                    <h1 class="text-uppercase page_name" style="font-size: 45.7px; font-family: 'Barlow', sans-serif; font-weight: normal; color: #232323; margin-top: 30px;"><?=$productName['title']?></h1>
                </div>
                <div class="col-lg-12 col-md-12 recidental_text" style="padding-left: 0;">

                    <p>
                        <?= $productCategory[0]['short'] ?>
                    </p>
                </div>
            </div>
        </div>

        <!--Page main content-->

        <div class="project border_1" style="width: 100%;">
            <div class="product_item_closest">
                <?php foreach ($products as $key => $val): ?>
                    <?php
                    $files = array_values($val['files']);
                    $realImage = '';
                    $hoverImage = '';

                    /*Get hover image*/
                    if (isset($val['hover_image']) && !empty($val['hover_image'])) {
                        $hoverImage = $val['hover_image'];
                    }

                    /* /Get hover image*/

                    /*Get Real Image*/
                    foreach ($val['files'] as $file) {
                        if ($file['is_base'] == 1) {
                            $realImage = $file['file'];
                        }
                    }
                    if ($realImage == '') {
                        if (isset($files[0]) && !empty($files[0])) {
                            $realImage = $files[0]['file'];
                        };
                    }
                    /* /Get Real Image*/

                    $slug = yii::$app->request->get('slug');
                    $id = $val['id'];
                    ?>

                    <div class="project_item  product-model" data-id= <?= $val['order_num'] ?>>
                        <div class="project_item_bottom" style="background-image: url('<?= yii::getAlias('@web') . $realImage ?>')">
                            <a style="width: 100%;height: 100%" href="<?= Url::to([
                                'product-category/category-in',
                                'page_slug' => 'product',
                                'id' => $id,
                                'slug' => $slug,
                                'key' => 'explore',
                            ]) . '#' . $val['slug'] ?>"></a>
                        </div>
                        <div class="project_item_top" style="background-color: <?= $val['color'] ?>">
                                <h2 class="prd-name" id="<?= $val['slug'] ?>"><?= $val['title'] ?></h2>
                                <a href="<?= Url::to([
                                    'product-category/category-in',
                                    'page_slug' => 'product',
                                    'id' => $id,
                                    'slug' => $slug,
                                    'key' => 'explore',
                                ]) . '#' . $val['slug'] ?>">
                                    <?= $val['about'] ?>
                                </a>
                            <div class="container-fluid" style="display: flex; flex-direction: row; padding-left: 10px; padding-right:10px;  margin-top: 10px">
                                <a href="/get-quote/<?= $val['id'] ?>" class="quote-link">
                                    <div class="conteener" style="background-color: <?= $val['color'] ?>;    filter: brightness(120%);">
                                        <div class="txt_button">GET QUOTE</div>
                                        <div class="circle">&nbsp;</div>
                                    </div>
                                </a>
                            </div>
                        </div>


                    </div>
                <?php endforeach; ?>
            </div>
            <button style="display: none" class="load_more" id="load_more_pr_alt"
                    data-url-id= <?= yii::$app->request->get('id') ?>>LOAD
                MORE
            </button>
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


