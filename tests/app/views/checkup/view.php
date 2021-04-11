<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/11/2018
 * Time: 5:09 PM
 */

use \yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = Html::encode($checkup_in['name']);

\kartik\select2\Select2Asset::register($this)->addLanguage(yii::$app->language, '', 'js/i18n');
\kartik\select2\ThemeKrajeeAsset::register($this);

$attr = $model->attributeLabels();

?>

<div class="doctor check-up in">
    <section class="section-gray">
        <div class="row">
            <div class="col-12 col-lg-4 col-md-5 pr-xl-4">

                <div class="checkup-select-list d-block d-md-none">
                    <select name="forma" onchange="location = this.value;" id="doctor_department_filter" class="custom-select2">
                        <option class="prompt" value="<?= Url::to(['/check-up']) ?>"><?= Html::encode(yii::t('db', 'Checkups')) ?></option>
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
                            <li <?=  ($checkup['id'] == yii::$app->request->get('id') ?  "class = 'active'" : '') ?>">
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
                        <?= Html::encode($checkup_in['name']) ?>
                    </div>
                </h2>

                <div class="text clearfix">
                    <?= HtmlPurifier::process($checkup_in['text']) ?>
                </div>

                <div class="examinations">

                    <div class="row">
                        <div class="col-12 col-md-5">
                            <div class="title">
                                <?= Html::encode(yii::t('db', 'composition of examination')) ?>
                            </div>
                        </div>
                        <div class="col-md-7 col-12 d-md-block d-none">
                            <?php if (!empty($checkup_in['price'])): ?>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="title">
                                            <?= Html::encode(yii::t('db', 'examination price')) ?>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="examination-price">
                                            <?php if($checkup_in['discount_price']){ ?>
                                                <div class="discounted-price-checkup">
                                                    <?= Html::encode($checkup_in['discount_price']) ?> AZN
                                                </div>
                                            <?php } ?>
                                            <div><?= Html::encode($checkup_in['price']) ?> AZN</div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div class="examination-list">
                        <ul class="list-unstyled row">
                            <?php foreach ($examinations as $examination): ?>
                                <li class="col-lg-6 col-12"><div><span class="link-text"><?= Html::encode($examination['name']) ?></span></div></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="exam-price-mobile d-md-none row">
                        <?php if (!empty($checkup_in['price'])): ?>
                            <div class="float-md-left title col-6">
                                <?= Html::encode(yii::t('db', 'examination price')) ?>
                            </div>
                            <div class="col-6">
                                <div class="float-md-right examination-price">
                                    <div class="discounted-price-checkup"><?= Html::encode($checkup_in['discount_price']) ?> AZN</div>
                                    <div><?= Html::encode($checkup_in['price']) ?> AZN</div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="checkup-form">
                        <h2 class="caption">
                            <?= Html::encode(yii::t('db', 'Feedback form for check-ups examination')) ?>
                        </h2>

                            <?php $form = ActiveForm::begin([
                                    'id' => 'checkup_form',
                                    'method' => 'POST',
                                    'action' => ['/checkup/form'],
                                    'options' => [
                                        'class' => 'consultation-form'
                                    ],
                                    'fieldConfig' => [
                                        'errorOptions' => [
                                            'class' => 'invalid-feedback'
                                        ],
                                        'enableLabel'=>false
                                    ]
                                ])
                            ?>

                            <div class="row mb-md-2">


                                <div class="col-12 col-lg-6">
                                    <?= $form->field($model, 'username')
                                        ->textInput([
                                            'value' => ($user) ?  $user->firstname.' '.$user->lastname : '',
                                            'placeholder' => Html::encode($attr['username']),
                                            'class' => 'form-control form-private',
                                            'disabled' => ($user) ? true : false,
                                            'data-attr' => 'firstname'
                                        ])
                                    ?>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <?= $form->field($model, 'birthday')
                                        ->widget(\yii\widgets\MaskedInput::className(),[
                                            'mask' => '9[9].9[9].9[9][9][9]',
                                            'options' => [
                                                'value' => ($user) ?  date('d.m.Y', $user->birthday) : '',
                                                'placeholder' => Html::encode($attr['birthday']),
                                                'class' => 'form-control form-private',
                                                'disabled' => ($user) ? true : false,
                                                'data-attr' => 'birthday',
                                            ]
                                        ])
                                    ?>
                                </div>
                            </div>

                            <div class="row mb-md-2">
                                <div class="col-12 col-lg-6">
                                    <?= $form->field($model, 'email')
                                        ->textInput([
                                            'value' => ($user) ?  $user->email : '',
                                            'placeholder' => Html::encode($attr['email']),
                                            'disabled' => ($user) ? true : false,
                                            'date-attr' => 'email'
                                        ])
                                    ?>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <?= $form->field($model, 'phone')
                                        ->widget(\yii\widgets\MaskedInput::className(),[
                                            'mask' => '(099) 999 99 99',
                                            'options' => [
                                                'value' => ($user) ?  $user->phone : '',
                                                'placeholder' => Html::encode($attr['phone']),
                                                'class' => 'form-control form-private',
                                                'disabled' => ($user) ? true : false,
                                                'data-attr' => 'phone'
                                            ]
                                        ])
                                    ?>
                                </div>
                            </div>

                            <div class="row mb-md-2">
                                <div class="col-12">
                                    <?= $form->field($model, 'text')
                                        ->textarea([
                                            'placeholder' => Html::encode($attr['text']),
                                            'rows' => 5
                                        ])
                                    ?>
                                </div>
                            </div>

                            <div class="row mt-md-4">
                                <div class="col-lg-6 col-12 over-x-hidden">
                                    <div class="float-left">
                                        <?= $form->field($model, 'reCaptcha')
                                            ->widget(\himiklab\yii2\recaptcha\ReCaptcha::className()) ?>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="float-lg-right">
                                        <button type="submit" class="btn btn-success m-0 w-100">
                                            <?= Html::encode(yii::t('db', 'Send')) ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                                <?= $form->field($model, 'checkup_id')->label(false)->hiddenInput(['value' => yii::$app->request->get('id')]) ?>

                            <?php ActiveForm::end() ?>

                    </div>
                </div>

            </div>
        </div>

        <?= \app\widgets\Media\MediaWidget::widget([
            'class_name' => 'yii\easyii\modules\checkup\models\CheckUp',
            'item_id' => yii::$app->request->get('id')
        ]) ?>

    </section>
</div>


<?= \app\widgets\UserVerify\UserVerifyWidget::widget([
    'form_id' => '#checkup_form',
    'phone_id' => '#checkupform-phone'
])
?>