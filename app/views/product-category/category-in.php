<?php

use yii\easyii\modules\product\models\ProductFiles;
use yii\easyii\modules\productcategory\models\ProductCategory;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\widgets\Breadcrumbs;
use yii\easyii\modules\productmodels\models\Productmodels;
use app\models\Page;

$page = yii::$app->controller->id;
$pageName = (explode('-', $page));
$pageNames = $pageName[0];
$productName = ProductCategory::getProductCategory(null, yii::$app->request->get('id'), yii::$app->request->get('slug'));
$id = $productName[0]['parent_id'];
$productmodels = Productmodels::getProductModelByParent($products['id']);
$site = yii::$app->request->getHostName();
$this->title = $productCategory['title'] . " - " . $products['title'] . "  - Schildr Outdoor Solution, New Jersey " ;

?>
<link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<!--top-->
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
                <h2><?= $products['title'] ?></h2>
                <p><?= $productCategory['title'] ?></p>
            </div>
            <div class="solid_item">
            </div>
            <div class="carousel_right_zone_inner">
                <ul>

                    <?php foreach ($productmodels as $key => $val): ?>
                        <li><a href="#item-<?= $key ?>" class="scrollLink"><?= $val['product_model_name']; ?></a></li>
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
            <div class="slide">
                <?php foreach ($carousel as $key => $val): ?>
                <?php if ($val['type'] == 1): ?>
                    <div class="slide-element" style="background-image: linear-gradient(to bottom, #000000 -24%, #ffffff00 35%)">
                        <div class="bread-div">
                            <div class="bread-bottom" style="flex-wrap: wrap">
                                <h1 style="width: 100%;font-size: 60px;line-height: normal"><?=$products['title']?></h1>
                                <br>
                                <h1 style="font-size: 20px ;width: 100%"><?= $products['short'] ?> </h1>
                            </div>
                        </div>
                        <video autoplay loop muted id="myVideo" style="height: auto !important;">
                            <source src="<?= yii::getAlias('@web') . $val['file_name'] ?>" type="video/mp4">
                        </video>
                            <div class="bread-div">
                                <div class="bread-bottom" style="flex-wrap: wrap">
                                    <h1 style="width: 100%;font-size: 60px;line-height: normal"><?=$products['title']?></h1>
                                    <br>
                                    <h1 style="font-size: 20px ;width: 100%"><?= $products['short'] ?> </h1>
                                </div>
                            </div>
                    </div>
                    <?php else: ?>
                        <div class="slide-element" style="background-image: linear-gradient(to bottom, #000000 -24%, #ffffff00 35%), url(<?= yii::getAlias('@web') . $val['file_name'] ?>)">
                                <div class="bread-div">
                                    <div class="bread-bottom" style="flex-wrap: wrap">
                                        <h1 style="width: 100%;font-size: 60px;line-height: normal"><?=$products['title']?></h1>
                                        <br>
                                        <h1 style="font-size: 20px ;width: 100%"><?= $products['short'] ?> </h1>
                                    </div>
                                </div>
                        </div>
                    <?php endif ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <?php if ($carousel[0]['type'] == 0): ?>
                <div class="bg_top" style="background-image: linear-gradient(to bottom, #000000 -24%, #ffffff00 35%), url(<?= yii::getAlias('@web') . $carousel[0]['file_name'] ?>)">
                    <div class="bread-div">
                        <div class="bread-bottom" style="flex-wrap: wrap">
                            <h1 style="width: 100%;font-size: 60px;line-height: normal"><?=$products['title']?></h1>
                            <br>
                            <h1 style="font-size: 20px ;width: 100%"><?= $products['short'] ?> </h1>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg_top"
                     style="background-image: linear-gradient(to bottom, #000000 -24%, #ffffff00 35%); height: 88.1vh;">
                    <div class="bg_layer">
                        <div class="overlay"></div>
                        <video autoplay loop muted id="myVideo" class="slider-video" >
                            <source src="<?= yii::getAlias('@web') . $carousel[0]['file_name'] ?>" type="video/mp4">
                        </video>

                        <div class="bread-div">
                            <div class="bread-bottom" style="flex-wrap: wrap">
                                <h1 style="width: 100%;font-size: 60px;line-height: normal"><?=$products['title']?></h1>
                                <br>
                                <h1 style="font-size: 20px ;width: 100%"><?= $products['short'] ?> </h1>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        <?php endif; ?>

    </div>
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
    <!-- /Carousel -->
</div>

