<?php

use yii\helpers\Html;
use yii\easyii\modules\productcategory\models\ProductCategory;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use yii\widgets\Breadcrumbs;
use app\models\Page;
use yii\easyii\modules\project\models\Project;
use yii\easyii\modules\project\models\ProjectUploads;
//\app\assets\HomeAsset::register($this);
$pageName = Page::getParentNav(yii::$app->request->get('page_slug'));
$projects = Project::getThirdProject();
//\yii\helpers\VarDumper::dump($pagesystems,10,1);

$e = 0;
?>

<div class="main_top">
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
<!---->
<!--                </ul>-->
<!--            </div>-->
<!---->
<!--        </div>-->
        <!-- / Main page left menu-->

        <div class="logo">
            <a href="<?= Url::to(['/']) ?>">
                <img src="<?= yii::getAlias('@web') . '/app/media/img/logo_white.png' ?>" alt="Schildr - Logo">
            </a>
        </div>


        <?php if (count($carousel) > 1): ?>
            <div class="bread-div"><div class="bread-bottom"><span disabled></span> <h1> PERGOLA RETRACTABLE AWNING, LOUVER, AND SUNROOM SYSTEMS</h1></div></div>
            <div class="slick-arrows-helper">

                <button id="prev"></button>
                <button id="next"></button>
            </div>
            <div class="slide">
                <?php foreach ($carousel as $key => $val): ?>
                    <div class="slide-element" style="background-image: linear-gradient(to bottom, #000000 -24%, #ffffff00 35%),  url(<?= yii::getAlias('@web') . $val['file_name'] ?>);height: 100%"></div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg_top"
                 style=" background-image: linear-gradient(to bottom, #000000 -24%, #ffffff00 35%), url(<?= yii::getAlias('@web') . $carousel[0]['file_name'] ?>)">
                <div class="bg_layer">
                    <div class="bread-div"><div class="bread-bottom"><span disabled></span> <h1> PERGOLA RETRACTABLE AWNING, LOUVER, AND SUNROOM SYSTEMS</h1></div></div>
                </div>
            </div>
        <?php endif; ?>
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

<!--center-->
<div class="container-fluid main_center">
    <div class="inner_main_center ">

        <!-- Modal -->
        <div class="modal fade video-fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog video-dialog" role="document">
                <div class="modal-content video-content">
                    <div class="modal-body video-body" style="padding: 0">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <iframe width="100%" height="100%" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
                <div class="main_center odd_item d-flex flex-column justify-content-center" >
                    <div class="bread-index">
                        <a><?= Yii::t('db', 'Home') ?></a>
                    </div>
                    <div class="hdr-left hdr-left-index">
                        <div class="main_left  d-flex flex-column aligin-items-start ">
                            <div class="Path-3-Copy-37"></div>
                            <div class="Enjoy-div1">
                               <p class="Enjoy-the-serenity-Copy">Enjoy the serenity, energy, and beauty of nature 365 days a year no matter what climate you live in.</p>
                            </div>
                            <div style="font-size: 17px">
                                <p class="Enjoy-your-outdoor-l"><?= $pageName[0]['short'] ?></p>
                            </div>
                        </div>
                        <div class="main_right" style="font-size: 17px">

                            <div class="Enjoy-div-2">
                                <p class="Enjoy-the-serenity"><?= $pageName[0]['text'] ?></p>
                            </div>
                            <a href="<?= Url::to(['site/about-us', 'page_slug' => 'about-us']) ?>">
                            <div class="contener">
                                <div class="txt_button">MORE</div>
                                <div class="circle">&nbsp;</div>
                            </div>
                            </a>
<!--                            <a style="margin-top: 30px;" href="--><?//= Url::to('about-us')?><!--" class="btn_more">More about company</a>-->
                        </div>
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

<div class="container-fluid main_center" >
    <div class="title">
        <div class="page_title_prd">
<!--            <div class="row">-->
                <div class="text-uppercase">
                    <h2 class="text-uppercase">OUR PRODUCTS</h2>
                </div>
