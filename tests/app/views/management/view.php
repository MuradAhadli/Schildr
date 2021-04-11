<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/10/2018
 * Time: 1:56 PM
 */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = Html::encode($model['username']);

?>
<div class="doctor manager-in">
    <section class="section-gray">

        <div class="row">
            <div class="col-12">

                <?php if($content['title']): ?>
                    <h2 class="section-title page-title"><?= Html::encode($content['title']) ?></h2>
                <?php endif; ?>

            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-12 pr-lg-4">
                <div class="short-info">

                    <h2 class="section-title d-block d-lg-none manager-name">
                        <?= Html::encode($model['username']) ?>

                        <div class="short">
                            <?= Html::encode($model['position']) ?>
                        </div>
                    </h2>

                    <div class="img">
                        <img class="w-100" src="<?= yii::getAlias('@web') . $model['image'] ?>">
                    </div>

                    <div class="info-items br-block br-g-light">

                        <div class="item">
                            <h5><?= Html::encode(yii::t('db', 'email')) ?></h5>
                            <div><a href="mailto:<?= Html::encode($model['email']) ?>" class="doctor-email"><?= Html::encode($model['email']) ?></a></div>
                        </div>

                        <div class="item social">
                            <h5><?= Html::encode(yii::t('db', 'FOLLOW IN SOCIAL NETWORKS')) ?></h5>
                            <ul class="list-unstyled list-inline m-0">

                                <?php foreach (\app\components\Social::parseSocialLinks(unserialize($model['social'])) as $k => $v): ?>

                                    <li class="list-inline-item">
                                        <a href="<?= $v['url'] ?>" target="_blank">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <?= $v['icon'] ?>
                                            </div>
                                        </a>
                                    </li>

                                <?php endforeach; ?>

                            </ul>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-12 pl-lg-4">
                <h2 class="section-title d-none d-lg-block">
                    <?= Html::encode($model['username']) ?>

                    <div class="short">
                        <?= Html::encode($model['position']) ?>
                    </div>
                </h2>

                <div class="text">
                    <?= HtmlPurifier::process($model['text']) ?>
                </div>
            </div>
        </div>

    </section>
</div>

