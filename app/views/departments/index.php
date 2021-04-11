<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 3/24/2018
 * Time: 10:54 AM
 */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use \yii\helpers\Url;

$this->title = Html::encode($text['title']);

?>

<div class="departments-all" id="departments_all">
    <section class="section-gray">
        <div class="row">
            <div class="col-12">

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
                        <a href="<?= Url::to(['/departments/view', 'page_slug' => 'departments', 'id' => $model['id'], 'slug' => $model['slug']]) ?>" class="card box-shadow">
                            <div class="img">
                                <img src="<?= yii::getAlias('@web') . $model['image'] ?>">
                            </div>
                            <div class="card-body d-flex flex-column">

                                <h4 class="card-title">
                                    <?= Html::encode($model['name']) ?>
                                </h4>

                                <div class="list-styled-md list mb-3">
                                    <?= HtmlPurifier::process($model['short']) ?>
                                </div>

                                <button type="button" class="mt-auto btn btn-more btn-block txt-glight btn-transparent btn-lg btn-transparent btn-border-glight">
                                    <?= Html::encode(yii::t('db', 'read more')) ?>
                                </button>

                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-4 m-0">
                    <?= \app\components\BootstrapLinkPager::widget([
                        'pagination' => $pages
                    ]);
                    ?>
                </div>
            </div>

        </div>

        <?php \yii\widgets\Pjax::end() ?>

    </section>
</div>


