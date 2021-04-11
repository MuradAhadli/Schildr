<?php

use yii\easyii\widgets\DateTimePicker;
use yii\easyii\helpers\Image;
use yii\easyii\widgets\TagsInput;
use yii\helpers\Html;
use yii\easyii\modules\pagesystem\models\PageSystem;

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
        'title', 'text'
    ],
]); ?>

<?= $form->field($model, 'youtube_embed')->textInput()->label('Youtube Video (Embed)') ?>

<?php if (yii::$app->controller->action->id === 'edit'): ?>

    <iframe width="100%" height="600px" src="https://www.youtube.com/embed/<?= $model->youtube_embed ?>"></iframe>
    <br><br>

<?php endif; ?>

<?= $form->field($model, 'file')->fileInput() ?>
<?php if (yii::$app->controller->action->id == 'edit'): ?>
    <div class="row">
        <video style="width: 300px" class="home_page_video" autoplay controls>
            <source src="<?= $model->file ?>"
                    type="video/mp4">
            <source src="<?= $model->file ?>"
                    type="video/ogg">
        </video>
    </div>
<?php endif; ?>

<hr>

<?php if (IS_ROOT) : ?>
    <?= SeoForm::widget(['model' => $model]) ?>
<?php endif; ?>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
