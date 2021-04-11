<?php
use yii\easyii\widgets\DateTimePicker;
use yii\easyii\helpers\Image;
use yii\easyii\widgets\TagsInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\easyii\widgets\Redactor;
use yii\easyii\widgets\SeoForm;
use yii\helpers\ArrayHelper;

$module = $this->context->module->id;

//\yii\helpers\VarDumper::dump($model->services,10,1); die();
?>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'model-form']
]); ?>

<?= \yii\easyii\widgets\MultilingualForm::widget([
    'model' => $model,
    'form' => $form,
    'fields' => [
        'name',
        ['text', 'editor' => true]
    ],
    'slug' => [
        'source' => 'name'
    ]
]); ?>

<?= $form->field($model, 'parent_id')
    ->dropDownList(ArrayHelper::map($model->services, 'id', 'translation.name'), [
        'prompt' => yii::t('db', 'Parent')
    ])
?>

<?= Html::submitButton(Yii::t('db', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
