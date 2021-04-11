<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 3/24/2018
 * Time: 10:54 AM
 */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use app\models\ConsultationForm;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;

$this->title = Html::encode($text['title']);
$attr = $model->attributeLabels();

?>

<div class="" id="consultation">
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
                <?php $form = ActiveForm::begin([
                        'id' => 'consultation_form',
                        'enableAjaxValidation' => true,
                        'method' => 'POST',
                        'validationUrl' => ['/consultation/validate'],
                        'action' => ['/consultation/index', 'page_slug' => 'consultation'],
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
                    <div class="col-12">
                        <?= $form->field($model, 'assign')
                            ->widget(Select2::className(), [
                                'data' => \app\models\Department::getDoctorsOptGroup(),
                                'options' => [
                                    'placeholder' => Html::encode(yii::t('db', 'Choose a doctor')),
                                    'class' => 'form-control'
                                ],
                            ])
                        ?>
                    </div>
                </div>

                <div class="row mb-md-2">

                    <div class="col-md-6 col-12">
                        <?= $form->field($model, 'firstname')
                            ->textInput([
                                'value' => ($user) ?  $user->firstname.' '.$user->lastname : '',
                                'placeholder' => Html::encode($attr['firstname']),
                                'class' => 'form-control form-private',
                                'disabled' => ($user) ? true : false,
                                'data-attr' => 'firstname'
                            ])
                        ?>
                    </div>
                    <div class="col-md-6 col-12">
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
                    <div class="col-md-6 col-12">
                        <?= $form->field($model, 'email')
                            ->textInput([
                                'value' => ($user) ?  $user->email : '',
                                'placeholder' =>  Html::encode($attr['email']),
                                'disabled' => ($user) ? true : false,
                                'date-attr' => 'email'
                            ])
                        ?>
                    </div>
                    <div class="col-md-6 col-12">
                        <?= $form->field($model, 'phone')
                            ->widget(\yii\widgets\MaskedInput::className(),[
                                'mask' => '(099) 999 99 99',
                                'options' => [
                                    'value' => ($user) ?  $user->phone : '',
                                    'placeholder' =>  Html::encode($attr['phone']),
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
                                'placeholder' =>  Html::encode($attr['text']),
                                'rows' => 5
                            ])
                        ?>
                    </div>
                </div>

                <div class="row mt-md-4">
                    <div class="col-md-6 col-12 over-x-hidden">
                        <div class="float-left">
                            <?= $form->field($model, 'reCaptcha')
                                ->widget(\himiklab\yii2\recaptcha\ReCaptcha::className()) ?>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12 form-checkbox float-right">
                        <div class="float-md-right">
                            <?= $form->field($model, 'private')->checkbox([
                                'class' => 'private-checkbox'
                            ])
                                ->label(Html::encode(yii::t('db', 'Private')))
                            ?>
                        </div>
                    </div>

                    <div class="col-lg-3 col-12">
                        <div class="float-md-right">
                            <button type="submit" class="btn btn-success m-0 w-100">
                                <?= Html::encode(yii::t('db', 'Send')) ?>
                            </button>
                        </div>
                    </div>
                </div>

                <?php ActiveForm::end() ?>

            </div>
        </div>

    </section>
</div>
<script>
    var dep_doctors = <?= json_encode($dep_doctors); ?>;
    var user_id = <?= ($user) ? $user->id : 0 ?>
</script>

<?= \app\widgets\UserVerify\UserVerifyWidget::widget([
    'form_id' => '#consultation_form',
    'phone_id' => '#consultationform-phone',
    'depend' => '#consultationform-private'
])
?>