<?php

use yii\easyii\modules\productcategory\models\ProductCategory;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;

$this->title = Yii::t('easyii', 'Product category');

$module = $this->context->module->id;

?>

<?= $this->render('_menu') ?>

<?php if (count($productCategories) > 0) : ?>
    <table class="table table-responsive table-hover">
        <thead>
            <th><?= yii::t('db', 'Id') ?></th>
            <th><?= yii::t('db', 'Title') ?></th>
            <th><?= yii::t('db', 'Image') ?></th>
            <th><?= yii::t('db', 'Status') ?></th>
            <th><?= yii::t('db', 'Order') ?></th>
        </thead>

        <?php foreach ($productCategories as $key => $val): ?>

        <?php $val = array_values($val)[0] ?>

            <tr>
                <td><?= $val['self']['id'] ?></td>
                <td>
                    <a href="<?= Url::to(['/admin/'.$module.'/a/edit', 'id' => $val['self']['id']]) ?>">
                        <?= $val['self']['title'] ?>
                    </a>
                </td>
                <td>
                    <a href="<?= Url::to(['/admin/'.$module.'/a/edit', 'id' => $val['self']['id']]) ?>">
                        <img width="120" src="<?= $val['self']['image'] ?>" alt="">
                    </a>
                </td>
                <td class="status vtop">
                    <?= Html::checkbox('', $val['self']['status'] == ProductCategory::STATUS_ON, [
                        'class' => 'switch',
                        'data-id' => $val['self']['id'],
                        'data-link' => Url::to(['/admin/'.$module.'/a/']),
                    ]) ?>
                </td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="<?= Url::to(['/admin/'.$module.'/a/up', 'id' => $val['self']['id']]) ?>" class="btn btn-default move-up" title="<?= Yii::t('easyii', 'Move up') ?>"><span class="glyphicon glyphicon-arrow-up"></span></a>
                        <a href="<?= Url::to(['/admin/'.$module.'/a/down', 'id' => $val['self']['id']]) ?>" class="btn btn-default move-down" title="<?= Yii::t('easyii', 'Move down') ?>"><span class="glyphicon glyphicon-arrow-down"></span></a>
                        <a href="<?= Url::to(['/admin/'.$module.'/a/delete', 'id' => $val['self']['id']]) ?>" class="btn btn-default confirm-delete" title="<?= Yii::t('easyii', 'Delete item') ?>"><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                </td>

            </tr>
            <?php if (is_array($val) && !empty($val)): ?>
                <?php
                $i = 0;
                foreach ($val['child'] as $item): ?>

                    <?php if (is_array($item) && !empty($item)): $i++?>
                        <tr style="border-left: 1px solid #000;">
                            <td><?= $val['self']['id']?><span style="font-size: 13px"><?= '.' . $i ?></span></td>
                            <td>
                                <a href="<?= Url::to(['/admin/'.$module.'/a/edit', 'id' => $item['id']]) ?>" style="font-size: 13px !important;">
                                    <?= $item['title'] ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?= Url::to(['/admin/'.$module.'/a/edit', 'id' => $item['id']]) ?>">
                                    <img width="80" src="<?= $item['image'] ?>" alt="">
                                </a>
                            </td>
                            <td class="status vtop">
                                <?= Html::checkbox('', $item['status'] == ProductCategory::STATUS_ON, [
                                    'class' => 'switch',
                                    'data-id' => $item['id'],
                                    'data-link' => Url::to(['/admin/'.$module.'/a/']),
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
                    <?php endif; ?>

                <?php endforeach; ?>

            <?php endif; ?>

        <?php endforeach; ?>

    </table>
<?php else : ?>
    <p><?= Yii::t('easyii', 'No records found') ?></p>
<?php endif; ?>
