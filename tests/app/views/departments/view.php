<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/10/2018
 * Time: 1:56 PM
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = $model['detail_name'];
$attr = $model_form->attributeLabels();

\kartik\select2\Select2Asset::register($this)->addLanguage(yii::$app->language, '', 'js/i18n');
\kartik\select2\ThemeKrajeeAsset::register($this);

?>
<div class="doctor department">
    <section class="section-gray">
        <div class="row flex-column-reverse flex-md-row">
            <div class="col-lg-4 col-md-5 pr-xl-4">
                <div class="short-info">

                    <div class="info-items br-block br-g-light">

                        <div class="item">
                            <h5><?= Html::encode(yii::t('db', 'doctors of department')) ?></h5>
                            <ul class="list-unstyled m-0">
                                <?php foreach ($doctors as $doctor): ?>
                                    <li>
                                        <a
                                                class="txt-underline"
                                                href="<?= \yii\helpers\Url::to(['/doctors/view', 'page_slug' => 'doctors', 'id' => $doctor['id'], 'slug' => $doctor['slug']]) ?>">
                                            <?= $doctor['name'] ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="item">

                            <h5><?= Html::encode(yii::t('db', 'contact with department')) ?></h5>

                            <ul class="list-unstyled m-0">

                                <li class="clearfix">
                                    <div class="float-left text-capitalize"><?= Html::encode(yii::t('db', 'phone')) ?>:</div>
                                    <div class="float-right"><?= Html::encode($model['phone']) ?></div>
                                </li>

                                <li class="clearfix">
                                    <div class="float-left text-capitalize"><?= Html::encode(yii::t('db', 'mobile')) ?>:</div>
                                    <div class="float-right"><?= Html::encode($model['mobile']) ?></div>
                                </li>
                            </ul>
                        </div>

                        <div class="item">
                            <h5>
                                <?= Html::encode(yii::t('db', 'Feedback')) ?>
                                <div>
                                    <small><?= Html::encode(yii::t('db', 'Fill out the form for further information')) ?></small>
                                </div>
                            </h5>

                            <div class="feedback-form">
                                <?php $form = ActiveForm::begin([
                                        'id' => 'department_form',
                                        'method' => 'POST',
                                        'action' => ['/department/form'],
//                                        'validationUrl' => ['/department/validate'],
                                        'enableAjaxValidation' => false,
                                        'fieldConfig' => [
                                            'errorOptions' => [
                                                'class' => 'invalid-feedback'
                                            ],
                                            'enableLabel'=>false
                                        ]
                                    ])
                                ?>

                                    <?= $form->field($model_form, 'name')
                                        ->textInput([
                                            'placeholder' => Html::encode($attr['name']),
                                            'disabled' => ($user) ? true : false,
                                        ])
                                    ?>

                                    <?= $form->field($model_form, 'email')
                                        ->textInput([
                                            'placeholder' => Html::encode($attr['email']),
                                            'class' => 'form-control run-validation',
                                            'disabled' => ($user) ? true : false,
                                        ])
                                    ?>

                                    <?= $form->field($model_form, 'phone')
                                        ->widget(\yii\widgets\MaskedInput::className(),[
                                            'mask' => '(099) 999 99 99',
                                            'options' => [
                                                'placeholder' => Html::encode($attr['phone']),
                                                'class' => 'form-control run-validation',
                                                'disabled' => ($user) ? true : false,
                                            ]
                                        ])
                                    ?>

                                    <?= $form->field($model_form, 'text')
                                        ->textarea([
                                            'placeholder' => Html::encode($attr['text']),
                                            'rows' => 2
                                        ])
                                    ?>

                                <?= $form->field($model_form, 'reCaptcha', [
                                    'errorOptions' => [
                                        'class' => 'invalid-feedback'
                                    ],
                                ])
                                    ->widget(\himiklab\yii2\recaptcha\ReCaptcha::className()) ?>

                                    <input type="hidden" name="slug" value="<?= yii::$app->request->get('slug') ?>">

                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-success m-0"><?= Html::encode(yii::t('db', 'Send')) ?></button>
                                    </div>
                                <?php ActiveForm::end() ?>
                            </div>
                        </div>

                        <div class="item other-sections-select">
                            <h5><?= Html::encode(yii::t('db', 'switch to other threads')) ?></h5>

                            <div class="select-sections">
                                <select onchange="location = this.value;" class="custom-select2">

                                    <option><?= Html::encode(yii::t('db', 'Select a department')) ?></option>

                                    <?php
                                    foreach ($departments as $department):

                                        (Yii::$app->request->get('id') == $department['id']) ? $selected = "selected" : $selected = "";
                                    ?>
                                        <option <?= $selected ?> value="<?= \yii\helpers\Url::to(['/departments/view', 'page_slug' => 'departments', 'id' => $department['id'], 'slug' => $department['slug']]) ?>">
                                            <?= Html::encode($department['name']) ?>
                                        </option>

                                    <?php endforeach; ?>

                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-md-7 pl-xl-4">
                <h2 class="section-title">

                    <div class="short">

                        <?= Html::encode($model['detail_name']) ?>

                    </div>
                </h2>

                <div class="text clearfix">

                    <?= HtmlPurifier::process($model['text']) ?>

                </div>

                <?= \app\widgets\Media\MediaWidget::widget([
                    'class_name' => 'yii\easyii\modules\department\models\Department',
                    'item_id' => yii::$app->request->get('id')
                ]) ?>

            </div>
        </div>

    </section>
</div>


<?= \app\widgets\UserVerify\UserVerifyWidget::widget([
    'form_id' => '#department_form',
    'phone_id' => '#departmentform-phone',
    'depend' => '#departmentform-email'
])
?>