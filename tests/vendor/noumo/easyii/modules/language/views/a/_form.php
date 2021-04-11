<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\easyii\models\Constants;
\yii\bootstrap\BootstrapPluginAsset::register($this);

?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['class' => 'model-form']
]); ?>

<label>
    <div class="key">
        <?= $model->messageKey ?>
    </div>
</label>

<hr>

    <div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#content_az" aria-controls="home" role="tab" data-toggle="tab"><?= yii::t('easyii', 'Azerbaijan') ?></a></li>
            <li role="presentation"><a href="#content_en" aria-controls="profile" role="tab" data-toggle="tab"><?= yii::t('easyii', 'English') ?></a></li>
            <li role="presentation"><a href="#content_ru" aria-controls="messages" role="tab" data-toggle="tab"><?= yii::t('easyii', 'Russian') ?></a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">

            <?php $i = 0; foreach (yii::$app->params['languages'] as $k => $v): ?>

                <div role="tabpanel" class="tab-pane <?= ($i == 0) ? 'active' : ''?>" id="content_<?= $k ?>">

                    <?= $form->field($model, 'translation')
                        ->textarea([
                            'name' => 'Message[translation]['.$k    .']',
                            'value' => isset($messages[$i]) ? $messages[$i]['translation'] : '',
                            'required'=>'required',
                        ])
                        ->label(yii::t('easyii', 'Name')) ?>
                </div>

            <?php $i++; endforeach; ?>

        </div>
    </div>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>