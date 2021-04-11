<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 3/23/2018
 * Time: 3:29 PM
 */

use \yii\helpers\Url;
use \yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = Html::encode($text['title']);

\kartik\select2\Select2Asset::register($this)->addLanguage(yii::$app->language, '', 'js/i18n');
\kartik\select2\ThemeKrajeeAsset::register($this);

?>

<div class="doctors-all" id="doctors_all">
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

        <div class="departments-filter">
            <div class="select row align-items-center">

                <div class="col-4 d-md-block d-none">
                    <label class="select-prompt"><?= Html::encode(yii::t('db', 'Select department')) ?>:</label>
                </div>

                <div class="col-12 col-md-8">
                    <select name="forma" onchange="location = this.value;" id="doctor_department_filter" class="custom-select2">
                        <option class="prompt" value="<?= Url::to(['doctors/index', 'page_slug' => 'doctors']) ?>"><?= Html::encode(yii::t('db', 'all departments')) ?></option>
                        <?php
                        foreach ($departments as $department):

                            (Yii::$app->request->get('category_id') == $department['id']) ? $selected = "selected" : $selected = "";
                            ?>

                            <option <?= $selected ?> value="<?= Url::to(['doctors/index', 'page_slug' => 'doctors', 'category_id' => $department['id'], 'slug' => $department['slug']]) ?>">
                                <?= Html::encode($department['name']) ?>
                            </option>

                        <?php endforeach; ?>
                    </select>
                </div>

            </div>
        </div>

        <div class="grid-view">

            <?php \yii\widgets\Pjax::begin([
                'timeout' => 3000,
            ]) ?>

            <div class="row items">
                <?php foreach ($models as $model): ?>
                    <div class="col-lg-4 col-md-6">
                        <a href="<?= Url::to(['/doctors/view', 'page_slug' => 'doctors', 'id' => $model['doc_id'], 'slug' => $model['slug']]) ?>" class="card box-shadow flex-row flex-md-column">
                            <div class="img">
                                <img src="<?= yii::getAlias('@web') . $model['image'] ?>">
                            </div>
                            <div class="card-body d-flex flex-column align-items-center align-items-md-stretch">
                                <h4 class="card-title"><?= Html::encode($model['name']) ?></h4>
                                <div class="card-short"><?= Html::encode($model['position']) ?></div>
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
                'pagination' => $pages,
            ]);
            ?>

        </div>

        <?php \yii\widgets\Pjax::end() ?>

    </section>
</div>

