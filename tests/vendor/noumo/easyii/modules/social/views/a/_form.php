<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['class' => 'model-form']
]); ?>

<div class="form-group">
    <a target="_blank" href="http://fontawesome.io/icons/"><?= yii::t('easyii', 'Icons') ?></a>

    <a target="_blank" style="margin-left: 50px" href="https://brandcolors.net/"><?= yii::t('easyii', 'Colors') ?></a>
</div>


<?= $form->field($model, 'icon')->label(yii::t('easyii', 'Icon')) ?>
<?= $form->field($model, 'color')->label(yii::t('easyii', 'Color')) ?>
<?= $form->field($model, 'link') ?>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>