<div class="container-fluid main_center">
<!--    <div class="inner_main_center mt-0 pb-415-0">-->
<!--        page breadCrumb-->
<!---->
<!--        <div class=" _bread_crumb_other_page">-->
<!--            --><?//= Breadcrumbs::widget([
//                'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
//                'links' => [
//                    [
//                        'label' => 'Products',
//                        'url' => ['product-category/index', 'page_slug' => 'product'],
//                    ],
//                    [
//                        'label' => $productName[0]['title'],
//                    ]
//
//                ],
//            ]); ?>
<!--        </div>-->
<!--    </div>-->


    <!--Page Title-->
<!--    <div class="page_title">-->
<!--        <div class="row">-->
<!--            <div class="col-md-4 text-uppercase">-->
<!--                <h1>--><?//= $productName[0]['title'] ?><!--</h1>-->
<!--            </div>-->
<!--            <div class="col-lg-7 col-md-8">-->
<!--                <h4 class="text-uppercase">--><?//= $productName[0]['title'] ?><!--</h4>-->
<!--                <p>-->
<!--                    --><?//= $productName[0]['short'] ?>
<!--                </p>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <div class="inner_main_center for_about" style="margin-top: 0px">
        <div class="bread">
            <div class="_bread_crumb_other_page ">
                <?= Breadcrumbs::widget([
                    'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
                    'links' => [
                        [
                            'label' => 'Products',
                            'url' => ['product-category/index', 'page_slug' => 'product'],
                        ],
                        [
                            'label' =>  $productCategory['title'],
                            'url' => ['product-category/view', 'page_slug' => 'product', 'slug' => $productCategory['slug'], 'id' => $productCategory['id']],
                        ],
                        [
                            'label' => $products['title'],
                        ],
                    ],

                ]); ?>
            </div>
        </div>
        <div class="page_titles pb-0 pl_992_0" style="padding: 0;">
            <div class="main_center">
                <div class="col-md-12 text-uppercase" style="border-top: 1px solid #7396ae;  padding-left: 0;">
                    <h1 class="text-uppercase page_name" style="font-size: 45.7px; font-family: 'Barlow', sans-serif; font-weight: normal; color: #232323; margin-top: 30px;"><?= $products['title'] ?></h1>
                </div>
                <div class="col-lg-12 col-md-112 recidental_text" style="padding-right: 0;padding-left: 0;">
                    <h4 class="text-uppercase">
<!--                        --><?//= $products['title'] ?>
                    </h4>
                    <p>
                        <?= $products['customization'] ?>
                    </p>
                </div>
            </div>
        </div>
    </div>



    <!--Complex Page Systems-->
    <?php $index = 0;
//    foreach ($products as $key => $val): ?>
        <?php
        $files = array_values($products['files']);
        $realImage = '';
        $hoverImage = '';

        if (isset($products['hover_image']) && !empty($products['hover_image'])) {
            $hoverImage = $products['hover_image'];
        }
        foreach ($products['files'] as $file) {
            if ($file['is_base'] == 1) {
                $realImage = $file['file'];
            }
        }
        if ($realImage == '') {
            if (isset($files[0]) && !empty($files[0])) {
                $realImage = $files[0]['file'];
            };
        }
        ?>
    <div class="container-fluid  ">
        <div class="title product-in product-model">
            <div class="hdr-prd-left" style="margin-top: 100px;">
                <div class="main_prd_right" style="background-image: url('<?= yii::getAlias('@web') . $realImage ?>');background-size: cover">

                </div>
                <div class="main_prd_left" >
                    <div style="background-color: <?= $products['color'] ?>" class="prdct-single-info" >
                        <div class="prdct-single-name">
                            <h2 class="prd-name" id="<?= $products['slug'] ?>"><?= $products['title'] ?></h2>
                        </div>
                        <div class="prdct-single-about"><?= $products['about'] ?></div>
                        <div class="container-fluid" style="display: flex; flex-direction: row; padding-left: 64px; padding-right:64px;  margin-top: 10px">
                            <!--                            <p class="prdct-single-app">-->
                            <!--                                Let us price your project-->
                            <!--                            </p>-->
                            <a href="/get-quote/<?= $products['id'] ?>" class="quote-link">
                                <div class="contener conteener-prdct" style="background-color: <?= $products['color'] ?>;    filter: brightness(120%);">
                                    <div class="txt_button">GET QUOTE</div>
                                    <div class="circle">&nbsp;</div>
                                </div>
                            </a>
                        </div>
                        <!--                        <a href="/quote" class="btn get-qoute">Get Qoute</a>-->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="title">
        <div class="vproducts d-flex flex-row slider-for-prd aniimated-thumbnials" >
            <?php
            foreach ($productmodels as $ky => $value): ?>
            <?php if (empty($value['url'])) :?>
                <a data-exthumbimage="<?= yii::getAlias('@web') . $value['image'] ?>" href="<?= yii::getAlias('@web') . $value['image'] ?>">
                    <div class="vproduct d-flex flex-column product-model">
                        <div class="vproduct-bottom" style="background-image: url('<?= yii::getAlias('@web') . $value['image'] ?>') ">
