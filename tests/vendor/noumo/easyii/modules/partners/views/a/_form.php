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
        'full_name',
        'position',
        ['review', 'editor' => true],
    ],
]); ?>


<hr>
<?php if ($model->image) : ?>
    <img src="<?= $model->image ?>">
    <a href="<?= Url::to(['/admin/' . $module . '/a/clear-image', 'id' => $model->id]) ?>"
       class="text-danger confirm-delete"
       title="<?= Yii::t('easyii', 'Clear image') ?>"><?= Yii::t('easyii', 'Clear image') ?></a>
<?php endif; ?>
    <?= $form->field($model, 'image')->fileInput() ?>

    <?= $form->field($model, 'rating')->dropDownList([
            1 => '1',
            2 => '2',
            3 => '3',
            4 => '4',
            5 => '5',
    ]) ?>

    <?= $form->field($model, 'client_id')->dropDownList($clients) ?>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
