<?php
use yii\helpers\Html;
use yii\easyii\modules\feedback\models\Feedback;
use yii\widgets\ActiveForm;

$this->title = Yii::t('db', 'View feedback');
$this->registerCss('.feedback-view dt{margin-bottom: 10px;}');

if($model->status == Feedback::STATUS_ANSWERED) {
    $this->registerJs('$(".send-answer").click(function(){return confirm("'.Yii::t('db', 'Are you sure you want to resend the answer?').'");})');
}
?>
<?= $this->render('_menu', ['noanswer' => $model->status == Feedback::STATUS_ANSWERED]) ?>

<dl class="dl-horizontal feedback-view">
    <dt><?= Yii::t('db', 'Name') ?></dt>
    <dd><?= $model->name ?></dd>

    <dt><?= Yii::t('db', 'email') ?></dt>
    <dd><?= $model->email ?></dd>

    <?php if($this->context->module->settings['enablePhone']) : ?>
    <dt><?= Yii::t('db', 'phone') ?></dt>
    <dd><?= $model->phone ?></dd>
    <?php endif; ?>

    <?php if($this->context->module->settings['enableTitle']) : ?>
    <dt><?= Yii::t('db', 'Title') ?></dt>
    <dd><?= $model->title ?></dd>
    <?php endif; ?>

    <dt><?= Yii::t('db', 'IP') ?></dt>
    <dd><?= $model->ip ?> <a href="//freegeoip.net/?q=<?= $model->ip ?>" class="label label-info" target="_blank">info</a></dd>

    <dt><?= Yii::t('db', 'date') ?></dt>
    <dd><?= date('d-m-Y,H:i',$model->time) ?></dd>

    <dt><?= Yii::t('db', 'Subject') ?></dt>
    <dd><?= nl2br($model->subject) ?></dd>

    <dt><?= Yii::t('db', 'Text') ?></dt>
    <dd><?= nl2br($model->text) ?></dd>
</dl>

<hr>
<h2><small><?= Yii::t('db', 'Answer') ?></small></h2>

<?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'answer_subject')->textInput(['value' => '']) ?>
    <?= $form->field($model, 'answer_text')->widget(\dosamigos\tinymce\TinyMce::className(),[
        'options' => ['rows' => 10],
]) ?>
    <?= Html::submitButton(Yii::t('db', 'Send'), ['class' => 'btn btn-success send-answer']) ?>
<?php ActiveForm::end() ?>






