<!--                            <img style="width: 100%; height: 100%; display: none" src="--><?//= yii::getAlias('@web') . $value['image'] ?><!--" alt="--><?//= $value['product_model_title'] ?><!--">-->
                        </div>
                        <div style="width: 100%;" class="product-model-txt">
                            <div class="d-flex flex-row" >
                                <p class="SkyLounge"><?= $value['product_model_name'] ?></p>
                            </div>
                            <p class="Solution-customized">
                                <?= $value['product_model_title'] ?>
                            </p><br>
                        </div>
                    </div>
                </a>
                <?php endif ?>
            <?php  endforeach ?>
        </div>
    </div>
        <?php
        if (isset($products['hover_image']) && !empty($products['hover_image'])) :
            $hoverImage = $products['hover_image']; ?>
            <div class="inner_main_center">
                <hr class="hr">
                <h2 class="hover_text">
                    <?= $products['hover_text'] ?>
                </h2>
            <div class="video-single">
                <img width="100%" height="100%" src="<?= yii::getAlias('@web') . $hoverImage ?>" alt=" <?= $products['hover_text'] ?>">
            </div>
        </div>

        <?php endif ?>
    <div class="title">
        <div class="vproducts d-flex flex-row slider-for-prd aniimated-thumbnials" >
            <?php
            foreach ($productmodels as $key => $valuee): ?>
            <?php if (isset($valuee['url']) && !empty($valuee['url'])) :?>
                <a href="<?= yii::getAlias('@web') . $valuee['url'] ?>">
                    <div class="vproduct d-flex flex-column">
                        <div class="vproduct-bottom" style="background-image: url('<?= yii::getAlias('@web') . $valuee['image'] ?>') ">
                            <img style="width: 100%; height: 100%; display: none" src="<?= yii::getAlias('@web') . $valuee['image'] ?>" alt="<?= $valuee['product_model_title'] ?>">
                            <i class="far fa-play-circle"></i>
                        </div>
                        <div style="width: 100%;" d-flex flex-column align-items-start pl-5>
                            <div class="d-flex flex-row" >
                                <p class="SkyLounge"><?= $valuee['product_model_name'] ?></p>
                            </div>
                            <p class="Solution-customized">
                                <?= $valuee['product_model_title'] ?>
                            </p><br>
                        </div>
                    </div>
                </a>
                <?php endif ?>
            <?php  endforeach ?>
        </div>
    </div>

    <?php foreach ($products['files'] as $k => $v): ?>
            <?php if ($v['type'] == ProductFiles::VIDEO_TYPE): ?>
                <div class="inner_main_center">
                    <div class="video-single">
                        <span class="play_btn">
                            <i class="far fa-play-circle"></i>
                        </span>
                        <span class="pause_btn">
                            <i class="far fa-pause-circle"></i>
                        </span>
                        <video class="home_page_video" controls>
                            <source src="<?= yii::getAlias('@web') . $v['file'] ?>"
                                    type="video/mp4">
                            <source src="<?= yii::getAlias('@web') . $v['file'] ?>"
                                    type="video/ogg">
                        </video>
                    </div>
                </div>
            <?php endif ?>
        <?php endforeach ?>
    <?php if ( isset($products['text']) && !empty($products['text'])): ?>
        <div class="container-fluid text-container">
            <div class="inner_main_center" style="color: black">
                    <?= $products['text'] ?>
            </div>
        </div>
        <?php endif?>
    <?php $index++;  ?>