<!--                <div class="col-lg-7 col-md-8">-->
<!--                    <h4 class="text-uppercase"> --><?//= $pageName['title'] ?><!--</h4>-->
<!--                    --><?//= $pageName['text'] ?>
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>

    <!--            --><?php //foreach ($productCategories as $key => $val): ?>
    <!---->
    <!--                <div class="col-md-6 project_item" data-id= --><?//= $val['order_num'] ?><!-->
    <!--                    <a href="--><?//= Url::to(['product-category/view', 'page_slug' => 'product', 'slug' => $val['slug'], 'id' => $val['id']]) ?><!--">-->
    <!--                        <img class="img-responsive" src="--><?//= yii::getAlias('@web') . $val['image'] ?><!--"-->
    <!--                             alt="--><?//= $val['title'] ?><!--">-->
    <!--                    </a>-->
    <!--                    <h1 class="text-left bg-white mb-0">-->
    <!--                        <a href="--><?//= Url::to(['product-category/view', 'page_slug' => 'product', 'slug' => $val['slug'], 'id' => $val['id']]) ?><!--">--><?//= $val['title'] ?><!--</a>-->
    <!--                    </h1>-->
    <!--                    <p>--><?//= $val['subtitle'] ?><!--</p>-->
    <!--                </div>-->
    <!---->
    <!--            --><?php //endforeach; ?>
    <div class="project">
        <div class="products">
            <?php foreach ($productCategories as $key => $val): ?>
                <div class="project-item" data-id= "<?= $val['order_num'] ?>">
                    <a href="<?= Url::to(['product-category/view', 'page_slug' => 'product', 'slug' => $val['slug'], 'id' => $val['id']]) ?>">
                    <div class="project-img" style="background-image: url('<?= yii::getAlias('@web') . $val['image'] ?>') ; background-size: cover; background-position: center;">
                            <img style="display: none" src="<?= yii::getAlias('@web') . $val['image'] ?>" alt="<?= $val['title'] ?>">
                    </div>
                        <div class="prj-info">
                            <a class="prj-text" href="<?= Url::to(['product-category/view', 'page_slug' => 'product', 'slug' => $val['slug'], 'id' => $val['id']]) ?>"><?= $val['title'] ?></a>
                            <p class="prj-title "><?= $val['subtitle'] ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>
<div class="container-fluid main_center">
    <div class="title">
        <div class="inquire">
            <div class="inquire-hr"></div>
            <p class="inquire-text"> Want to reach full potential of your outdoor space?</p>
            <a href="<?= Url::to(['/get-quote']) ?>">
                <div class="contener"  style="margin-top: 0px;margin-right: auto;margin-left: auto;margin-bottom: 20px">
                    <div class="txt_button">INQUIRE</div>
                    <div class="circle">&nbsp;</div>
                </div>
            </a>
            <div class="inquire-hr" style="bottom: 0"></div>
        </div>
    </div>
</div>
<div class="container-fluid main_center">
    <div class="title">
        <div class="inner_main_center mt-0 mb-0">
            <div class=" oddd_item d-flex flex-row" >
                <div class=" main_center d-flex flex-column aligin-items-start">
                    <div class="Path-3-Copy-36"></div>
                    <div class="Enjoy-div">
                        <p class="Enjoy-the-serenity-Copy">Enjoy the serenity, energy, and beauty of nature 365 days a year no matter what climate you live in.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="title">
        <div class="page_title_prd">
<!--            <div class="row">-->
                <div class=" text-uppercase">
                    <h2 class="text-uppercase">OUR PROJECTS</h2>
                </div>
<!--                <div class="col-lg-7 col-md-8">-->
<!--                    <h4 class="text-uppercase"> --><?//= $pageName['title'] ?><!--</h4>-->
<!--                    --><?//= $pageName['text'] ?>
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
    <!--Product-->
    <div class="project">
        <div  class="products ">
            <div class="contain-group prod-container ">
                <?php $iter = 1;
                foreach ($projects as $project): ?>
                <?php
                $count = count($projects);
                ?>
                <?php if ($iter == $count) {
                    $closer = '</div>';

                } else {
                    ($iter % 3 == 0) ? $closer = '</div><div class="prod-container contain-group ">' : $closer = '';
                } ?>
                <div class="product-item slider-for-prd aniimated-thumbnials" data-id= <?= $project['id'] ?> >
                    <?php
                    $project_id = $project['id'];
                    $projectUploads = ProjectUploads::getUploadsByParent($project_id);
                    $i = 0;
                    ?>
                    <?php foreach ($projectUploads as $upload): ?>
                    <a href="<?= yii::getAlias('@web') . $upload['image'] ?>" data-exthumbimage="<?= yii::getAlias('@web') . $upload['image'] ?>" class="<?= ($i == 0) ? 'd-block' : 'd-none' ?>">
                        <div class="product-item-single">
                            <div class="prdct-img" style="background-image: url('<?= ($upload['is_base'] == 1) ?  $upload['image'] : $upload['image'][0] ?>');background-size: cover;
                                        background-position: center">
