<?php
use yii\easyii\widgets\DateTimePicker;
use yii\easyii\helpers\Image;
use yii\easyii\widgets\TagsInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\easyii\widgets\Redactor;
use yii\easyii\widgets\SeoForm;
use \yii\easyii\modules\checkup\models\CheckUp;

$module = $this->context->module->id;
?>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'model-form']
]); ?>

<?= \yii\easyii\widgets\MultilingualForm::widget([
    'model' => $model,
    'form' => $form,
    'fields' => [
        'name',
        ['text', 'editor' => true],
    ],
    'slug' => [
        'source' => 'name'
    ]
]); ?>


<?=  $form->field($model , 'examination_id')
    ->widget(\kartik\select2\Select2::classname(), [
        'data' => CheckUp::getExamination() ,
        'options' => ['placeholder' => Yii::t('db','select_examination'), 'multiple' => true],
        'maintainOrder' => true,
        'pluginOptions' => [
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 10
        ],
    ])->label(yii::t('db','Examination'));

?>

<?= $form->field($model, 'price')->textInput() ?>
<?= $form->field($model, 'discount_price')->textInput() ?>

<?php if(IS_ROOT) : ?>
    <?= SeoForm::widget(['model' => $model]) ?>
<?php endif; ?>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
