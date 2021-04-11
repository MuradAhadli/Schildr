<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\easyii\modules\gallerycategory\models\GalleryCategory;

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
        'title'
    ],
]);
?>

<?php if($model->image) : ?>
    <img src="<?= yii::getAlias('@web') . $model->thumb ?>" >
<?php endif; ?>
<?= $form->field($model, 'image')->fileInput() ?>

<?= $form->field($model, 'category_id')
    ->dropDownList(
        ArrayHelper::map(
                GalleryCategory::getCategories(), 'id', 'name'
        ),
        ['prompt' => 'Kateqoriya seçin']
    )
?>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>