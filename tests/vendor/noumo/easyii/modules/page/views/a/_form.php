<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\easyii\widgets\Redactor;
use yii\easyii\widgets\SeoForm;
use yii\helpers\ArrayHelper;

$module = $this->context->module->id;

?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['class' => 'model-form']
]); ?>

<?= \yii\easyii\widgets\MultilingualForm::widget([
    'model' => $model,
    'form' => $form,
    'fields' => [
        'title',
        ['short', 'editor' => true],
        ['text', 'editor' => true],
    ],
    'slug' => [
        'source' => 'title'
    ],
]); ?>

<hr>

<?= $form->field($model, 'parent_id')->dropDownList($model->parentPages, [
        'prompt' => 'Select parent page'
]) ?>

<?= $form->field($model, 'section')->checkbox() ?>

<?php if($model->image) : ?>
    <img src="<?= yii::getAlias('@web') . $model->image ?>">
    <a href="<?= Url::to(['/admin/'.$module.'/a/clear-image', 'id' => $model->id]) ?>" class="text-danger confirm-delete" title="<?= Yii::t('easyii', 'Clear image')?>"><?= Yii::t('easyii', 'Clear image')?></a>
<?php endif; ?>
<?= $form->field($model, 'image')->fileInput() ?>

<?= $form->field($model, 'external_link')->label('External link (www.example.com)') ?>

<?php if(IS_ROOT) : ?>
    <?= SeoForm::widget(['model' => $model]) ?>
<?php endif; ?>

<?= Html::submitButton(Yii::t('easyii','Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>