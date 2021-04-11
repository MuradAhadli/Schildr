<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 3/24/2018
 * Time: 10:54 AM
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = $text['title'];

$attr = $model->attributeLabels();
?>

<div class="">
    <section class="section-gray">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title"> <?= Html::encode($text['title']) ?> </h2>
                <div class="section-short">
                    <?= HtmlPurifier::process($text['text']) ?>
                </div>
            </div>
        </div>

        <div class="bordered-block">
            <div class="contacts-form">

                <?php $form = ActiveForm::begin([
                    'id' => 'signup_form',
                    'method' => 'POST',
                    'validationUrl' => ['/signup/validate'],
                    'action' => ['/signup'],
                    'options' => ['autocomplete' => 'off'],
                    'fieldConfig' => [
                        'errorOptions' => [
                            'class' => 'invalid-feedback'
                        ],
                        'enableLabel'=>false
                    ]
                ]) ?>

                <div class="row mb-md-2">
                    <div class="col-md-6 col-12">
                        <?= $form->field($model, 'firstname')
                            ->textInput(['placeholder' => Html::encode($attr['firstname'])])
                        ?>
                    </div>
                    <div class="col-md-6 col-12">
                        <?= $form->field($model, 'lastname')
                            ->textInput(['placeholder' => Html::encode($attr['lastname']) ])
                        ?>
                    </div>
                </div>

                <div class="row mb-md-2">
                    <div class="col-md-6 col-12">
                        <?= $form->field($model, 'patronymic')
                            ->textInput(['placeholder' => Html::encode($attr['patronymic']) ])
                        ?>
                    </div>
                    <div class="col-md-6 col-12">
                        <?= $form->field($model, 'birthday')
                            ->widget(\yii\widgets\MaskedInput::className(),[
                                'mask' => '99.99.9999',
                                'options' => [
                                    'placeholder' => Html::encode($attr['birthday']),
                                    'class' => 'form-control',
                                ]
                            ])
                        ?>
                    </div>
                </div>

                <div class="row mb-md-2">

                    <div class="col-md-6 col-12">
                        <?= $form->field($model, 'gender')
                            ->dropDownList(\yii\easyii\models\Constants::getGender(), [
                                'prompt' => Html::encode($attr['gender'])
                            ])
                        ?>
                    </div>

                    <div class="col-md-6 col-12">
                        <?= $form->field($model, 'phone', ['enableAjaxValidation' => true])
                            ->widget(\yii\widgets\MaskedInput::className(),[
                                'mask' => '(099) 999 99 99',
                                'options' => [
                                    'placeholder' => Html::encode($attr['phone']),
                                    'class' => 'form-control'
                                ],
                            ])
                        ?>
                    </div>
                </div>

                <div class="row mb-md-2">
                    <div class="col-md-6 col-12">
                        <?= $form->field($model, 'email', ['enableAjaxValidation' => true])
                            ->textInput([
                                'placeholder' => Html::encode($attr['email']),
                                'autocomplete'=> "off",
                            ])
                        ?>
                    </div>

                    <div class="col-md-6 col-12">
                        <?= $form->field($model, 'password')
                            ->passwordInput([
                                'placeholder' => Html::encode($attr['password']),
                                'autocomplete'=> "off"
                            ])
                        ?>
                    </div>

                </div>

                <div class="row mb-md-2">

                    <div class="col-md-6 col-12">
                        <?= $form->field($model, 'reCaptcha')
                            ->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(false) ?>
                    </div>

                    <div class="col-md-6 col-12 mt--35 form-checkbox">
                        <?= $form->field($model, 'rememberMe')->checkbox()->label(yii::t('db', 'Remember me')) ?>
                    </div>
                </div>


                <div class="text-center">
                    <button type="submit" class="btn btn-success">
                        <?= Html::encode(yii::t('db', 'Sign up')) ?>
                    </button>
                </div>

                <?php ActiveForm::end() ?>
            </div>
        </div>

    </section>
</div>

<?= \app\widgets\UserVerify\UserVerifyWidget::widget([
        'form_id' => '#signup_form',
        'phone_id' => '#signupform-phone'
    ])
?>