</div>
<?php foreach (unserialize($products['downloads']) as $k => $v): ?>
<div class="container-fluid" style="background-color: <?= $products['color']?>;padding-top: 25px; padding-bottom: 25px;margin-top: 60px">
    <div class="inner_main_center">
        <div class="page_title_prd">
            <h1 style="margin: 0">ORDER TODAY: <?= $products['title'] ?> CATALOG</h1>
        </div>
        <div class="main">
            <div class="main_left">
                <img class="image" src='<?= yii::getAlias('@web') . '/' . $v['image'] ?>' alt="<?= $products['title'] ?>">
            </div>
            <div class="main_right" style="padding: 20px">
                <p class="SkyLounge">
                    <?= $v['title'] ?>
                </p>
                <a href="<?= yii::getAlias('@web') . '/' . $v['pdf'] ?>" download>
                    <div class="contener" style="background-color: <?= $products['color']?> ;filter: brightness(120%);">
                        <div class="txt_button">DOWNLOAD</div>
                        <div class="circle">&nbsp;</div>
                    </div>
                </a>
            </div>
        </div>

<!--        <div class="absolute__file">-->
<!--            --><?php //foreach (unserialize($products['downloads']) as $k => $v): ?>
<!--                <div class="item">-->
<!--                    <div class="cat_header">-->
<!--                        <p>Download Catalog</p>-->
<!--                    </div>-->
<!--                    <div class="link">-->
<!--                        <a target="_blank" href="--><?//= yii::getAlias('@web') . '/' . $v['pdf'] ?><!--">-->
<!--                            --><?//= $v['title'] ?>
<!--                        </a>-->
<!--                    </div>-->
<!--                    <div class="file_img">-->
<!--                        <img src="--><?//= yii::getAlias('@web') . '/app/media/img/pdf.svg' ?><!--" alt="">-->
<!--                    </div>-->
<!--                </div>-->
<!--            --><?php //endforeach; ?>
<!--        </div>-->

    </div>