<!--                            <img style="display: none" src="--><?//= yii::getAlias('@web') . $upload['image'] ?><!--" alt="--><?//= $project['title'] ?><!--">-->
                            </div>
                            <div class="prdct-info">
                                <p class="Louver-Aluminum-Stru"><?= $project['title'] ?></p>
                                <p class="Retractable-Motorize"><?= $project['subtitle'] ?></p>
                            </div>
                        </div>
                    </a>
                    <?php $i++; endforeach; ?>
                </div><?= $closer; ?>

                    <?php $iter++; endforeach; ?>
            </div>
<!--            <div class="product-item">-->
<!--                <div class="prdct-img">-->
<!--                    <img src="" alt="">-->
<!--                </div>-->
<!--                <div class="prdct-info">-->
<!--                    <div class="d-flex flex-row align-items-start">-->
<!--                        <p class="Resists-Bad-Weather-Copy">RESIST BAD WEATHER</p>-->
<!--                    </div>-->
<!--                    <p class="Louver-Aluminum-Stru">Louver Aluminum Structure</p>-->
<!--                    <p class="Retractable-Motorize">Retractable Motorized Awning PA160 is that is created for the ones </p>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="product-item">-->
<!--                <div class="prdct-img">-->
<!--                    <img src="" alt="">-->
<!--                </div>-->
<!--                <div class="prdct-info">-->
<!--                    <div class="d-flex flex-row align-items-start">-->
<!--                        <p class="Resists-Bad-Weather-Copy">RESIST BAD WEATHER</p>-->
<!--                    </div>-->
<!--                    <p class="Louver-Aluminum-Stru">Louver Aluminum Structure</p>-->
<!--                    <p class="Retractable-Motorize">Retractable Motorized Awning PA160 is that is created for the ones </p>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="product-item">-->
<!--                <div class="prdct-img">-->
<!--                    <img src="" alt="">-->
<!--                </div>-->
<!--                <div class="prdct-info">-->
<!--                    <div class="d-flex flex-row align-items-start">-->
<!--                        <p class="Resists-Bad-Weather-Copy">RESIST BAD WEATHER</p>-->
<!--                    </div>-->
<!--                    <p class="Louver-Aluminum-Stru">Louver Aluminum Structure</p>-->
<!--                    <p class="Retractable-Motorize">Retractable Motorized Awning PA160 is that is created for the ones </p>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="product-item">-->
<!--                <div class="prdct-img">-->
<!--                    <img src="" alt="">-->
<!--                </div>-->
<!--                <div class="prdct-info">-->
<!--                    <div class="d-flex flex-row align-items-start">-->
<!--                        <p class="Resists-Bad-Weather-Copy">RESIST BAD WEATHER</p>-->
<!--                    </div>-->
<!--                    <p class="Louver-Aluminum-Stru">Louver Aluminum Structure</p>-->
<!--                    <p class="Retractable-Motorize">Retractable Motorized Awning PA160 is that is created for the ones </p>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="product-item">-->
<!--                <div class="prdct-img">-->
<!--                    <img src="" alt="">-->
<!--                </div>-->
<!--                <div class="prdct-info">-->
<!--                    <div class="d-flex flex-row align-items-start">-->
<!--                        <p class="Resists-Bad-Weather-Copy">RESIST BAD WEATHER</p>-->
<!--                    </div>-->
<!--                    <p class="Louver-Aluminum-Stru">Louver Aluminum Structure</p>-->
<!--                    <p class="Retractable-Motorize">Retractable Motorized Awning PA160 is that is created for the ones </p>-->
<!--                </div>-->
<!--            </div>-->

        </div>
    </div>
    <?php
    $count = count(ProductCategory::getParentCategory());

    if ($count > ProductCategory::APPEND_CATEGORY_LIMIT): ?>
    <a href="<?= Url::to(['project/recidental']) ?>">
        <div class="contener"  style="margin-top: 0px;margin-right: auto;margin-left: auto;">
            <div class="txt_button">All PROJECTS</div>
            <div class="circle">&nbsp;</div>
        </div>
    </a>

    <?php endif; ?>
