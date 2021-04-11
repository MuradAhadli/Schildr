<?php

use yii\easyii\modules\clients\models\Clients;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('easyii', 'Project');

$module = $this->context->module->id;


?>
<?//=\yii\helpers\VarDumper::dump($data->models,10,1);die();?>


<?= $this->render('_menu') ?>

<?php if(count($data) > 0) : ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th width="50">#</th>
                <th><?= Yii::t('easyii', 'Title') ?></th>
                <th><?= Yii::t('easyii', 'Category name') ?></th>
                <th width="100"><?= Yii::t('easyii', 'Status') ?></th>
                <th width="120"></th>
            </tr>
        </thead>
        <tbody>
    <?php foreach($data as $key => $item) : ?>

        <tr data-id="<?= $item['id']?>">
                <td><?= $item['id'] ?></td>
                <td><a href="<?= Url::to(['/admin/'.$module.'/a/edit/', 'id' => $item['id']]) ?>"><?= $item['project_title'] ?></a></td>
                <td><?= $item['category_title'] ?></td>
                <td class="status">
                    <?= Html::checkbox('', $item['status'] == Clients::STATUS_ON, [
                        'class' => 'switch',
                        'data-id' => $item['id'],
                        'data-link' => Url::to(['/admin/'.$module.'/a']),
                    ]) ?>
                </td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="<?= Url::to(['/admin/'.$module.'/a/up', 'id' => $item['id']]) ?>" class="btn btn-default move-up" title="<?= Yii::t('easyii', 'Move up') ?>"><span class="glyphicon glyphicon-arrow-up"></span></a>
                        <a href="<?= Url::to(['/admin/'.$module.'/a/down', 'id' => $item['id']]) ?>" class="btn btn-default move-down" title="<?= Yii::t('easyii', 'Move down') ?>"><span class="glyphicon glyphicon-arrow-down"></span></a>
                        <a href="<?= Url::to(['/admin/'.$module.'/a/delete', 'id' => $item['id']]) ?>" class="btn btn-default confirm-delete" title="<?= Yii::t('easyii', 'Delete item') ?>"><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                </td>
            </tr>
    <?php endforeach; ?>
        </tbody>
    </table>

<?php else : ?>
    <p><?= Yii::t('easyii', 'No records found') ?></p>
<?php endif; ?>