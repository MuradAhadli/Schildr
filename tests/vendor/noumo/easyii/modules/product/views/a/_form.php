<?php

use yii\easyii\modules\product\models\ProductFiles;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

\yii\bootstrap\BootstrapPluginAsset::register($this);


$action = yii::$app->controller->action->id;
$productPdfFiles = unserialize($product['downloads']);
$module = $this->context->module->id;

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
        'slug',
        ['customization', 'editor' => true],
    ],
]);

?>

    <!--Bootstrap File Uploader Plugin-->
<?= $form->field($model, 'image[]')->fileInput([
    'class' => 'recFile classRequired',
    'multiple' => 'multiple',
    'data-types' => json_encode($dataTypes),
    'data-uploads' => json_encode($dataUploads),
    'data-newuploads' => json_encode($newDataUploads),
    'data-key' => json_encode(array_keys($dataUploads)),
    'data-url' => yii::$app->request->get('id'),
]) ?>
    <!--Bootstrap File Uploader Plugin-->
    <hr>
    <!--Hover image-->
<?= $form->field($model, 'hover_image')->fileInput()->label('Hover Image') ?>
    <!-- /Hover image-->

<?php if ($action == 'edit' && !empty($model->hover_image)): ?>
    <div class="row">
        <div class="col-xs-3">
            <img width="200" height="80" src="<?= $model->hover_image ?>" class="img-responsive" alt="hover_image">
            <a href="<?= Url::to(['/admin/' . $module . '/a/clear-hover', 'id' => $model->id]) ?>"
               class="text-danger confirm-delete"
               title="<?= Yii::t('easyii', 'Clear') ?>"><?= Yii::t('easyii', 'Clear') ?></a>
        </div>
    </div>

<?php endif; ?>

    <hr>
    <div class="row" id="downloads_area">
        <div class="downloads_area__header">
            <label for="">Downloads(PDF)</label>
            <span class="btn_add"><i
                        class="fa fa-plus"></i>
            </span>
        </div>

        <?php if ($action === 'edit'): ?>

            <?php foreach (unserialize($model->downloads) as $k => $v): ?>
                <div class="form-group col-xs-12 item">
                    <div class="row item-inner">
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="downloads">PDF</label>
                                <input id="downloads" type="file" class="form-control" name="downloads[]">
                                <img src="<?= '../../../../' . $v['pdf'] ?>" width="200" height="200" alt="" style="padding: 25px;">
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="pdf_title">PDF title</label>
                                <input type="text" class="form-control" value="<?= $v['title'] ?>" required name="pdf_title[]">
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <span class="item_del"><i class="fa fa-minus"></i></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php else: ; ?>

        <?php endif; ?>

    </div>

<?= $form->field($model, 'status')->dropDownList([
    '1' => 'active',
    '0' => 'deactive'
])->label('Status') ?>

<?= $form->field($model, 'category_id')->dropDownList($parentCategories, [
    'prompt' => 'Select a parent'])->label('Parent') ?>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>