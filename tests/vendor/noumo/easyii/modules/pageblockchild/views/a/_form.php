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
        'short',
        ['description', 'editor' => true],
    ],
]); ?>

<hr>

<?= $form->field($model, 'image')->fileInput(['class' => 'form-control'])->label('image') ?>
<?php if (yii::$app->controller->action->id == 'edit'): ?>
    <div class="row">
        <div class="col-xs-12">
            <img class="img-responsive" src="<?= yii::getAlias('@web').$model->image ?>" alt="">
        </div>
    </div>
<?php endif; ?>

<?= $form->field($model, 'url')->textInput() ?>

<?= $form->field($model, 'target')->dropDownList([
    '_blank' => 'blank',
    'current' => 'current'
], ['prompt' => 'Select target style']) ?>


<?= $form->field($model, 'page_block_id')->dropDownList($pageBlocks, ['prompt' => 'Select Page Block'])->label('Page Block') ?>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
