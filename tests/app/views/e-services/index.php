<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/12/2018
 * Time: 6:17 PM
 */
?>

<div class="doctors-all e-services">
    <section class="section-gray">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">
                    <?= \yii\helpers\Html::encode($text['title']) ?>
                </h2>

                <div class="section-short">
                    <?= HtmlPurifier::process($text['text']) ?>
                </div>
            </div>
        </div>

        <div class="grid-view">

            <div class="row">

                <div class="col-md-4">
                    <a href="#" class="card box-shadow">
                        <div class="img" style="background-image: url('/app/media/img/es1.png')"></div>
                        <div class="card-body">
                            <h4 class="card-title">E-RANDEVU</h4>
                            <button type="button" class="btn btn-more btn-block txt-glight btn-transparent btn-lg btn-transparent btn-border-glight"><?= yii::t('db', 'davam et') ?></button>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="#" class="card box-shadow">
                        <div class="img" style="background-image: url('/app/media/img/es1.png')"></div>
                        <div class="card-body">
                            <h4 class="card-title">E-RANDEVU</h4>
                            <button type="button" class="btn btn-more btn-block txt-glight btn-transparent btn-lg btn-transparent btn-border-glight"><?= yii::t('db', 'davam et') ?></button>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="#" class="card box-shadow">
                        <div class="img" style="background-image: url('/app/media/img/es1.png')"></div>
                        <div class="card-body">
                            <h4 class="card-title">E-RANDEVU</h4>
                            <button type="button" class="btn btn-more btn-block txt-glight btn-transparent btn-lg btn-transparent btn-border-glight"><?= yii::t('db', 'davam et') ?></button>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="#" class="card box-shadow">
                        <div class="img" style="background-image: url('/app/media/img/es1.png')"></div>
                        <div class="card-body">
                            <h4 class="card-title">E-RANDEVU</h4>
                            <button type="button" class="btn btn-more btn-block txt-glight btn-transparent btn-lg btn-transparent btn-border-glight"><?= yii::t('db', 'davam et') ?></button>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="#" class="card box-shadow">
                        <div class="img" style="background-image: url('/app/media/img/es1.png')"></div>
                        <div class="card-body">
                            <h4 class="card-title">E-RANDEVU</h4>
                            <button type="button" class="btn btn-more btn-block txt-glight btn-transparent btn-lg btn-transparent btn-border-glight"><?= yii::t('db', 'davam et') ?></button>
                        </div>
                    </a>
                </div>

            </div>

        </div>

    </section>
</div>
