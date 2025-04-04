<?php
use yii\helpers\Url;

$action = $this->context->action->id;
$module = $this->context->module->id;

?>
<ul class="nav nav-pills">
    <li <?= ($action === 'index') ? 'class="active"' : '' ?>>
        <a href="<?= $this->context->getReturnUrl(['/admin/'.$module]) ?>">
            <?php if($action == 'edit' || $action == 'photos' ) : ?>
                <i class="glyphicon glyphicon-chevron-left font-12"></i>
            <?php endif; ?>
            <?= Yii::t('db', 'List') ?>
        </a>
    </li>
    <li <?= ($action === 'create') ? 'class="active"' : '' ?>>
        <a href="<?= Url::to(['/admin/'.$module.'/a/create']) ?>">
            <?= Yii::t('db', 'Create') ?>
        </a>
    </li>
    <?php if ($action == 'index'): ?>
        <li class="active pull-right">
            <a href="<?= Url::to(['/admin/checkupform']) ?>">
                Check-up formu
            </a>
        </li>
        <li class="active pull-right">
            <a href="<?= Url::to(['/admin/examination']) ?>">
                Check-up xidmətləri
            </a>
        </li>
    <?php endif; ?>
</ul>
<br/>