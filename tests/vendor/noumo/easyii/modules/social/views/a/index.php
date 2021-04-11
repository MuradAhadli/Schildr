<?php
use yii\helpers\Url;
use yii\easyii\models\Constants;
use yii\helpers\Html;
use yii\easyii\assets\FontAwesomeAsset;

FontAwesomeAsset::register($this);

$this->title = Yii::t('easyii', 'Social Media');

$module = $this->context->module->id;
?>


<?= $this->render('_menu') ?>

<?php if($data->count > 0) : ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th width="40">#</th>

                <th><?= Yii::t('easyii', 'Icon') ?></th>

                <th><?= Yii::t('easyii', 'Link') ?></th>
                <th width="80"></th>
                <th width="120"></th>
            </tr>
        </thead>
        <tbody>
    <?php foreach($data->models as $item) : ?>
            <tr data-id="<?= $item->primaryKey ?>">

                <td><?= $item->primaryKey ?></td>

                <td class="social-icon">
                    <a href="<?= Url::to(['/admin/'.$module.'/a/edit', 'id' => $item->primaryKey]) ?>" style="background-color: <?= $item->color ?>">
                        <i class="fa fa-lg <?= $item->icon ?>"></i>
                    </a>
                </td>
                <td><a href="<?= Url::to(['/admin/'.$module.'/a/edit', 'id' => $item->primaryKey]) ?>"><?= $item->link ?></a></td>

                <td class="status">
                    <?= Html::checkbox('', $item['status'] == Constants::STATUS_ON, [
                        'class' => 'switch-status switch',
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
    <?= yii\widgets\LinkPager::widget([
        'pagination' => $data->pagination
    ]) ?>
<?php else : ?>
    <p><?= Yii::t('easyii', 'No records found') ?></p>
<?php endif; ?>