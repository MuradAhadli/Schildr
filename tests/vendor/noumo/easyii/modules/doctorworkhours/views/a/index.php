<?php
use yii\easyii\models\Constants;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\easyii\components\Helper;

$this->title = Yii::t('easyii', 'Doctor work hours');

$module = $this->context->module->id;
?>

<?= $this->render('_menu') ?>

<?php if($data->count > 0) : ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th width="50">#</th>
                <th><?= Yii::t('easyii', 'Title') ?></th>
                <th><?= Yii::t('easyii', 'Day') ?></th>
                <th><?= Yii::t('easyii', 'Hours') ?></th>
                <th width="100"><?= Yii::t('easyii', 'Status') ?></th>
                <th width="40"></th>
            </tr>
        </thead>
        <tbody>
    <?php foreach($data->models as $item) : ?>
            <tr data-id="<?= $item->primaryKey ?>">
                <td><?= $item->primaryKey ?></td>
                <td><a href="<?= Url::to(['/admin/'.$module.'/a/edit/', 'id' => $item->primaryKey]) ?>"><?= $item->doctorName ?></a></td>

                <?php $item -> day = unserialize($item->day); ?>

                <td>
                    <?php foreach ($item->day as $day){
                        echo Helper::weekDayName($day).',';
                    }?>
                    </a>
                </td>
                <td><?= $item->hourFrom .' - '. $item->hourTo ?></a></td>
                <td class="status">
                    <?= Html::checkbox('', $item->status == Constants::STATUS_ON, [
                        'class' => 'switch',
                        'data-id' => $item->primaryKey,
                        'data-link' => Url::to(['/admin/'.$module.'/a']),
                    ]) ?>
                </td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="<?= Url::to(['/admin/'.$module.'/a/delete', 'id' => $item->primaryKey]) ?>" class="btn btn-default confirm-delete" title="<?= Yii::t('easyii', 'Delete item') ?>"><span class="glyphicon glyphicon-remove"></span></a>
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