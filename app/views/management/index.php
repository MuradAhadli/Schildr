<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/12/2018
 * Time: 3:04 PM
 */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = 'Management';
?>

<div class="about-us management">
    <section class="section-gray">

        <div class="row">
            <div class="col-12">

                <?php if($text['short']): ?>
                    <h2 class="section-title page-title"><?= $text['title'] ?></h2>
                <?php endif; ?>

                <?php if($text['text']): ?>
                    <div class="section-short">
                        <?= $text['text'] ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <?php foreach ($models as $model): ?>
            <div class="row item">
                <div class="col-md-6 col-12">
                    <h2 class="section-title manager-name">
                        <?= Html::encode($model['username']) ?>

                        <div class="short">
                            <?= Html::encode($model['position']) ?>
                        </div>
                    </h2>

                    <div class="section-short d-none d-md-block">

                        <p>
                            <?= HtmlPurifier::process($model['short']) ?>
                        </p>
                    </div>

                    <a
                            href="<?= \yii\helpers\Url::to(['/management/view', 'page_slug' => 'management', 'id' => $model['id'], 'slug' => $model['slug']]) ?>"
                            class="btn btn-more btn-transparent btn-lg btn-transparent btn-border-glight d-none d-md-block d-xl-inline-block">
                        <?php echo Html::encode(yii::t('db', 'read more')) ?>
                    </a>
                </div>
                <div class="col-md-6 col-12">
                    <div class="img">
                        <img src=<?= yii::getAlias('@web') . $model['image'] ?>>
                    </div>

                    <div class="section-short d-block d-md-none">

                        <p>
                            <?= HtmlPurifier::process($model['short']) ?>
                        </p>
                    </div>

                    <a
                            href="<?= \yii\helpers\Url::to(['/management/view', 'page_slug' => 'management', 'id' => $model['id'], 'slug' => $model['slug']]) ?>"
                            class="btn btn-more btn-transparent btn-lg btn-transparent btn-border-glight d-block d-md-none">
                        <?php echo Html::encode(yii::t('db', 'read more')) ?>
                    </a>

                </div>
            </div>
        <?php endforeach; ?>

    </section>
</div>

