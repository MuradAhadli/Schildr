<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 3/24/2018
 * Time: 10:54 AM
 */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;
use \kartik\select2\Select2;

$this->title = 'E-Randevu';

$attr = $model->attributeLabels();

?>

<div class="">
    <section class="section-gray">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">
                    <?= Html::encode($text['title']) ?>
                </h2>

                <div class="section-short">
                    <?= HtmlPurifier::process($text['text']) ?>
                </div>
            </div>
        </div>

        <div class="bordered-block">
            <div class="contacts-form">

                <div class="caption">
                    <?= Html::encode(yii::t('db', 'Fill out the form below to get an appointment with a doctor')) ?>
                </div>

                <?php $form = ActiveForm::begin([
                        'id' => 'randevu_form',
                        'action' => ['/randevu/submit'],
                        'fieldConfig' => [
                            'errorOptions' => [
                                'class' => 'invalid-feedback'
                            ],
                            'enableLabel'=>false
                        ]
                ]); ?>

                <div class="row mb-md-2">
                    <div class="col-md-6 col-12">
                        <?= $form->field($model, 'doctor_id')
                            ->widget(Select2::className(), [
                                'data' => $model->doctors,
                                'options' => [
                                        'placeholder' => Html::encode(yii::t('db', 'Choose a doctor')),
                                        'class' => 'form-control'
                                ],
                            ])
                        ?>
                    </div>
                    <div class="col-md-6 col-12">
                        <?= $form->field($model, 'date')
                            ->widget(\kartik\daterange\DateRangePicker::classname(), [
                                'options' => [
                                    'placeholder' => Html::encode($attr['date']),
                                    'class' => 'form-control'
                                ],
                                'pluginOptions' => [
                                    'locale' => ['format' => 'DD.MM.YYYY', 'cancelLabel' => false],
                                ],
                                'value' => '10.05.2018 - 10.05.2018',
                            ]);
                        ?>
                    </div>
                </div>

                <div class="row mb-md-2">
                    <div class="col-md-6 col-12">
                        <?= $form->field($model, 'username')
                            ->textInput([
                                'placeholder' => Html::encode($attr['username']),
                                'disabled' => !$guest
                            ])
                        ?>
                    </div>

                    <div class="col-md-6 col-12">
                        <?= $form->field($model, 'birthday')
                            ->widget(MaskedInput::className(),[
                                'mask' => '99.99.9999',
                                'options' => [
                                    'placeholder' => Html::encode($attr['birthday']),
                                    'class' => 'form-control',
                                    'disabled' => !$guest
                                ]
                            ])
                        ?>
                    </div>
                </div>

                <div class="row mb-md-2">
                    <div class="col-md-6 col-12">
                        <?= $form->field($model, 'phone')
                            ->widget(MaskedInput::className(),[
                                'mask' => '(099) 999 99 99',
                                'options' => [
                                    'placeholder' => Html::encode($attr['phone']),
                                    'class' => 'form-control',
                                    'disabled' => !$guest
                                ]
                            ])
                        ?>
                    </div>

                    <div class="col-md-6 col-12">
                        <?= $form->field($model, 'email')
                            ->textInput([
                                'placeholder' => Html::encode($attr['email']),
                                'disabled' => !$guest
                            ])
                        ?>
                    </div>
                </div>

                <div class="row mb-md-2">
                    <div class="col-12">
                        <?= $form->field($model, 'message')
                            ->textarea(['placeholder' => Html::encode($attr['message'])]) ?>
                    </div>
                </div>

                <div class="row mb-md-2">
                    <div class="col-md-6 col-12">
                        <?= $form->field($model, 'reCaptcha', [
                            'errorOptions' => [
                                'class' => 'invalid-feedback'
                            ],
                        ])
                            ->widget(\himiklab\yii2\recaptcha\ReCaptcha::className()) ?>
                    </div>
                    <div class="col-md-6 col-12 mt--25">
                        <button type="submit" class="btn btn-success float-right"><?= Html::encode(yii::t('db', 'Send')) ?></button>
                    </div>
                </div>

                <?= $form->field($model, 'user_id')->hiddenInput(['value' => (!$guest) ? yii::$app->user->identity->id : '']) ?>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    </section>
</div>


<?= \app\widgets\UserVerify\UserVerifyWidget::widget([
    'form_id' => '#randevu_form',
    'phone_id' => '#randevuform-phone'
])
?>