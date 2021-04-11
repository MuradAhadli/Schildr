<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 5/3/2018
 * Time: 4:26 PM
 */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use \yii\helpers\Url;

$this->title = Html::encode($text['title']);

?>

<div class="departments-all news">
    <section class="section-gray">
        <div class="row">
            <div class="col-12">

                <?php if($text['short']): ?>
                    <h2 class="section-title"><?= Html::encode($text['title']) ?></h2>
                <?php endif; ?>

                <?php if($text['text']): ?>
                    <div class="section-short">
                        <?= HtmlPurifier::process($text['text']) ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <?php \yii\widgets\Pjax::begin([
            'timeout' => 3000,
        ]) ?>

        <div class="grid-view">
            <div class="row items">
                <?php foreach ($models as $model): ?>
                    <div class="col-lg-4 col-md-6">
                        <a href="<?= Url::to(['/news/view', 'page_slug' => 'news', 'id' => $model['id'], 'slug' => $model['slug']]) ?>" class="card box-shadow">
                            <div class="img">
                                <img src="<?= yii::getAlias('@web') . $model['image'] ?>">
                            </div>
                            <div class="card-body d-flex flex-column align-items-center align-items-md-stretch">
                                <div class="date">
                                    <?= date('d.m.Y', $model['time']) ?>
                                </div>
                                <h4 class="card-title"><?= Html::encode($model['title']) ?></h4>
                                <div class="list-styled-md list mb-4">
                                    <?= HtmlPurifier::process($model['short']) ?>
                                </div>

                                <button type="button" class="btn btn-more btn-block mt-auto txt-glight btn-transparent btn-lg btn-transparent btn-border-glight">

                                    <?= Html::encode(yii::t('db', 'read more')) ?>
                                </button>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php
            echo \app\components\BootstrapLinkPager::widget([
                'pagination' => $pagination,
            ]);
            ?>
        </div>

        <?php \yii\widgets\Pjax::end() ?>

    </section>
</div>