</div>
<div class="container-fluid main_center">
    <div class="title">
        <div class="inner_main_center" style="margin-top: 40px;">
            <div class=" oddd_item d-flex flex-row">
                <div class=" main_center d-flex flex-column aligin-items-start">
                    <div class="Path-3-Copy-36"></div>
                    <div class="Enjoy-div">
                        <p class="Enjoy-the-serenity-Copy">Enjoy the serenity, energy, and beauty of nature 365 days a year no matter what climate you live in.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="title">
        <div class="page_title_prd">
<!--            <div class="row">-->
                <div class="text-uppercase">
                    <h2 class="text-uppercase">OUR CUSTOMERS</h2>
                </div>
<!--                <div class="col-lg-7 col-md-8">-->
<!--                    <h4 class="text-uppercase"> --><?//= $pageName['title'] ?><!--</h4>-->
<!--                    --><?//= $pageName['text'] ?>
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
    <div class="videos">
        <div class="vproducts d-flex flex-row">
            <a href="#exampleModal">
                <div class="vproduct d-flex flex-column">
                    <div class="vproduct-bottom" data-toggle="modal" data-src="https://www.youtube.com/embed/o4wl8vz1z_U" data-target="#exampleModal">
                        <img style="width: 100%; height: 100%" src="/uploads/video/maxresdefault.jpg" alt="Claudia Amboss">
                        <i class="far fa-play-circle"></i>
                    </div>
                    <div style="width: 100%;" d-flex flex-column align-items-start pl-5>
                        <div class="d-flex flex-row align-items-start">
                            <p class="Roseville-New-York">Westchester / New York</p>
                        </div>
                        <div class="d-flex flex-row" >
                            <p class="David">Claudia Amboss</p>
                        </div>
                        <p class="Retractable-Motorize">I was a little skeptical ordering something like this online, but it is wonderful. It is well designed, manufactured and sturdy. </p><br>
                    </div>
                </div>
            </a>
            <a href="#exampleModal">
                <div class="vproduct d-flex flex-column">
                    <div class="vproduct-bottom" data-toggle="modal" data-src="https://www.youtube.com/embed/meFSjOYg1Lw" data-target="#exampleModal">
                        <img style="width: 100%; height: 100%" src="/uploads/video/ezgif.com-gif-maker.jpg" alt="Kenny Couillard">
                        <i class="far fa-play-circle"></i>
                    </div>
                    <div style="width: 100%;" d-flex flex-column align-items-start pl-5>
                        <div class="d-flex flex-row align-items-start">
                            <p class="Roseville-New-York">West Islip / New York</p>
                        </div>
                        <div class="d-flex flex-row" >
                            <p class="David" >Kenny Couillard</p>
                        </div>
                        <p class="Retractable-Motorize">This is great, it is railing and awning at the same time. We have an extra room when the weather gets rain. wind or buggy. I will definitely recommend it to friends, even other people who came to my house. </p><br>
                    </div>
                </div>
            </a>
            <a href="#exampleModal" >
                <div class="vproduct d-flex flex-column">
                    <div class="vproduct-bottom" data-toggle="modal" data-src="https://www.youtube.com/embed/mVpkoVrPQsI" data-target="#exampleModal">
                        <img style="width: 100%; height: 100%" src="/uploads/video/ezgif.com-gif-maker (2).jpg" alt="Jessica Bruna">
                        <i class="far fa-play-circle"></i>
                    </div>
                    <div style="width: 100%;" d-flex flex-column align-items-start pl-5>
                        <div class="d-flex flex-row align-items-start">
                            <p class="Roseville-New-York">Short Hills / New Jersey</p>
                        </div>
                        <div class="d-flex flex-row" >
                            <p class="David">Jessica Bruna</p>
                        </div>
                        <p class="Retractable-Motorize">It’s the right price for the product. I fell ut is well priced. Secondly, the flexibility with louvers you only get a partial opening with this, you get a full opportunity. Just the combination of how the lights are with the vinyl and how it looks when it’s fully open, it looks good.</p><br>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<div class="container-fluid main_bottom">
    <div class="main_bottom_inner">
        <div class="row bottom_inner__flex">
            <div class="col-lg-6 col-xs-6 clients">
                <h3>Happy clients</h3>
                <div class="clients_left"><img src="<?= yii::getAlias('@web') . '/app/media/img/arrow-black-left-svg.svg' ?>" alt="left arrow"></div>
                <div class="clients_right"><img src="<?= yii::getAlias('@web') . '/app/media/img/arrow-black-right-svg.svg' ?>" alt="right arrow"></div>
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
<br><br>
