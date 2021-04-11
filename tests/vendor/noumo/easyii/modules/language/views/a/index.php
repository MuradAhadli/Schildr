<?php
use yii\helpers\Url;

$this->title = Yii::t('easyii', 'Languages');

$module = $this->context->module->id;
?>

<?= $this->render('_menu') ?>

<?php \yii\widgets\Pjax::begin() ?>

<?php if($data->count > 0) : ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th width="50">#</th>
                <th><?= Yii::t('easyii', 'Text') ?></th>
                <th width="30"></th>
            </tr>
        </thead>
        <tbody>
    <?php $i=0; foreach($data->models as $item) : $i++; ?>
            <tr>
                <td><?= $i ?></td>
                <td><a href="<?= Url::to(['/admin/'.$module.'/a/edit', 'id' => $item->primaryKey]) ?>"><?= $item->message ?></a></td>
                <td><a href="<?= Url::to(['/admin/'.$module.'/a/delete', 'id' => $item->primaryKey]) ?>" class="glyphicon glyphicon-remove confirm-delete" title="<?= Yii::t('easyii', 'Delete item') ?>"></a></td>
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

<?php \yii\widgets\Pjax::end() ?>
