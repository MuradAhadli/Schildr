<?php

use yii\easyii\widgets\Photos;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

$files = FileHelper::findFiles('uploads/video');

$arr[] = '';

foreach ($files as $k => $v) {

    $arr[$v] = $v;
}

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
        'short',
        ['text', 'editor' => true]
    ],
]);

?>

<?= $form->field($model, 'image[]')->fileInput(['multiple' => 'multiple', 'class' => 'form-control'])->label('Carousel images') ?>

<?php if(yii::$app->controller->action->id == 'edit'): ?>
        <div class="row">
            <?php foreach($carouselUploads as $val): ?>
                <div class="col-xs-4 carousel_item">
                    <img class="img-responsive" src="<?= $val['file_name'] ?>" alt="">
                    <span class="btn btn-danger btn-block btn-small del_carousel_item" data-id = "<?= $val['id'] ?>">x</span>
                </div>
            <?php endforeach; ?>
        </div>
<?php endif; ?>


<div class="carousel_tab">
    <div class="carousel__header">
        <span class="active" id="page">Page</span>
        <span type="button" id="category">Category</span>
        <span type="button" id="altCategory">altCategory</span>
    </div>
    <div class="carousel__body">
        <?= $form->field($model, 'page_id')->dropDownList($pages, [
                'data-active' => 'page',
                'class' => 'form-control',
                'prompt' => 'Select a page',
        ])->label('Page') ?>

        <?= $form->field($model, 'category_id')->dropDownList($categories, [
                'data-active' => 'category',
                'class' => 'form-control',
                'prompt' => 'Select a Category'
        ])->label('Category') ?>

        <?= $form->field($model, 'category_id_help')->dropDownList($altCategory, [
                'data-active' => 'altCategory',
                'class' => 'form-control',
                'prompt' => 'Select Sub Category'
        ])->label('altCategory') ?>
    </div>
</div>



<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>