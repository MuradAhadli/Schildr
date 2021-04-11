<?php

use yii\helpers\HtmlPurifier;

\app\assets\LightGalleryAsset::register($this);

$this->title = ($content['title']) ? $content['title'] : 'Video';

$ssl = [
    'ssl' => [
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ]
];
?>

<div class="" id="media">
    <section class="section-gray">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title"> <?= \yii\helpers\Html::encode($content['title']) ?> </h2>

                <div class="section-short">
                    <?= HtmlPurifier::process($content['text']) ?>
                </div>

            </div>
        </div>

        <div class="bordered-block">

            <?= $this->render('nav', [
                'active' => 'video'
            ]) ?>

            <?= $this->render('filter', [
                'cat_id' => $cat_id,
                'action' => 'video',
            ]) ?>

            <?php \yii\widgets\Pjax::begin([
                'timeout' => 5000,
            ]) ?>

            <div id="video-gallery">
                <div class="row">
                    <?php foreach ($models as $model): ?>
                        <a class="col-md-4 col-sm-6 col-12 video-image" href="https://www.youtube.com/watch?v=<?= $model['link'] ?>" >
                            <img src="https://img.youtube.com/vi/<?= $model['link'] ?>/0.jpg" />
                            <div class="title">
                                <?= $model['title'] ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>

                <?= \app\components\BootstrapLinkPager::widget([
                    'pagination' => $pages,

                ]);?>
            </div>

            <?php \yii\widgets\Pjax::end() ?>

            </div>
        </div>

    </section>
</div>