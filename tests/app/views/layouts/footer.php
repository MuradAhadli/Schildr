<?php
/**
 * Created by PhpStorm.
 * User: Qulam Alisoy
 * Date: 3/17/2018
 * Time: 2:12 PM
 */

use yii\bootstrap\ActiveForm;
use yii\easyii\modules\productcategory\models\ProductCategory;
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
?>

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <div class="footer_logo">
                    <a href="<?= Url::to(['/']) ?>">
                        <img class="img-responsive"
                             src="<?= yii::getAlias('@web') . '/app/media/img/logo_footer.png' ?>"
                             alt="Glass Construction">
                    </a>
                </div>
                <div class="footer_content">
                    <p>2019 © GlassConstruction LLC</p>
                    <p>
                        <span>(800) 967-0991‬</span><br>
                        <span>info@glassconstruction.com</span><br>
                        <span>85 Broad St., Suite 28-36, New York, NY 10004</span>
                    </p>

                    Made in <a href="//idealand.az">O! idealand
                    </a>


                </div>
                <!--footer social links-->
                <div class="footer_social_links">
                    <ul>
                        <?php foreach ($social as $key => $val): ?>

                            <li><a href="<?= $val['link'] ?>"><i class="<?= $val['icon'] ?>" aria-hidden="true"></i></a>
                            </li>

                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-xs-8 hidden-768">
                <div class="row footer_links__inner">

                    <?php foreach ($footerLinks

                                   as $key => $val): ?>
                        <div class="col-sm-6 col-md-4 col-lg-3 footer_link_item">
                            <?php if ($val[0]['parent_id'] == 0): ?>
                                <a href="<?= $val[0]['url'] ?>">
                                    <h5><?= $val[0]['title'] ?></h5>
                                </a>
                                <a target="<?= $val[0]['target'] ?>"
                                   href=""></a>
                            <?php else:; ?>
                                <h5><?= $key; ?></h5>

                                <?php if ($key === 'PRODUCTS'): ?>

                                    <?php
                                    $helperLink = '';
                                    $productCategories = ProductCategory::getProductCategory(0);
                                    ?>
                                    <?php foreach ($productCategories as $category => $cat): ?>

                                        <?php
                                        $helperLink = '/' . yii::$app->language . '/product/' . $cat['id'] . '/';
                                        ?>
                                        <p><a target="<?= $item['current']; ?>"
                                              href="<?= $helperLink . $cat['slug'] ?>"><?= $cat['title'] ?></a></p>
                                    <?php endforeach; ?>
                                <?php else:; ?>
                                    <?php
                                    foreach ($val as $k => $item) {
                                        $helperLink = ''; ?>

                                        <p><a target="<?= $item['current'] ?>"
                                              href="<?= $helperLink . $item['url'] ?>"><?= $item['title'] ?></a></p>
                                    <?php } ?>

                                <?php endif; ?>
                            <?php endif; ?>

                        </div>

                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
</footer>