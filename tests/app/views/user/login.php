<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 4/16/2018
 * Time: 6:06 PM
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = yii::t('db', 'Enter');

$attr = $model->attributeLabels();

?>


<section class="section-gray login-page">
    <div class="row">
        <div class="col-12">
            <h2 class="section-title"> <?= Html::encode($this->title) ?> </h2>
        </div>
    </div>

    <div class="bordered-block">
        <div class="contacts-form">
            <?php $form = ActiveForm::begin([
                'enableAjaxValidation' => true,
                'method' => 'POST',
                'validationUrl' => ['/user/login-validate'],
                'action' => ['/login'],
                'options' => ['autocomplete' => 'off'],
                'fieldConfig' => [
                    'errorOptions' => [
                        'class' => 'invalid-feedback'
                    ],
                    'enableLabel'=>false
                ]
            ]) ?>

            <div class="row mb-2">register-modal
                <div class="col-sm-6 col-12">
                    <?= $form->field($model, 'email')
                        ->textInput([
                            'placeholder' => Html::encode($attr['email']),
                            'autocomplete'=> "off"
                        ])
                    ?>
                </div>

                <div class="col-sm-6 col-12">
                    <?= $form->field($model, 'password')
                        ->passwordInput([
                            'placeholder' => Html::encode($attr['password']),
                            'autocomplete'=> "off"
                        ])
                    ?>
                </div>
            </div>

            <div class="row">

                <div class="col-sm-4 col-12">
                    <?= $form->field($model, 'reCaptcha')
                        ->widget(\himiklab\yii2\recaptcha\ReCaptcha::className()) ?>
                </div>

                <div class="col-sm-4 col-12 text-sm-center mb-3 mb-sm-0">
                    <a href="<?= \yii\helpers\Url::to(['user/request-password-reset']) ?>" class="txt-underline">
                        <?= Html::encode(yii::t('db', 'Forgot password?')) ?>
                    </a>
                </div>

                <div class="col-sm-4 col-12 form-checkbox">
                    <div class="float-sm-right">
                        <?= $form->field($model, 'rememberMe')
                            ->checkbox()
                            ->label(Html::encode(yii::t('db', 'Remember me'))) ?>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-6">
                    <?php if(yii::$app->user->isGuest): ?>

                        <a href="<?= Url::to(['/user/signup', 'page_slug' => 'signup']) ?>" class="txt-underline">
                            <?= Html::encode(yii::t('db', 'Sign up')) ?>
                        </a>

                    <?php endif; ?>
                </div>
                <div class="col-6">
                    <div class="text-right">
                        <button type="submit" class="btn btn-success">
                            <?= Html::encode(yii::t('db', 'Enter')) ?>
                        </button>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end() ?>
        </div>
    </div>

</section>


