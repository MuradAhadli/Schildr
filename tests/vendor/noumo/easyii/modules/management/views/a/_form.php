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
        'username',
        'position',
        ['short', 'editor' => true],
        ['text', 'editor' => true]
    ],
    'slug' => [
        'source' => 'username'
    ]
]); ?>

<hr>

<?= $form->field($model, 'social')->widget(\kartik\select2\Select2::classname(),
    [
        'options' => ['placeholder' => 'Add social network ...', 'multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 100
        ],
    ])
    ->label('Social');
?>

<?= $form->field($model, 'email') ?>

<?= $form->field($model, 'phone') ?>

<?php if($this->context->module->settings['enableThumb']) : ?>
    <?php if($model->image) : ?>
        <img src="<?= $model->image ?>">
        <a href="<?= Url::to(['/admin/'.$module.'/a/clear-image', 'id' => $model->id]) ?>" class="text-danger confirm-delete" title="<?= Yii::t('easyii', 'Clear image')?>"><?= Yii::t('easyii', 'Clear image')?></a>
    <?php endif; ?>
    <?= $form->field($model, 'image')->fileInput() ?>
<?php endif; ?>


<?php if(IS_ROOT) : ?>
    <?= SeoForm::widget(['model' => $model]) ?>
<?php endif; ?>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
