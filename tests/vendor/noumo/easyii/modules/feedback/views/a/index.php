<?php
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\easyii\modules\feedback\models\Feedback;

$this->title = Yii::t('db', 'Feedback_admin');
$module = $this->context->module->id;
?>

<?= $this->render('_menu') ?>

<?php if($data->count > 0) : ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <?php if(IS_ROOT) : ?>
                    <th width="50">#</th>
                <?php endif; ?>
                <th><?= Yii::t('db', $this->context->module->settings['enableTitle'] ? 'Title' : 'Text') ?></th>
                <th width="150"><?= Yii::t('db', 'date') ?></th>
                <th width="100"><?= Yii::t('db', 'Answer') ?></th>
                <th width="30"></th>
            </tr>
        </thead>
        <tbody>
    <?php foreach($data->models as $item) : ?>
            <tr>
                <?php if(IS_ROOT) : ?>
                    <td><?= $item->primaryKey ?></td>
                <?php endif; ?>
                <td><a href="<?= Url::to(['/admin/'.$module.'/a/view', 'id' => $item->primaryKey]) ?>"><?= ($this->context->module->settings['enableTitle'] && $item->title != '') ? $item->title : StringHelper::truncate($item->text, 64, '...')?></a></td>
                <td><?= date('d-m-Y, H:i',$item->time) ?></td>
                <td>
                    <?php if($item->status == Feedback::STATUS_ANSWERED) : ?>
                        <span class="text-success"><?= Yii::t('db', 'Yes') ?></span>
                    <?php else : ?>
                        <span class="text-danger"><?= Yii::t('db', 'No') ?></span>
                    <?php endif; ?>
                </td>
                <td><a href="<?= Url::to(['/admin/'.$module.'/a/delete', 'id' => $item->primaryKey]) ?>" class="glyphicon glyphicon-remove confirm-delete" title="<?= Yii::t('db', 'Delete item') ?>"></a></td>
            </tr>
    <?php endforeach; ?>
        </tbody>
    </table>
    <?= yii\widgets\LinkPager::widget([
        'pagination' => $data->pagination
    ]) ?>
<?php else : ?>
    <p><?= Yii::t('db', 'No records found') ?></p>
<?php endif; ?>