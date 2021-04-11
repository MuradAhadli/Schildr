<!--top-->
<?php

use yii\easyii\modules\project\models\ProjectUploads;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\models\Page;
use yii\helpers\VarDumper;
use yii\easyii\modules\projectcategory\models\ProjectCategory;

$type = \app\controllers\ProjectController::RECIDENTAL_TYPE;
$recidentalTitle = array_keys($recidental[$type])[0];
$recidentalDesc = array_values($recidental[$type][$recidentalTitle])[0]['parent_category_description'];


$controller = yii::$app->controller->id;
$action = yii::$app->controller->action->id;
$pageName = Page::getParentNav(yii::$app->request->get('page_slug'));

$url = yii::$app->request->getUrl();
$urlArr = explode('/', $url);

$categoryName = end($urlArr);
$category = explode('/', $url);
$recidentalForRightZone = $recidentalForRightZone[$type][$recidentalTitle];

$site = yii::$app->request->getHostName();
$recidentalName = ProjectCategory::getAllProjectCategory();
$recidentaltitle = explode(' ', $recidentalName[1]['title']);

$this->title = $recidentaltitle[0] . " - Schildr Outdoor Solutions, New Jersey ";
$data = ProjectCategory::getAllProjectsByCategory(ProjectCategory::RECIDENTAL_TYPE);
$projects = $data[$type][$recidentalTitle];
?>
<link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
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
<!---->
<!--                </ul>-->
<!--            </div>-->
<!---->
<!--        </div>-->
<!--        <div class="contact-menu">-->
<!--            <p class="menu-text">MENU</p>-->
<!--        </div>-->
<!--        <div class="contact-x" style="margin-left: 15px">-->
<!--            <div class="contact-parts">-->
<!--                <div class="contact-part">-->
<!--                    <a href="--><?//= Url::to(['site/about-us', 'page_slug' => 'about-us']) ?><!--">ABOUT US</a>-->
<!--                </div>-->
<!--                <div class="contact-part" id="project-menu">-->
<!--                    <span class="span">PROJECTS-->
<!--                        <span class="show_sub_menu arr" style="padding-right: 15px;padding-left: 15px"><i class="fas fa-chevron-right "></i></span>-->
<!--                    </span>-->
<!--                </div>-->
<!--                <div class="sub-prj">-->
<!--                    <a href="--><?//= Url::to(['project/recidental']) ?><!--">RESIDENTIAL</a>-->
<!--                </div>-->
<!--                <div class="sub-prj">-->
<!--                    <a href="--><?//= Url::to(['project/commercial']) ?><!--">COMMERCIAL</a>-->
<!--                </div>-->
<!--                <div class="contact-part">-->
<!--                    <a href="--><?//= Url::to(['product-category/index', 'page_slug' => 'product']) ?><!--" class="span">-->
<!--                        PRODUCTS-->
<!--                        <span class="show_sub_menu arr" id="product-menu" style="padding-left: 15px;padding-right: 15px;"><i class="fas fa-chevron-right"></i></span>-->
<!--                    </a>-->
<!--                </div>-->
<!--                --><?php //foreach ($productCategories as $k => $v): ?>
<!--                    <div class="sub-prd">-->
<!--                        <a href="--><?//= Url::to(['product-category/view', 'page_slug' => 'product', 'slug' => $v['slug'], 'id' => $v['id']]) ?><!--">--><?//= $v['title'] ?><!--</a>-->
<!--                    </div>-->
<!--                --><?php //endforeach; ?>
<!--                <div class="contact-part">-->
<!--                    <a href="--><?//= Url::to(['site/contact', 'page_slug' => 'contact']) ?><!--">CONTACTS</a>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->


        <!-- / Main page left menu-->

        <div class="carousel_right_zone">
            <div class="carousel_right_zone_inner">
                <h2 class="text-uppercase"><?= yii::t('db', 'Projects') ?></h2>
                <p class="text-uppercase"><?= yii::t('db', 'Recidential') ?></p>
            </div>
            <div class="solid_item">
            </div>
            <div class="carousel_right_zone_inner">
                <ul>
                    <?php foreach ($recidentalForRightZone as $key => $val): ?>
                        <li><?= $val['title'] ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <span class="open_right">
                <i class="fa fa-angle-right"></i>
            </span>
        </div>

        <div class="logo">
            <a href="<?= Url::to(['/']) ?>">
                <img src="<?= yii::getAlias('@web') . '/app/media/img/logo_footer.png' ?> " alt="Schildr - Logo">
            </a>
        </div>
        <?php if (count($carousel) > 1): ?>
            <div class="slick-arrows-helper">
                <button id="prev"></button>
                <button id="next"></button>
            </div>
            <div class="bread-div">
                <div class="bread-bottom"><span disabled></span> <h1> Projects we have done</h1></div>
            </div>            <div class="slide">
                <?php foreach ($carousel as $key => $val): ?>
                    <div class="slide-element"
                         style=" background-image: linear-gradient(to bottom, #000000 -24%, #ffffff00 35%),url(<?= yii::getAlias('@web') . $val['file_name'] ?>)">
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bread-div">
                <div class="bread-bottom"><span disabled></span> <h1> Projects we have done</h1></div>
            </div>
            <div class="bg_top"
                 style="background-image: linear-gradient(to bottom, #000000 -24%, #ffffff00 35%), url(<?= yii::getAlias('@web') . $carousel[0]['file_name'] ?>)">
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