</div>
<?php endforeach; ?>
<!--    <div class="container-fluid">-->
<!--        <div class="title">-->
<!--            <div class="hdr-left">-->
<!--                <div class="main_prd_left">-->
<!--                    <div class="prdct-single-name">-->
<!--                        <p class="prd-name">SkyLounge</p>-->
<!--                        <p class="prd-title">Motorized louvered Roof LP450</p>-->
<!--                    </div>-->
<!--                    <div class="prdct-single-info-2">-->
<!--                        <p class="prdct-single-about">-->
<!--                            Solution customized to meet your needs-->
<!--                            High-end motorized louvered roof, made of aluminum structure with insulated aluminum panels, offers outstanding comfort in rainy and sunny days. Pergola Roof Louver withstands greater snow loads and strong winds. It is a great application for your patio, terrace, or restaurant all year round.-->
<!--                        </p>-->
<!--                        <p class="prdct-single-app">-->
<!--                            Application: <br>-->
<!--                            Rooftop, Terrace, Restaurant, Patio-->
<!--                        </p>-->
<!--                        <button class="btn get-qoute-2">Get Qoute</button>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="main_prd_right">-->
<!--                    <img class="prdct-single-img" src="https://mail.google.com/mail/u/0?ui=2&ik=f4933f490f&attid=0.1&permmsgid=msg-a:r1578280899321075066&th=17724f8a45f7865f&view=fimg&sz=s0-l75-ft&attbid=ANGjdJ9Cd7nEs3zFNyz75DpyF9D1u4BnphIV-EqSNomi_VFLgjsneZgRhQUb7L7Wkx5aEzBDFvRBLfLhrtRO98aPCVpf20oo_Fb5eKvmv8ITKdCFhQBuzYiv1c29ZBw&disp=emb&realattid=ii_kk6uj5xw0" alt="">-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="title">-->
<!--        <div class="vproducts d-flex flex-row">-->
<!--            <div class="vproduct d-flex flex-column">-->
<!--                <div class="vproduct-bottom">-->
<!--                    <img style="width: 100%; height: 100%" src="https://mail.google.com/mail/u/0?ui=2&ik=f4933f490f&attid=0.1&permmsgid=msg-a:r1578280899321075066&th=17724f8a45f7865f&view=fimg&sz=s0-l75-ft&attbid=ANGjdJ9Cd7nEs3zFNyz75DpyF9D1u4BnphIV-EqSNomi_VFLgjsneZgRhQUb7L7Wkx5aEzBDFvRBLfLhrtRO98aPCVpf20oo_Fb5eKvmv8ITKdCFhQBuzYiv1c29ZBw&disp=emb&realattid=ii_kk6uj5xw0" alt="">-->
<!--                </div>-->
<!--                <div style="width: 100%;" d-flex flex-column align-items-start pl-5>-->
<!--                    <div class="d-flex flex-row" >-->
<!--                        <p class="SkyLounge">SkyLounge</p>-->
<!--                    </div>-->
<!--                    <p class="Solution-customized">-->
<!--                        Solution customized to meet your needs High-end motorized louvered roof, made of aluminum structure with insulated aluminum panels, offers outstanding comfort in rainy and sunny days. </p><br>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="vproduct d-flex flex-column">-->
<!--                <div class="vproduct-bottom" >-->
<!--                    <img style="width: 100%; height: 100%" src="https://mail.google.com/mail/u/0?ui=2&ik=f4933f490f&attid=0.1&permmsgid=msg-a:r1578280899321075066&th=17724f8a45f7865f&view=fimg&sz=s0-l75-ft&attbid=ANGjdJ9Cd7nEs3zFNyz75DpyF9D1u4BnphIV-EqSNomi_VFLgjsneZgRhQUb7L7Wkx5aEzBDFvRBLfLhrtRO98aPCVpf20oo_Fb5eKvmv8ITKdCFhQBuzYiv1c29ZBw&disp=emb&realattid=ii_kk6uj5xw0" alt="">-->
<!--                </div>-->
<!--                <div style="width: 100%;" d-flex flex-column align-items-start pl-5>-->
<!--                    <div class="d-flex flex-row" >-->
<!--                        <p class="SkyLounge" >SkyLounge</p>-->
<!--                    </div>-->
<!--                    <p class="Solution-customized">-->
<!--                        Solution customized to meet your needs High-end motorized louvered roof, made of aluminum structure with insulated aluminum panels, offers outstanding comfort in rainy and sunny days. </p><br>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="vproduct d-flex flex-column">-->
<!--                <div class="vproduct-bottom" >-->
<!--                    <img style="width: 100%; height: 100%" src="https://mail.google.com/mail/u/0?ui=2&ik=f4933f490f&attid=0.1&permmsgid=msg-a:r1578280899321075066&th=17724f8a45f7865f&view=fimg&sz=s0-l75-ft&attbid=ANGjdJ9Cd7nEs3zFNyz75DpyF9D1u4BnphIV-EqSNomi_VFLgjsneZgRhQUb7L7Wkx5aEzBDFvRBLfLhrtRO98aPCVpf20oo_Fb5eKvmv8ITKdCFhQBuzYiv1c29ZBw&disp=emb&realattid=ii_kk6uj5xw0" alt="">-->
<!--                </div>-->
<!--                <div style="width: 100%;" d-flex flex-column align-items-start pl-5>-->
<!--                    <div class="d-flex flex-row" >-->
<!--                        <p class="SkyLounge" >SkyLounge</p>-->
<!--                    </div>-->
<!--                    <p class="Solution-customized">-->
<!--                        Solution customized to meet your needs-->
<!--                        High-end motorized louvered roof, made of aluminum structure with insulated aluminum panels, offers outstanding comfort in rainy and sunny days. </p><br>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->


