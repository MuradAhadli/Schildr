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

<?= $form->field($model, 'link')->textInput() ?>

<?php if($model->link): ?>
    <iframe width="100%" height="600px" src="https://www.youtube.com/embed/<?= $model->link ?>"></iframe>
<br><br>
<?php endif; ?>

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