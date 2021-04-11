<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

\yii\bootstrap\BootstrapPluginAsset::register($this);

?>
<?php $form = ActiveForm::begin([
    'enableClientValidation' => true,
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'model-form']
]); ?>

<?= \yii\easyii\widgets\MultilingualForm::widget([
    'model' => $model,
    'form' => $form,
    'fields' => [
        'title',
        'subtitle',
        'short',
        'slug',
    ],
]);
?>

<?= $form->field($model, 'image')->fileInput(['class' => 'form-control'])->label('Image') ?>

<?php if(yii::$app->controller->action->id == 'edit'): ?>
    <img width="250" src="<?= yii::getAlias('@web') . $model->image ?>" alt="">
<?php endif; ?>

<?= $form->field($model, 'second_image')->fileInput(['class' => 'form-control'])->label('Second image') ?>
<?php if(yii::$app->controller->action->id == 'edit' && $model->second_image != ''): ?>
    <img width="250" src="<?= yii::getAlias('@web') . $model->second_image ?>" alt="">
<?php endif; ?>


<?= $form->field($model, 'status')->dropDownList([
        '1' => 'active',
        '0' => 'deactive'
])->label('Status') ?>

<?= $form->field($model, 'parent_id')->dropDownList($parents, [
        'prompt' => 'Select a parent'])->label('Parent') ?>


<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>