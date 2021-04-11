<?php
\app\assets\LightGalleryAsset::register($this);

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = ($content['title']) ? $content['title'] : 'Photo';

?>

<div class="" id="media">
    <section class="section-gray">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title"> <?= Html::encode($content['title']) ?> </h2>

                <div class="section-short">
                    <?= HtmlPurifier::process($content['text']) ?>
                </div>

            </div>
        </div>

        <div class="bordered-block">

            <?= $this->render('nav', [
                    'active' => 'photo'
            ]) ?>

            <?= $this->render('filter', [
                'cat_id' => $cat_id,
                'action' => 'photo',
            ]) ?>

            <?php \yii\widgets\Pjax::begin([
                    'timeout' => 5000,
            ]) ?>

            <div id="animated-thumbnails">
                <div class="row">
                <?php foreach ($models as $model): ?>
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="lightgallery-image" data-src="<?= yii::getAlias('@web') . $model['image'] ?>">
                                <img src=<?= yii::getAlias('@web') . $model['thumb'] ?> />
                                <div class="title">
                                    <?= Html::encode($model['title']) ?>
                                </div>
                            </div>
                        </div>
                <?php endforeach; ?>
                </div>
               <?php   echo \app\components\BootstrapLinkPager::widget([
                   'pagination' => $pages,

               ]);?>
            </div>

            <?php \yii\widgets\Pjax::end() ?>

        </div>

    </section>
</div>