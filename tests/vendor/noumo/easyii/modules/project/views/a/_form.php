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
$action = yii::$app->controller->action->id;
?>

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'model-form']
]); ?>

<?= \yii\easyii\widgets\MultilingualForm::widget([
    'model' => $model,
    'form' => $form,
    'fields' => [
        'title', 'subtitle'
    ],
]); ?>

<?php

?>
<?= $form->field($model, 'image[]')->fileInput([
    'multiple' => 'multiple',
])->label('Project Files (multiple)') ?>


<?php if ($action === 'edit'): ?>

    <div class="row project-files" data-parent="<?= yii::$app->request->get('id') ?>">
        <h3 class="text-center">Project Carousel Files</h3>
        <?php foreach ($uploads as $k => $v): ?>

            <div class="col-xs-2 file-item <?= ($v['is_base'] == 1) ? 'base-image' : ''; ?>" data-key="<?= $v['id'] ?>">
                <div class="item-helper">
                    <img src="<?= yii::getAlias('@web') . $v['image'] ?>" alt="" class="img-responsive">
                    <div class="caption">
                        <div class="clearfix">
                            <button type="button" class="text-center" <?= ($v['is_base'] == 1) ? 'disabled=""' : ''; ?>>
                                <span class="text-center" id="previewImage"><i class="fa fa-home"></i></span>
                            </button>
                            <button type="button" class="text-center">
                                <span class="text-center" id="deleteProject"><i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>

<?php endif; ?>

<?= $form->field($model, 'logo')->fileInput([
    'multiple' => 'multiple',
])->label('Logo') ?>
<?php if ($model->logo) : ?>
    <img width="200" height="80" src="<?= $model->logo ?>">
    <a href="<?= Url::to(['/admin/' . $module . '/a/clear-logo', 'id' => $model->id]) ?>"
       class="text-danger confirm-delete"
       title="<?= Yii::t('easyii', 'Clear logo') ?>"><?= Yii::t('easyii', 'Clear logo') ?></a>
<?php endif; ?>

<?= $form->field($model, 'category_id')->dropDownList($category, [
    'prompt' => 'Select a category'
])->label('Project category') ?>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<div id="myFiles"></div>
<?php ActiveForm::end(); ?>

