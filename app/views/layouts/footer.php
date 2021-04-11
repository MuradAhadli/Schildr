<?php
/**
 * Created by PhpStorm.
 * User: Qulam Alisoy
 * Date: 3/17/2018
 * Time: 2:12 PM
 */

use yii\bootstrap\ActiveForm;
use yii\easyii\modules\productcategory\models\ProductCategory;
use yii\easyii\modules\page\models\Page;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Contacts;

$session = yii::$app->session;

echo \yii2mod\alert\Alert::widget([
    'timer' => '60000',
    'useSessionFlash' => true,
    'options' => [
        'button' => yii::t('db', 'Ok'),
    ]
]);

?>

<?php

$social = \app\models\Social::getSocial();
$footerLinks = \app\models\FooterLink::getLinks();
$productCategories = ProductCategory::getProductCategory(0);
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<!--<script data-search-pseudo-elements defer src="https://use.fontawesome.com/releases/latest/js/all.js" integrity="sha384-L469/ELG4Bg9sDQbl0hvjMq8pOcqFgkSpwhwnslzvVVGpDjYJ6wJJyYjvG3u8XW7" crossorigin="anonymous"></script>-->
<footer>
    <div class="footer">
        <div class="container-fluid d-flex justify-content-center">
            <div class="columns">
                <div class="columnn">
                    <h3 data-deg="0"  class="ml-3">Products <i class="fas fa-chevron-down"></i></h3>
                    <ul>
                        <?php foreach ($productCategories as $k => $v): ?>
                            <li>
                                <a href="<?= Url::to(['product-category/view', 'page_slug' => 'product', 'slug' => $v['slug'], 'id' => $v['id']]) ?>"><?= $v['title'] ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="columnn">
                    <h3 data-deg="0"  class="ml-3">Projects <i class="fas fa-chevron-down"></i></h3>
                    <ul>
                        <li><a href="<?= Url::to(['project/commercial']) ?>">Commercial</a></li>
                        <li><a href="<?= Url::to(['project/recidental']) ?>">Recidential</a></li>
                    </ul>
                </div>
                <div class="columnn">
                    <h3 data-deg="0"  class="ml-3">Services <i class="fas fa-chevron-down"></i></h3>
                    <ul>
                        <li><a href="/contact">Contact us</a></li>
                        <li><a href="/become-a-dealer">Become a dealer</a></li>
                        <li><a href="/get-quote">Get Quote</a></li>
                    </ul>
                </div>
                <div class="columnn ">
                    <h3 data-deg="0"  class="ml-3">Further Areas <i class="fas fa-chevron-down"></i></h3>
                    <ul>
                        <li><a href="/blog">Blog</a></li>
                        <li><a href="/static/61">Cooperation with partners</a></li>
                        <li><a href="/static/62">For designers and architects</a></li>
                        <li><a href="/static/63">For construction companies</a></li>
                        <li><a href="/static/65">Structures</a></li>
                        <li><a href="/static/64">Fabric selection</a></li>
                        <li><a href="/static/66">Partners area</a></li>
                    </ul>
                    <div class="footer_social_links">
                        <p>Social Media</p>
                        <ul>
                            <?php foreach ($social as $key => $val): ?>

                                <li ><a href="<?= $val['link'] ?>"><i style="color: #444444;" class="<?= $val['icon'] ?>" aria-hidden="true"></i></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container-fluid d-flex justify-content-center">
            <div class="columns-bottom">
                <div class="cpyrght">
                    <p class="copyright">© 2021 Schildr Inc. New Jersey</p>
                </div>
                <div class="footer-nav">
                    <ul>
                        <li><a href="">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>





















<!--<div class="footer_content">-->
<!--    <p>2019 © GlassConstruction LLC</p>-->
<!--    <p>-->
<!--        <span>(800) 967-0991‬</span><br>-->
<!--        <span>info@glassconstruction.com</span><br>-->
<!--        <span>85 Broad St., Suite 28-36, New York, NY 10004</span>-->
<!--    </p>-->
<!---->
<!--    Made in <a href="//idealand.az">O! idealand-->
<!--    </a>-->
<!---->
<!---->
<!--</div>-->
<!--footer social links-->










<!--<div class="col-xs-8 hidden-768">-->
<!--    <div class="row footer_links__inner">-->

<!--        --><?php //foreach ($footerLinks
//
//                       as $key => $val): ?>
<!--            <div class="col-sm-6 col-md-4 col-lg-3 footer_link_item">-->
<!--                --><?php //if ($val[0]['parent_id'] == 0): ?>
<!--                    <a href="--><?//= $val[0]['url'] ?><!--">-->
<!--                        <h5>--><?//= $val[0]['title'] ?><!--</h5>-->
<!--                    </a>-->
<!--                    <a target="--><?//= $val[0]['target'] ?><!--"-->
<!--                       href=""></a>-->
<!--                --><?php //else:; ?>
<!--                    <h5>--><?//= $key; ?><!--</h5>-->
<!---->
<!--                    --><?php //if ($key === 'PRODUCTS'): ?>
<!---->
<!--                        --><?php
//                        $helperLink = '';
//                        $productCategories = ProductCategory::getProductCategory(0);
//                        ?>
<!--                        --><?php //foreach ($productCategories as $category => $cat): ?>
<!---->
<!--                            --><?php
//                            $helperLink = '/' . yii::$app->language . '/product/' . $cat['id'] . '/';
//                            ?>
<!--                            <p><a target="--><?//= $item['current']; ?><!--"-->
<!--                                  href="--><?//= $helperLink . $cat['slug'] ?><!--">--><?//= $cat['title'] ?><!--</a></p>-->
<!--                        --><?php //endforeach; ?>
<!--                    --><?php //else:; ?>
<!--                        --><?php
//                        foreach ($val as $k => $item) {
//                            $helperLink = ''; ?>
<!---->
<!--                            <p><a target="--><?//= $item['current'] ?><!--"-->
<!--                                  href="--><?//= $helperLink . $item['url'] ?><!--">--><?//= $item['title'] ?><!--</a></p>-->
<!--                        --><?php //} ?>
<!---->
<!--                    --><?php //endif; ?>
<!--                --><?php //endif; ?>
<!---->
<!--            </div>-->
<!---->
<!--        --><?php //endforeach; ?>
<!---->
<!--    </div>-->
<!--</div>-->