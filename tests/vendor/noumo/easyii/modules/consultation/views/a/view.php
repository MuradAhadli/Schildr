<?php
use yii\helpers\Html;
use yii\easyii\modules\consultation\models\Consultation;
use yii\widgets\ActiveForm;
use yii\easyii\modules\doctor\models\Doctor;

$this->title = Yii::t('db', 'View Consultation');
$this->registerCss('.consultation-view dt{margin-bottom: 10px;}');

if($model->status == Consultation::STATUS_ANSWERED) {
    $this->registerJs('$(".send-answer").click(function(){return confirm("'.Yii::t('db', 'Are you sure you want to resend the answer?').'");})');
}
?>
<?= $this->render('_menu', ['noanswer' => $model->status == Consultation::STATUS_ANSWERED]) ?>

<dl class="dl-horizontal feedback-view">
    <dt><?= Yii::t('db', 'Name') ?></dt>
    <dd><?= $model->firstname ?></dd>

    <dt><?= Yii::t('db', 'email') ?></dt>
    <dd><?= $model->email ?></dd>

    <dt><?= Yii::t('db', 'phone') ?></dt>
    <dd><?= $model->phone ?></dd>

    <?php if($this->context->module->settings['enableTitle']) : ?>
    <dt><?= Yii::t('db', 'Title') ?></dt>
    <dd><?= $model->title ?></dd>
    <?php endif; ?>

    <dt><?= Yii::t('db', 'date') ?></dt>
    <dd><?= date('d-m-Y, H:i',$model->created_at )?></dd>

    <dt><?= Yii::t('db', 'Text') ?></dt>
    <dd><?= nl2br($model->text) ?></dd>

    <dt><?= Yii::t('db', 'Assign') ?></dt>
    <dd><?= $assign ?></dd>

</dl>

<hr>
<h2><small><?= Yii::t('db', 'Answer') ?></small></h2>

<?php $form = ActiveForm::begin([
        'action' => ['/admin/consultation/a/send-answer/'.$model->id.'']
]) ?>

    <?= $form->field($model, 'answer_subject') ?>
    <?= $form->field($model, 'answer_text')->widget(\dosamigos\tinymce\TinyMce::className(),[
        'options' => ['rows' => 10],
]) ?>
    <?= Html::submitButton(Yii::t('db', 'Send'), ['class' => 'btn btn-success send-answer']) ?>
<?php ActiveForm::end() ?>






























