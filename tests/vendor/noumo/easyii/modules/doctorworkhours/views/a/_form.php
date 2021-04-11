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
?>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'model-form']
]); ?>

<?= $form->field($model, 'doctor_id')
    ->dropDownList(
            ArrayHelper::map(
                    $model->doctors, 'id', 'translation.name'
            )
    ); ?>

<?=  $form->field($model , 'day')
    ->widget(\kartik\select2\Select2::classname(), [
        'data' =>\yii\easyii\components\Helper::getWeekDays() ,
        'options' => ['placeholder' => Yii::t('db','select_day'), 'multiple' => true],
        'pluginOptions' => [
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 10
        ],
    ])->label(yii::t('db','Day'));

?>

<div class="row">
    <div class="col-xs-6">
        <?= $form->field($model, 'hour_from')->widget(\kartik\time\TimePicker::classname(), [
            'pluginOptions' => [
                'showMeridian' => false
            ]
        ]);
        ?>
    </div>
    <div class="col-xs-6">
        <?= $form->field($model, 'hour_to')->widget(\kartik\time\TimePicker::classname(), [
            'pluginOptions' => [
                'showMeridian' => false
            ]
        ]);
        ?>
    </div>
</div>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
