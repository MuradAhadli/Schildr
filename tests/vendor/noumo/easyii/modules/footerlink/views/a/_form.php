<?php

use yii\easyii\widgets\DateTimePicker;
use yii\easyii\helpers\Image;
use yii\easyii\widgets\TagsInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\easyii\widgets\Redactor;
use yii\easyii\widgets\SeoForm;

$module = $this->context->module->id;
?>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'model-form']
]); ?>

<?= \yii\easyii\widgets\MultilingualForm::widget([
    'model' => $model,
    'form' => $form,
    'fields' => [
        'title',
    ],
]); ?>

<hr>

<?= $form->field($model, 'url')->textInput() ?>

<?= $form->field($model, 'target')->dropDownList([
    '_blank' => 'blank',
    'current' => 'current'
], ['prompt' => 'Select target style']) ?>

<?= $form->field($model, 'parent_id')->dropDownList($footerLinks, ['prompt' => 'Select Parent'])->label('Parent Footer Link') ?>

<?= $form->field($model, 'status')->dropDownList([
        '1' => 'active',
        '0' => 'deactive'
], ['prompt' => 'Select Status']) ?>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