<!--        <div class="main_bottom_inner width-100">-->
<!--            --><?php //$index = 0;
//            foreach ($products as $key => $val): ?>
<!---->
<!--                <div class="page_complex_system" id="item---><?//= $index ?><!--">-->
<!--                    <h3 class="text-center" id="--><?//= $val['slug'] ?><!--">--><?//= $val['title'] ?><!--</h3>-->
<!--                    <div class="complex_system_carousel" style="position:relative;">-->
<!--                        <div class="rect-helper"></div>-->
<!--                        <div class="row complex_system_carousel_inner">-->
<!---->
<!--                            <div class="complex_carousel_helper">-->
<!--                                <div class="slick_arrow">-->
<!--                                    <span id="slick-left---><?//= $key ?><!--" class="slick_left">-->
<!--                                        <img src="--><?//= yii::getAlias('@web') . '/app/media/img/arrow-black-left-svg.svg' ?><!--"-->
<!--                                             alt="">-->
<!--                                    </span>-->
<!--                                    <span id="slick-right---><?//= $key ?><!--" class="slick_right">-->
<!--                                        <img src="--><?//= yii::getAlias('@web') . '/app/media/img/arrow-black-right-svg.svg' ?><!--"-->
<!--                                             alt="">-->
<!--                                    </span>-->
<!--                                </div>-->
<!--                                <div id="SlickNav---><?//= $key ?><!--"-->
<!--                                     class="complex_carousel_nav col-xs-12 col-sm-12 col-md-8">-->
<!---->
<!--                                    --><?php //foreach ($val['files'] as $k => $v): ?>
<!---->
<!--                                        --><?php //if ($v['type'] == ProductFiles::IMAGE_TYPE): ?>
<!--                                            <div>-->
<!--                                                <img class="img-responsive"-->
<!--                                                     src="--><?//= yii::getAlias('@web') . $v['file'] ?><!--"-->
<!--                                                     alt="--><?//= $val['title'] ?><!--">-->
<!--                                            </div>-->
<!--                                        --><?php //else: ?>
<!---->
<!--                                            <div class="col-lg-6 col-md-12 col-sm-12 main_center_video">-->
<!--                                                <video class="home_page_video">-->
<!--                                                    <source src="--><?//= yii::getAlias('@web') . $v['file'] ?><!--"-->
<!--                                                            type="video/mp4">-->
<!--                                                    <source src="--><?//= yii::getAlias('@web') . $v['file'] ?><!--"-->
<!--                                                            type="video/ogg">-->
<!--                                                    Your browser does not support the video tag.-->
<!--                                                </video>-->
<!--                                            </div>-->
<!---->
<!--                                        --><?php //endif; ?>
<!---->
<!--                                    --><?php //endforeach; ?>
<!---->
<!--                                </div>-->
<!--                                <div class="content_helper">-->
<!--                                    <div class="absolute__content">-->
<!--                                        <h1 class="text-uppercase">--><?//= yii::t('db', 'Design features'); ?><!--</h1>-->
<!--                                        --><?//= $val['customization'] ?>
<!--                                    </div>-->
<!--                                    <div class="absolute__file">-->
<!---->
<!--                                        --><?php //foreach (unserialize($val['downloads']) as $k => $v): ?>
<!---->
<!--                                            <div class="item">-->
<!--                                                <div class="file_img">-->
<!--                                                    <img src="--><?//= yii::getAlias('@web') . '/app/media/img/pdf.svg' ?><!--"-->
<!--                                                         alt="">-->
<!--                                                </div>-->
<!--                                                <div class="link">-->
<!--                                                    <a target="_blank"-->
<!--                                                       href="--><?//= yii::getAlias('@web') . '/' . $v['pdf'] ?><!--">-->
<!--                                                        --><?//= $v['title'] ?>
<!--                                                    </a>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!---->
<!--                                        --><?php //endforeach; ?>
<!---->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div id="SlickFor---><?//= $key ?><!--"-->
<!--                                 class="complex_carousel_for col-xs-12 col-sm-12 col-md-8">-->
<!--                                --><?php //foreach ($val['files'] as $k => $v): ?>
<!---->
<!--                                    --><?php //if ($v['type'] == ProductFiles::IMAGE_TYPE): ?>
<!--                                        <div>-->
<!--                                            <img class="img-responsive"-->
<!--                                                 src="--><?//= yii::getAlias('@web') . $v['file'] ?><!--"-->
<!--                                                 alt="--><?//= $val['title'] ?><!--">-->
<!--                                        </div>-->
<!--                                    --><?php //else: ?>
<!---->
<!--                                        <div class="col-lg-6 col-md-12 col-sm-12 main_center_video">-->
<!--                                            <span class="play_btn">-->
<!--                                                <i class="far fa-play-circle"></i>-->
<!--                                            </span>-->
<!--                                            <span class="pause_btn">-->
<!--                                                <i class="far fa-pause-circle"></i>-->
<!--                                            </span>-->
<!--                                            <video class="home_page_video">-->
<!--                                                <source src="--><?//= yii::getAlias('@web') . $v['file'] ?><!--"-->
<!--                                                        type="video/mp4">-->
<!--                                                <source src="--><?//= yii::getAlias('@web') . $v['file'] ?><!--"-->
<!--                                                        type="video/ogg">-->
<!--                                                Your browser does not support the video tag.-->
<!--                                            </video>-->
<!--                                        </div>-->
<!---->
<!--                                    --><?php //endif; ?>
<!---->
<!--                                --><?php //endforeach; ?>
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                    </div>-->
<!--                </div>-->
<!--                --><?php //$index++; endforeach ?>
<!--        </div>-->


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
                            <div class="col-xs-2 clients_item" style="background-image: url('<?= yii::getAlias('@web') . $client['image'] ?>');background-size: cover;background-position: center">
                                <a href="javascript:void(0)">
<!--                                    <img src="--><?//= yii::getAlias('@web') . $client['image'] ?><!--" alt="Clients">-->
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
<script>

</script>
<br><br>