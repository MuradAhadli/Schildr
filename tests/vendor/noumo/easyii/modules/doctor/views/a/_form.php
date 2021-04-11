<?php
use yii\easyii\widgets\DateTimePicker;
use yii\easyii\helpers\Image;
use yii\easyii\widgets\TagsInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\easyii\widgets\Redactor;
use yii\easyii\widgets\SeoForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;

$module = $this->context->module->id;
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'model-form']
]);

?>

<?= \yii\easyii\widgets\MultilingualForm::widget([
    'model' => $model,
    'form' => $form,
    'fields' => [
        'name',
        ['short', 'text' => true],
        ['text', 'editor' => true],
        'position',
    ],
    'slug' => [
        'source' => 'name'
    ]
]);
?>

<hr>


<?= $form->field($model, 'social')->widget(\kartik\select2\Select2::classname(),
    [
        'options' => ['placeholder' => 'Select a color ...', 'multiple' => true],
        'pluginOptions' => [
        'tags' => true,
        'tokenSeparators' => [',', ' '],
        'maximumInputLength' => 100
        ],
    ])
    ->label('Social');
?>

<div class="col-sm-12">
    <?= $form->field($user, 'status')->checkbox() ?>
</div>

<?= $form->field($model, 'department_id')
    ->dropDownList(ArrayHelper::map($model->departments, 'id', 'translation.name'), ['prompt' => 'secin']) ?>

<?php if(isset($model->user) && $model->user->image) : ?>

    <img src="<?= yii::getAlias('@web') . $model->user->image ?>">
    <a href="<?= Url::to(['/admin/'.$module.'/a/clear-image', 'id' => $model->user_id]) ?>" class="text-danger confirm-delete" title="<?= Yii::t('easyii', 'Clear image')?>"><?= Yii::t('easyii', 'Clear image')?></a>

<?php endif; ?>

<?= $form->field($user, 'image')->fileInput() ?>


<?= $form->field($user, 'birthday')->widget(DatePicker::className(), [

        'field' => 'phone',
        'model' => $user,
        'removeButton' => false,
        'pickerButton' => false,
        'type' => DatePicker::TYPE_INPUT,
        'pluginOptions' => [
            'todayHighlight' => true,
            'todayBtn' => true,
            'autoclose' => true,
            'format' => 'dd/mm/yyyy',
        ]
]) ?>

<?= $form->field($user, 'email'); ?>

<?= $form->field($user, 'phone')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '(099)-999-99-99']); ?>

<div class="row">
    <div class="col-xs-6">
        <?= $form->field($user, 'password')->passwordInput(['autocomplete' => 'new-password']); ?>
    </div>
    <div class="col-xs-6">
        <?= $form->field($user, 'password_repeat')->passwordInput(['autocomplete' => 'new-password_repeat']); ?>
    </div>
</div>

<?php if(IS_ROOT) : ?>
    <?= SeoForm::widget(['model' => $model]) ?>
<?php endif; ?>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
