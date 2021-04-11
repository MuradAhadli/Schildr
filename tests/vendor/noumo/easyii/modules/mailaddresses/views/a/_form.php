<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\easyii\widgets\Redactor;
?>
<?php $form = ActiveForm::begin([
    'options' => ['class' => 'model-form']
]);

$options = [];

if(!empty(Yii::$app->request->get('id'))){
    $options = ['disabled' => 'disabled'];
}

?>

<?= $form->field($model, 'tech_name')->label(yii::t('easyii', 'Technical name'))->textInput($options)  ?>

<?= $form->field($model, 'name')->label(yii::t('easyii', 'Name'))?>

<?= $form->field($model, 'email')->label(yii::t('easyii', 'Email'))?>

<?= Html::submitButton(Yii::t('easyii','Save'), ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>