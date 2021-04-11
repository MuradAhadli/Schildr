<?php
use yii\helpers\Url;
use yii\helpers\Html;
use \yii\easyii\modules\page\models\Page;

$this->title = Yii::t('easyii', 'Pages');

$module = $this->context->module->id;
?>

<?= $this->render('_menu') ?>

<?php if(count($models) > 0) : ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <?php if(IS_ROOT) : ?>
                    <th width="50">#</th>
                <?php endif; ?>
                <th><?= Yii::t('easyii', 'Title')?></th>
                <?php if(IS_ROOT) : ?>
                    <th><?= Yii::t('easyii', 'Slug')?></th>
                    <th width="100"><?= Yii::t('easyii', 'Status')?></th>
                    <th width="120"</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
    <?php
        $i = 0;

        foreach($models[0] as $model) :
            $i++;
    ?>
            <tr>
                <?php if(IS_ROOT) : ?>
                    <td><?= $i ?></td>
                <?php endif; ?>
                <td><a href="<?= Url::to(['/admin/'.$module.'/a/edit', 'id' => $model['id']]) ?>"><?= $model['title'] ?></a></td>

                <?php if(IS_ROOT) : ?>
                    <td><?= $model['slug'] ?></td>
                    <td class="status">
                        <?= Html::checkbox('', $model['status'] == Page::STATUS_ON, [
                            'class' => 'switch',
                            'data-id' => $model['id'],
                            'data-link' => Url::to(['/admin/'.$module.'/a']),
                        ]) ?>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="<?= Url::to(['/admin/'.$module.'/a/up', 'id' => $model['id']]) ?>" class="btn btn-default move-up" title="<?= Yii::t('easyii', 'Move up') ?>"><span class="glyphicon glyphicon-arrow-up"></span></a>
                            <a href="<?= Url::to(['/admin/'.$module.'/a/down', 'id' => $model['id']]) ?>" class="btn btn-default move-down" title="<?= Yii::t('easyii', 'Move down') ?>"><span class="glyphicon glyphicon-arrow-down"></span></a>
                            <a href="<?= Url::to(['/admin/'.$module.'/a/delete', 'id' => $model['id']]) ?>" class="btn btn-default confirm-delete" title="<?= Yii::t('easyii', 'Delete item') ?>"><span class="glyphicon glyphicon-remove"></span></a>
                        </div>
                    </td>
            </tr>
                <?php endif; ?>
            </tr>
        <?php if (isset($models[$model['id']])):
                $j = 0;
            ?>

            <?php foreach ($models[$model['id']] as $key => $value):
                 $j++;
            ?>

                <tr class="submenu">
                <?php if(IS_ROOT) : ?>
                     <td class="number"><?= $i.'.'.$j ?></td>
                <?php endif; ?>
                     <td><a class="name" href="<?= Url::to(['/admin/'.$module.'/a/edit', 'id' => $value['id']]) ?>"><?= $value['title'] ?></a></td>

                <?php if(IS_ROOT) : ?>
                    <td><?= $value['slug'] ?></td>
                    <td class="status">
                        <?= Html::checkbox('', $value['status'] == Page::STATUS_ON, [
                            'class' => 'switch',
                            'data-id' => $value['id'],
                            'data-link' => Url::to(['/admin/'.$module.'/a']),
                        ]) ?>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="<?= Url::to(['/admin/'.$module.'/a/up', 'id' => $value['id']]) ?>" class="btn btn-default move-up" title="<?= Yii::t('easyii', 'Move up') ?>"><span class="glyphicon glyphicon-arrow-up"></span></a>
                            <a href="<?= Url::to(['/admin/'.$module.'/a/down', 'id' => $value['id']]) ?>" class="btn btn-default move-down" title="<?= Yii::t('easyii', 'Move down') ?>"><span class="glyphicon glyphicon-arrow-down"></span></a>
                            <a href="<?= Url::to(['/admin/'.$module.'/a/delete', 'id' => $value['id']]) ?>" class="btn btn-default confirm-delete" title="<?= Yii::t('easyii', 'Delete item') ?>"><span class="glyphicon glyphicon-remove"></span></a>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>

            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>
        </tbody>
    </table>

<?php else : ?>
    <p><?= Yii::t('easyii', 'No records found') ?></p>
<?php endif; ?>