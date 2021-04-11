<?php
use yii\easyii\models\Constants;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\easyii\components\Helper;

$this->title = Yii::t('db', 'Appointments');

$module = $this->context->module->id;
?>

<?= $this->render('_menu') ?>

<?php if($data->count > 0) : ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th width="50">#</th>
                <th><?= Yii::t('db', 'doctor_admin') ?></th>
                <th><?= Yii::t('db', 'User') ?></th>
                <th><?= Yii::t('db', 'Appoitment time') ?></th>
                <th><?= Yii::t('db', 'Create date') ?></th>
                <th width="60"></th>
            </tr>
        </thead>
        <tbody>
    <?php foreach($data->models as $item):$item->statusLabel ?>

            <tr data-id="<?= $item->primaryKey ?>" class="<?= $item->statusLabel ?>">

                <td><?= $item->primaryKey ?></td>
                <td><?= $item->doctorName ?></td>
                <td><?= $item->patient['username'] ?></td>
                <td><?= $item->randevuTime ?></a></td>
                <td><?= strftime('%d.%m.%Y, %H:%M', $item->created_at) ?></a></td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">

                        <? \yii\widgets\ActiveForm::begin() ?>

                        <?= Html::a('<span class="glyphicon glyphicon-edit"></span>',
                            Url::to(['/admin/'.$module.'/a/edit/', 'id' => $item->primaryKey]),
                            ['class' => 'btn btn-default']) ?>

                        <? \yii\widgets\ActiveForm::end(); ?>

                    </div>
                </td>
            </tr>
    <?php endforeach; ?>
        </tbody>
    </table>
    <?= yii\widgets\LinkPager::widget([
        'pagination' => $data->pagination
    ]) ?>
<?php else : ?>
    <p><?= Yii::t('easyii', 'No records found') ?></p>
<?php endif; ?>