<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/11/2018
 * Time: 5:09 PM
 */

use \yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = \yii\helpers\Html::encode($text['title']);

\kartik\select2\Select2Asset::register($this)->addLanguage(yii::$app->language, '', 'js/i18n');
\kartik\select2\ThemeKrajeeAsset::register($this);

?>

<div class="doctor check-up">
    <section class="section-gray">
        <div class="row">
            <div class="col-12 col-lg-4 col-md-5 pr-xl-4">

                <div class="checkup-select-list d-block d-md-none">
                    <select name="forma" onchange="location = this.value;" id="doctor_department_filter" class="custom-select2">
                        <option class="prompt" value="<?= Url::to(['doctors/index', 'page_slug' => 'doctors']) ?>"><?= Html::encode(yii::t('db', 'Checkups')) ?></option>
                        <?php
                        foreach ($checkups as $checkup):

                            (Yii::$app->request->get('id') == $checkup['id']) ? $selected = "selected" : $selected = "";
                            ?>

                            <option <?= $selected ?> value="<?= Url::to(['/checkup/view', 'page_slug' => 'check-up', 'id' => $checkup['id'], 'slug' => $checkup['slug']]) ?>">
                                <?= Html::encode($checkup['name']) ?>
                            </option>

                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="info-items check-up-list d-md-block d-none">
                    <div class="title">
                        <?= Html::encode(yii::t('db', 'Checkups')) ?>
                    </div>

                    <ul class="list-unstyled items">
                        <?php foreach ($checkups as $checkup): ?>
                            <li>
                                <a
                                        href="<?= Url::to(['/checkup/view', 'page_slug' => 'check-up', 'id' => $checkup['id'], 'slug' => $checkup['slug']]) ?>">
                                    <?= $checkup['name'] ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </div>

            <div class="col-12 col-lg-8 col-md-7 pl-xl-4">
                <h2 class="section-title d-none d-md-block">

                    <div class="short m-0">
                        <?= HtmlPurifier::process($text['short']) ?>
                    </div>
                </h2>

                <div class="text">
                    <?= HtmlPurifier::process($text['text']) ?>
                </div>
            </div>
        </div>

        <?= \app\widgets\Media\MediaWidget::widget([
            'class_name' => 'yii\easyii\modules\page\models\Page',
            'item_id' => yii::$app->session->get('page_id')
        ])
        ?>

    </section>
</div>


