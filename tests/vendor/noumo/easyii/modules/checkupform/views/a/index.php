<?php
use yii\easyii\models\Constants;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\easyii\components\Helper;
use yii\easyii\modules\checkupform\models\CheckUp;

$this->title = Yii::t('db', 'Appointments');

$module = $this->context->module->id;
?>

<?php if(count($datas) > 0) : ?>
    <table class="table table-hover">
        <thead>
        <tr>
            <th width="50">#</th>
            <th><?= Yii::t('db', 'Check-up') ?></th>
            <th><?= Yii::t('db', 'User') ?></th>
            <th><?= Yii::t('db', 'Create date') ?></th>
            <th width="60"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($datas as $data): ?>

            <tr data-id="<?= $data['form_id'] ?>" class="<?= CheckUp::getStatusClass($data['status']) ?>">

                <td><?= $data['form_id'] ?></td>
                <td><?= $data['checkup_name'] ?></td>
                <td><?= $data['username'] ?></td>
                <td><?= strftime('%d.%m.%Y, %H:%M', $data['created_at'] ) ?></a></td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">

                        <? \yii\widgets\ActiveForm::begin() ?>

                        <?= Html::a('<span class="glyphicon glyphicon-edit"></span>',
                            Url::to(['/admin/'.$module.'/a/edit/', 'id' => $data['form_id']]),
                            ['class' => 'btn btn-default']) ?>

                        <? \yii\widgets\ActiveForm::end(); ?>

                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?= yii\widgets\LinkPager::widget([
        'pagination' => $pages
    ]) ?>
<?php else : ?>
    <p><?= Yii::t('easyii', 'No records found') ?></p>
<?php endif; ?>