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
<ul style="display: none" class="langs langs-mobile list-inline justify-content-center d-md-flex">

    <?php foreach (Constants::getNavLangs() as $k => $v): VarDumper::dump($k, 10, 1); ?>

        <li class="list-inline-item float-left <?= (yii::$app->language == $v) ? 'active' : '' ?> ">
            <a href="<?= Url::to(array_merge([$parse_request[0]], $parse_request[1], ['language' => $k])) ?>"
               class="lang-link" data-lang="<?= $k ?>"> <?= $v ?> </a>
        </li>

    <?php endforeach; ?>

</ul>

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
                <img src="<?= yii::getAlias('@web') . '/app/media/img/logo.png' ?>" alt="Glass Construction">
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

        <!--Mini size menu icon-->
        <span class="open_menu">
            <i class="fas fa-bars"></i>
        </span>
        <!-- / Mini size menu icon-->

        <!--Mini size menu-->
        <div class="menu_mini">

            <div class="menu_mini_header">
                <input type="text" name="search" class="form-control search_input" placeholder="search">
                <span class="search_icon"><i class="fa fa-search"></i></span>
            </div>

            <ul>
                <li><a href="<?= Url::to(['site/about-us', 'page_slug' => 'about-us']) ?>">ABOUT US</a></li>
                <li>
                    <span>
                        PROJECTS
                        <span class="menu_arrow"><i class="fas fa-chevron-right"></i></span>
                    </span>
                    <ul>
                        <li><a href="<?= Url::to(['project/recidental']) ?>">recidential</a></li>
                        <li><a href="<?= Url::to(['project/commercial']) ?>">commercial</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?= Url::to(['product-category/index', 'page_slug' => 'product']) ?>">
                        PRODUCTS
                        <span class="menu_arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
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
            <i class="fas fa-share-alt"></i>
        </span>
        <div class="mini_social hidden font-16">
            <ul>
                <?php foreach ($social as $key => $val): ?>

                    <li><a href="<?= $val['link'] ?>"><i class="<?= $val['icon'] ?>" aria-hidden="true"></i></a></li>

                <?php endforeach; ?>
            </ul>
        </div>

        <!--language-->
        <div class="header_lang font-16">
            <ul>  <?php if (count($navLangs) > 0 ) :?>
                <?php foreach (Constants::getNavLangs() as $k => $v): ?>

                    <?php if (count($navLangs > 1)) : ?>

                        <?php else : return $navlang?>

                            <li class="<?= (yii::$app->language == $v) ? 'general-active' : '' ?> ">
                                <a href="<?= Url::to(array_merge([$parse_request[0]], $parse_request[1], ['language' => $k])) ?>"><?= $k ?></a>
                            </li>


                        <?php endif; ?>

                <?php endforeach; ?>
                    <?php  else :?>
                <?php endif; ?>
            </ul>
        </div>
        <!-- /language -->


        <!--Mini size language-->
<!--        <span class="open_lang">-->
<!--            <i class="fas fa-globe-americas"></i>-->
<!--        </span>-->
        <div class="mini_lang hidden font-16">
            <ul>
                <?php foreach (Constants::getNavLangs() as $k => $v): ?>

                    <?php if(count(Constants::getNavLangs()) > 1): ?>

                    <li class="<?= (yii::$app->language == $v) ? 'active' : '' ?> ">
                        <a href="<?= Url::to(array_merge([$parse_request[0]], $parse_request[1], ['language' => $k])) ?>"><?= $k ?></a>
                    </li>
                <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </header>
    <span id="scrollTop"><img src="<?= yii::getAlias('@web') . '/app/media/img/arrow-svg.svg' ?>" alt=""></span>
</div>