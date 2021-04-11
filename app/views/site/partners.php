<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 5/3/2018
 * Time: 9:41 AM
 */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = Html::encode($text['title']);


?>

<div class="doctors-all partners">
    <section class="section-gray">
        <div class="row">
            <div class="col-12">

                <?php if ($text['short']): ?>
                    <h2 class="section-title"><?= Html::encode($text['title']) ?></h2>
                <?php endif; ?>

                <?php if ($text['text']): ?>
                    <div class="section-short">
                        <?= HtmlPurifier::process($text['text']) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="grid-view">
            <div class="row">
                <?php foreach ($partners as $model): ?>
                    <div class="col-lg-4 col-md-6">

                        <a href="<?= $model['link'] ?>" target="_blank" class="card box-shadow">

                            <div class="img"
                                 style="background-image: url('<?= yii::getAlias('@web') . $model['image'] ?>')">
                                <div class="overlay"></div>
                            </div>

                            <div class="card-body d-md-block d-flex flex-column">

                                <h4 class="card-title"><?= Html::encode($model['name']) ?></h4>
                                <button type="button"
                                        class="btn btn-more btn-block txt-glight btn-transparent btn-lg btn-transparent btn-border-glight">
                                    <?= Html::encode(yii::t('db', 'go to site')) ?>
                                </button>

                            </div>
                        </a>

                    </div>
                <?php endforeach; ?>
            </div>

        </div>

    </section>
</div>
