<?php
use yii\easyii\helpers\Image;
use yii\easyii\widgets\TagsInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\easyii\widgets\Redactor;
use yii\easyii\widgets\SeoForm;
use yii\helpers\ArrayHelper;
use kartik\datetime\DateTimePicker;

$module = $this->context->module->id;
$model->exact_time = ''.$model->date_from.'';
?>



<h4>Vaxtı dəqiqləşdirib randevunu təsdiq edin</h4>

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'model-form']
]);

if(!$model->isNewRecord) {
    $model->exact_time = date('d.m.Y, H:i',strtotime($model->exact_time));

}

?>


<?= $form->field($model, 'exact_time')->widget(DateTimePicker::className(), [
        'pluginOptions' => [
            'format' => 'dd.mm.yyyy, HH:ii',
            'startDate'=> ''.$model->date_from.', 00:00',
            'endDate'=> ''.$model->date_to.', 23:59',
        ]
 ]) ?>

<?= $form->field($model, 'doctor_message')->textarea()->label('Həkimin mesajı (vacib deyil)') ?>

<?= Html::submitButton(Yii::t('easyii', 'Təsdiq et'), ['class' => 'btn btn-success']) ?>

<button type="submit" name="decline" data-confirm="Randevunu imtina etdiyinizə əminsiniz?" class="btn btn-danger pull-right">İmtina et</button>

<?php ActiveForm::end(); ?>
