<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/10/2018
 * Time: 1:56 PM
 */

use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = Html::encode($module['name']);

?>
<div class="doctor manager-in">
    <section class="section-gray">
        <div class="row">

            <div class="col-lg-4 col-md-5 col-12 pr-xl-4">
                <div class="short-info">

                    <h2 class="section-title d-block d-md-none manager-name">
                        <?= Html::encode($module['name']) ?>

                        <div class="short">
                            <?= HtmlPurifier::process($module['short']) ?>
                        </div>
                    </h2>

                    <div class="img">
                        <img class="w-100" src="<?= yii::getAlias('@web') . $module['image'] ?>">
                    </div>

                    <div class="info-items br-block br-g-light">
                        <a href="<?= Url::to(['/e-services/randevu', 'page_slug' => 'e-randevu', 'doctor_id' => $module['id'], 'doctor_slug' => $module['slug']]) ?>" class="btn btn-success btn-block">
                            <?= Html::encode(yii::t('db', 'get an appointment')) ?>
                        </a>

                        <div class="item">
                            <h5><?= Html::encode(yii::t('db', 'reception days')) ?></h5>
                            <ul class="list-unstyled m-0">
                                <?php foreach ($module['doctorWorkHours'] as $doctorWorkHours): ?>
                                    <li class="clearfix">
                                        <div class="float-left">

                                            <?php

                                            foreach (unserialize($doctorWorkHours['day']) as $day) {

                                                echo \app\components\Helpers::weekDays()['short'][$day - 1] . ' / ';
//                                                    echo strftime('%a', strtotime("Sunday + $day Days")) . '. / ';
                                            }

                                            ?>

                                        </div>
                                        <div class="float-right"><?= date('H:i',$doctorWorkHours['hour_from']) ?> - <?= date('H:i',$doctorWorkHours['hour_to']) ?></div>
                                    </li>
                             <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="item">
                            <h5><?= Html::encode(yii::t('db', 'email')) ?></h5>
                            <div><a href="mailto:<?= Html::encode($module['email']) ?>" class="doctor-email"><?= Html::encode($module['email']) ?></a></div>
                        </div>

                        <div class="item social">
                            <h5><?= Html::encode(yii::t('db', 'FOLLOW IN SOCIAL NETWORKS')) ?></h5>
                            <ul class="list-unstyled list-inline m-0">

                                <?php foreach (\app\components\Social::parseSocialLinks(unserialize($module['social'])) as $k => $v): ?>

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

            <div class="col-lg-8 col-md-7 col-12 pl-xl-4">
                <h2 class="section-title d-none d-md-block">
                    <?= Html::encode($module['name']) ?>

                    <div class="short">
                        <?= HtmlPurifier::process($module['short']) ?>
                    </div>
                </h2>

                <div class="text">
                    <?= HtmlPurifier::process($module['text']) ?>
                </div>

                <?= \app\widgets\Media\MediaWidget::widget([
                        'class_name' => 'yii\easyii\modules\doctor\models\Doctor',
                        'item_id' => yii::$app->request->get('id')
                    ]);
                ?>

            </div>
        </div>

    </section>
</div>