<div class="container-fluid main_center" >
    <div class="inner_main_center mt-0 pb-415-0">
        <!--page breadCrumb-->
            <!--Page Title-->
            <div class="page_titles pb-0 pl_992_0" style="padding: 0;">
                <div class="bread">
                    <div class="_bread_crumb_other_page ">
                        <?= Breadcrumbs::widget([
                            'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
                            'links' => [
                                [
                                    'label' => $category[2],
                                    'url' => ['project/index', 'page_slug' => 'projects'],
                                ],
                                [
                                    'label' => $categoryName,
                                ],
                            ],

                        ]); ?>
                    </div>
                </div>
                <div class="main_center">
                    <div class="col-md-4 text-uppercase" style="border-top: 1px solid #7396ae;  padding-left: 0;">
                        <h1 class="text-uppercase" style="font-size: 45.7px; font-family: 'Barlow', sans-serif; font-weight: normal; color: #232323; margin-top: 30px;"><?= yii::t('db', 'OUR PROJECTS') ?></h1>
                    </div>
                    <div class="col-lg-7 col-md-8 recidental_text" style="padding-right: 0;">
                        <h4 class="text-uppercase">
                            <?= $recidentalTitle ?>
                        </h4>
                        <p>
                            <?= $recidentalDesc ?>
                        </p>
                    </div>
                </div>
            </div>
        <!--Page main content-->
        <!--Project-->
