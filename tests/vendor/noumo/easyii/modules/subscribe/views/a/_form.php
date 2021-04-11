<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\easyii\widgets\Redactor;
?>
<?php $form = ActiveForm::begin([
    'enableClientValidation' => true
]); ?>
<?= $form->field($model, 'subject') ?>
<?= $form->field($model, 'body')
    ->widget(\dosamigos\tinymce\TinyMce::className(), [
        'language' => yii::$app->language
    ]);
?>

<?= Html::submitButton(Yii::t('easyii', 'Send'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>