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
        'name',
        ['detail_name', 'text' => true],
        ['short', 'editor' => true],
        ['text', 'editor' => true],
    ],
    'slug' => [
        'source' => 'name'
    ]
]); ?>

<hr>

<?= $form->field($model, 'phone')->textInput() ?>

<?= $form->field($model, 'mobile')->textInput() ?>

<?php if($this->context->module->settings['enableThumb']) : ?>
    <?php if($model->image) : ?>
        <img src="<?= yii::getAlias('@web') . $model->image ?>">
        <a href="<?= Url::to(['/admin/'.$module.'/a/clear-image', 'id' => $model->id]) ?>" class="text-danger confirm-delete" title="<?= Yii::t('easyii', 'Clear image')?>"><?= Yii::t('easyii', 'Clear image')?></a>
    <?php endif; ?>
    <?= $form->field($model, 'image')->fileInput() ?>
<?php endif; ?>

<?php if(IS_ROOT) : ?>
    <?= SeoForm::widget(['model' => $model]) ?>
<?php endif; ?>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