<!--        <div class="project project_org border_1" style="margin-top: 220px;">-->
<!--            <div id="lightgallery">-->
<!--                <div class="main_center d-flex light-main">-->
<!--                    --><?php //$iter = 1;
//                    foreach ($projects as $project): ?>
<!--                        --><?php
//                        $count = count($projects);
//                        ?>
<!--                        --><?php //if ($iter == $count) {
//                            $closer = '</div>';
//
//                        } else {
//                            ($iter % 2 == 0) ? $closer = '</div><div class="main_center d-flex light-main">' : $closer = '';
//                        } ?>
<!---->
<!--                    <div class="project_item" data-id="--><?//= $project['id'] ?><!--">-->
<!---->
<!--                        --><?php
//                        $project_id = $project['id'];
//                        $projectUploads = ProjectUploads::getUploadsByParent($project_id);
//                        $i = 0;
//                        ?>
<!---->
<!--                        --><?php //foreach ($projectUploads as $upload): ?>
<!--                            <a href="--><?//= yii::getAlias('@web') . $upload['image'] ?><!--"-->
<!--                               class="--><?//= ($i == 0) ? 'd-block' : 'd-none' ?><!--">-->
<!--                                <div class="project-image">-->
<!--                                    <img class="img-responsive" src="--><?//= yii::getAlias('@web') . $upload['image'] ?><!--" alt="--><?//= $project['title'] ?><!--">-->
<!--                                </div>-->
<!--                                <div class="project_foot">-->
<!--                                    <div class="project_foot_left">-->
<!--                                        <p class="Louver-Aluminum-Stru">--><?//= $project['title'] ?><!--</p>-->
<!--                                        <p class="Retractable-Motorize">--><?//= $project['subtitle'] ?><!--</p>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </a>-->
<!---->
<!--                            --><?php //$i++; endforeach; ?>
<!---->
<!--                        </div>--><?//= $closer; ?>
<!--                        --><?php //$iter++; endforeach; ?>
<!--                </div>-->
<!--             --><?php ////if ((count($data[2]['Residential Projects'])) > 6) : ?>
<!---->
<!--                 <button class="load_more" id="load_more">LOAD MORE</button>-->
<!---->
<!--               --><?php ////endif; ?>
<!--            </div>-->
<!---->
<!--            #Page main content-->
<!--        </div>-->

        <div class="container-fluid">
            <?= $pageName['text'] ?>
        </div>
    </div>
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
                        <a data-exthumbimage="<?= yii::getAlias('@web') . $upload['image'] ?>" href="<?= yii::getAlias('@web') . $upload['image'] ?>" class="<?= ($i == 0) ? 'd-block' : 'd-none' ?>">
                            <div class="product-item-single">
                                <div class="prdct-img">
                                    <img src="<?= yii::getAlias('@web') . $upload['image'] ?>" alt="<?= $project['title'] ?>">
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
        </div>
    </div>
    <!--Our partners-->
<!--    <div class="container-fluid main_center">-->
<!--        <div class="inner_main_center">-->
<!--            <h1 class="section_title mt-30 for_partners">Our Partners</h1>-->
<!--            <div class="partners_inner">-->
<!--                <div class="item-helper-small">-->
<!--                    <div class="col-xs-2 partners_item">-->
<!--                        <a href="javascript:void(0)">-->
<!--                            <img src="--><?//= yii::getAlias('@web') . '/app/media/img/partners/aluminuimm.jpg' ?><!--">-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="item-helper-small">-->
<!--                    <div class="col-xs-2 partners_item">-->
<!--                        <a href="javascript:void(0)">-->
<!--                            <img src="--><?//= yii::getAlias('@web') . '/app/media/img/partners/dormaa.jpg' ?><!--">-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="item-helper-small">-->
<!--                    <div class="col-xs-2 partners_item">-->
<!--                        <a href="javascript:void(0)">-->
<!--                            <img src="--><?//= yii::getAlias('@web') . '/app/media/img/partners/C9E7E15A-120A-44C4-BA19-B53239D5E016.png' ?><!--">-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="item-helper-small">-->
<!--                    <div class="col-xs-2 partners_item">-->
<!--                        <a href="javascript:void(0)">-->
<!--                            <img src="--><?//= yii::getAlias('@web') . '/app/media/img/partners/Gezee.jpg' ?><!--">-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="item-helper-small">-->
<!--                    <div class="col-xs-2 partners_item">-->
<!--                        <a href="javascript:void(0)">-->
<!--                            <img src="--><?//= yii::getAlias('@web') . '/app/media/img/partners/guardiann.jpg' ?><!--">-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="item-helper-small">-->
<!--                    <div class="col-xs-2 partners_item">-->
<!--                        <a href="javascript:void(0)">-->
<!--                            <img src="--><?//= yii::getAlias('@web') . '/app/media/img/partners/pbb.jpg' ?><!--">-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="item-helper-small">-->
<!--                    <div class="col-xs-2 partners_item">-->
<!--                        <a href="javascript:void(0)">-->
<!--                            <img src="--><?//= yii::getAlias('@web') . '/app/media/img/partners/schuco.png' ?><!--">-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="item-helper-small">-->
<!--                    <div class="col-xs-2 partners_item">-->
<!--                        <a href="javascript:void(0)">-->
<!--                            <img src="--><?//= yii::getAlias('@web') . '/app/media/img/partners/starwoodd.png' ?><!--">-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

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
                                        <img src="<?= yii::getAlias('@web') . $client['image'] ?>">
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