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

<hr>

<?= $form->field($model, 'title')->textInput() ?>
<?= $form->field($model, 'general_address')->textInput() ?>
<?= $form->field($model, 'email')->textInput() ?>
<?= $form->field($model, 'phone')->textInput() ?>
<?= $form->field($model, 'web')->textInput() ?>
<?= $form->field($model, 'coor_x')->textInput() ?>
<?= $form->field($model, 'coor_y')->textInput() ?>

    <?php if($model->image) : ?>
        <img width="150" src="<?= $model->image ?>">
        <a href="<?= Url::to(['/admin/'.$module.'/a/clear-image', 'id' => $model->id]) ?>" class="text-danger confirm-delete" title="<?= Yii::t('easyii', 'Clear image')?>"><?= Yii::t('easyii', 'Clear image')?></a>
    <?php endif; ?>
    <?= $form->field($model, 'image')->fileInput() ?>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
