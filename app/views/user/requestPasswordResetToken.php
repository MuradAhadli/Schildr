<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->params['title'] = yii::t('db', 'E-services');

$this->title = yii::t('db', 'Request password reset');
?>

<section class="section-gray">
    <div class="row">
        <div class="col-12">
            <h2 class="section-title"> <?= Html::encode($this->title) ?> </h2>
            <div class="section-short">
                <p>
                    <?= Html::encode(yii::t('db', 'Please fill out your email. password change link will sent to your e-mail address.')) ?>
                </p>
            </div>
        </div>
    </div>

    <div class="bordered-block">
        <div class="contacts-form">

            <?php
                $form = ActiveForm::begin([
                    'id' => 'request-password-reset-form',
                    'fieldConfig' => [
                        'errorOptions' => [
                            'class' => 'invalid-feedback'
                        ],
                        'enableLabel'=>false
                    ]
                ]);
            ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <div class="row mb-2">
                <div class="col-6">
                    <?= $form->field($model, 'reCaptcha', [
                        'errorOptions' => [
                            'class' => 'invalid-feedback'
                        ],
                    ])
                        ->widget(\himiklab\yii2\recaptcha\ReCaptcha::className()) ?>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-success float-right"><?= yii::t('db', 'Send') ?></button>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

</section>

