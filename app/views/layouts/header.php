<?php
/**
 * Created by PhpStorm.
 * User: Alisoy Qulam
 * Date: 3/17/2018
 * Time: 2:09 PM
 */

use yii\easyii\modules\productcategory\models\ProductCategory;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\easyii\models\Constants;
use app\models\Contacts;
use yii\helpers\Html;
use yii\easyii\models\User;
use yii\helpers\VarDumper;
use app\models\Social;

$nav = \app\models\Page::getNav();
$contacts = yii::$app->cache->get('contacts');
$social = Social::getSocial();
$productCategories = ProductCategory::getProductCategory(0);
$navLangs = Constants::getNavLangs();
$navlang = '';
/**
 * $parse_request[0] = route => 'media/photo'
 * $parse_request[2] = params =>  '[slug => about-us]'
 */
$parse_request = yii::$app->urlManager->parseRequest(yii::$app->request);


?>
<link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link href="https://kit-pro.fontawesome.com/releases/v5.15.3/css/pro.min.css" rel="stylesheet">

<!--<ul style="display: none" class="langs langs-mobile list-inline justify-content-center d-md-flex">-->
<!---->
<!--    --><?php //foreach (Constants::getNavLangs() as $k => $v): VarDumper::dump($k, 10, 1); ?>
<!---->
<!--        <li class="list-inline-item float-left --><?//= (yii::$app->language == $v) ? 'active' : '' ?><!-- ">-->
<!--            <a href="--><?//= Url::to(array_merge([$parse_request[0]], $parse_request[1], ['language' => $k])) ?><!--"-->
<!--               class="lang-link" data-lang="--><?//= $k ?><!--"> --><?//= $v ?><!-- </a>-->
<!--        </li>-->
<!---->
<!--    --><?php //endforeach; ?>
<!---->
<!--</ul>-->
<div class="container-fluid main_top">
    <!-- Header -->
    <header class="header">
        <!--header contact-->

        <div class="header_contact font-16">
            <span><?= yii::$app->params['sitePhone'] ?></span>
            <span> |&nbsp&nbsp <a href="mailto:<?= yii::$app->params['headerEmail'] ?>"><?= yii::$app->params['headerEmail'] ?></a></span>
        </div>


        <!-- /header contact -->

        <!--Logo for mobile-->
        <div class="logo-mobile">
            <a href="<?= Url::to(['/']) ?>">
                <img src="<?= yii::getAlias('@web') . '/app/media/img/logo.png' ?>" alt="Schildr Outdoor Systems">
            </a>
        </div>
        <!--/Logo for mobile-->

        <!--social-->

        <div class="header_social font-16">
            <ul>
                <?php foreach ($social as $key => $val): ?>

                    <li><a href="<?= $val['link'] ?>"><i class="<?= $val['icon'] ?>" aria-hidden="true"></i></a></li>

                <?php endforeach; ?>
            </ul>
        </div>
        <!-- /social -->


        <span class="open_menu">
            <i class="fal fa-bars"></i>
        </span>

        <div class="menu_mini">
            <ul>
                <li><a href="<?= Url::to(['site/about-us', 'page_slug' => 'about-us']) ?>">ABOUT US</a></li>
                <li>
                    <span>
                        PROJECTS
                        <span class="menu_arrow"><i class="fas fa-chevron-right"></i></span>
                    </span>
                    <ul>
                        <li><a href="<?= Url::to(['project/recidental']) ?>">RESIDENTIAL</a></li>
                        <li><a href="<?= Url::to(['project/commercial']) ?>">COMMERCIAL</a></li>
                    </ul>
                </li>
                <li>
                    <span>
                        PRODUCTS
                        <span class="menu_arrow"><i class="fas fa-chevron-right"></i></span>
                    </span>
                    <ul>
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
        <!-- / Mini size menu-->


        <!--Mini size social-->
        <span class="open_social">
            <a class="header_phone" href="tel:<?= yii::$app->params['sitePhone'] ?>"><?= yii::$app->params['sitePhone'] ?></a>
        </span>
<!--        <span class="open_social">-->
<!--            <i class="fas fa-share-alt"></i>-->
<!--        </span>-->
<!--        <div class="mini_social hidden font-16">-->
<!--            <ul>-->
<!--                --><?php //foreach ($social as $key => $val): ?>
<!---->
<!--                    <li><a href="--><?//= $val['link'] ?><!--"><i class="--><?//= $val['icon'] ?><!--" aria-hidden="true"></i></a></li>-->
<!---->
<!--                --><?php //endforeach; ?>
<!--            </ul>-->
<!--        </div>-->

        <!--language-->
<!--        <div class="header_lang font-16">-->
<!--            <ul>  --><?php //if (count($navLangs) > 0 ) :?>
<!--                --><?php //foreach (Constants::getNavLangs() as $k => $v): ?>
<!---->
<!--                    --><?php //if (count($navLangs > 1)) : ?>
<!---->
<!--                        --><?php //else : return $navlang?>
<!---->
<!--                            <li class="--><?//= (yii::$app->language == $v) ? 'general-active' : '' ?><!-- ">-->
<!--                                <a href="--><?//= Url::to(array_merge([$parse_request[0]], $parse_request[1], ['language' => $k])) ?><!--">--><?//= $k ?><!--</a>-->
<!--                            </li>-->
<!---->
<!---->
<!--                        --><?php //endif; ?>
<!---->
<!--                --><?php //endforeach; ?>
<!--                    --><?php // else :?>
<!--                --><?php //endif; ?>
<!--            </ul>-->
<!--        </div>-->
        <!-- /language -->


        <!--Mini size language-->
<!--        <span class="open_lang">-->
<!--            <i class="fas fa-globe-americas"></i>-->
<!--        </span>-->
<!--        <div class="mini_lang hidden font-16">-->
<!--            <ul>-->
<!--                --><?php //foreach (Constants::getNavLangs() as $k => $v): ?>
<!---->
<!--                    --><?php //if(count(Constants::getNavLangs()) > 1): ?>
<!---->
<!--                    <li class="--><?//= (yii::$app->language == $v) ? 'active' : '' ?><!-- ">-->
<!--                        <a href="--><?//= Url::to(array_merge([$parse_request[0]], $parse_request[1], ['language' => $k])) ?><!--">--><?//= $k ?><!--</a>-->
<!--                    </li>-->
<!--                --><?php //endif; ?>
<!--                --><?php //endforeach; ?>
<!--            </ul>-->
<!--        </div>-->
    </header>
    <span id="scrollTop"><img src="<?= yii::getAlias('@web') . '/app/media/img/arrow-svg.svg' ?>" alt=""></span>
</div>
