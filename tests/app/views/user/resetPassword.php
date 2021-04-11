<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = yii::t('db', 'Reset password');

$this->params['title'] = yii::t('db', 'E-services');
?>

<section class="section-gray">
    <div class="row">
        <div class="col-12">
            <h2 class="section-title"> <?= Html::encode($this->title) ?> </h2>
            <div class="section-short">
                <p>
                    <?= Html::encode(yii::t('db', 'Please choose your new password.')) ?>
                </p>
            </div>
        </div>
    </div>

    <div class="bordered-block">
        <div class="contacts-form">

            <?php $form = ActiveForm::begin([
                    'id' => 'reset-password-form',
                    'fieldConfig' => [
                        'errorOptions' => [
                            'class' => 'invalid-feedback'
                        ],
                        'enableLabel'=>false
                    ]
                ]);
            ?>

                <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

                <div class="form-group text-right">
                    <?= Html::submitButton(Html::encode(yii::t('db', 'Send')), ['class' => 'btn btn-success']) ?>
                </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

</section>

