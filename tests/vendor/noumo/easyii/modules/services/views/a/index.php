<?php
use yii\easyii\modules\services\models\Services;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('db', 'Services');

$module = $this->context->module->id;
?>

<?= $this->render('_menu') ?>

<?php if($services) : ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th width="50">#</th>
                <th><?= Yii::t('db', 'Title') ?></th>
                <th width="100"><?= Yii::t('db', 'Status') ?></th>
                <th width="120"></th>
            </tr>
        </thead>
        <tbody>

    <?php $i=0; foreach($services[0] as $item) : $i++; ?>
            <tr>
                <td><?= $i ?></td>
                <td><a href="<?= Url::to(['/admin/'.$module.'/a/edit/', 'id' => $item['id']]) ?>"><?= $item['translation']['name'] ?></a></td>
                <td class="status">
                    <?= Html::checkbox('', $item['status'] == Services::STATUS_ON, [
                        'class' => 'switch',
                        'data-id' => $item['id'],
                        'data-link' => Url::to(['/admin/'.$module.'/a']),
                    ]) ?>
                </td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="<?= ($i > 1) ? Url::to(['/admin/'.$module.'/a/up', 'id' => $item['id']]) : '#' ?>" class="btn btn-default move-up" title="<?= Yii::t('db', 'Move up') ?>"><span class="glyphicon glyphicon-arrow-up"></span></a>
                        <a href="<?= ($i < count($services[0])) ? Url::to(['/admin/'.$module.'/a/down', 'id' => $item['id']]) : '#' ?>" class="btn btn-default move-down" title="<?= Yii::t('db', 'Move down') ?>"><span class="glyphicon glyphicon-arrow-down"></span></a>
                        <a href="<?= Url::to(['/admin/'.$module.'/a/delete', 'id' => $item['id']]) ?>" class="btn btn-default confirm-delete" title="<?= Yii::t('db', 'Delete item') ?>"><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                </td>
            </tr>

    <?php if(isset($services[$item['id']])): ?>

            <?php $j = 0; foreach ($services[$item['id']] as $k => $v): $j++ ?>

                <tr class="submenu">
                    <td class="number"><?= $i.'.'.$j ?></td>
                    <td><a class="name" href="<?= Url::to(['/admin/'.$module.'/a/edit/', 'id' => $v['id']]) ?>"><?= $v['translation']['name'] ?></a></td>
                    <td class="status">
                        <?= Html::checkbox('', $v['status'] == Services::STATUS_ON, [
                            'class' => 'switch',
                            'data-id' => $v['id'],
                            'data-link' => Url::to(['/admin/'.$module.'/a']),
                        ]) ?>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="<?= ($j > 1) ? Url::to(['/admin/'.$module.'/a/up', 'id' => $v['id']]) : '#' ?>" class="btn btn-default move-up" title="<?= Yii::t('db', 'Move up') ?>"><span class="glyphicon glyphicon-arrow-up"></span></a>
                            <a href="<?= ($j < count($services[$item['id']])) ? Url::to(['/admin/'.$module.'/a/down', 'id' => $v['id']]) : '#' ?>" class="btn btn-default move-down" title="<?= Yii::t('db', 'Move down') ?>"><span class="glyphicon glyphicon-arrow-down"></span></a>
                            <a href="<?= Url::to(['/admin/'.$module.'/a/delete', 'id' => $v['id']]) ?>" class="btn btn-default confirm-delete" title="<?= Yii::t('db', 'Delete item') ?>"><span class="glyphicon glyphicon-remove"></span></a>
                        </div>
                    </td>
                </tr>

            <?php endforeach; ?>

    <?php endif; ?>

    <?php endforeach; ?>
        </tbody>
    </table>

<?php else : ?>
    <p><?= Yii::t('db', 'No records found') ?></p>
<?php endif; ?>