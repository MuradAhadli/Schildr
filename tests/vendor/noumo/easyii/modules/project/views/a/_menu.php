<?php
use yii\helpers\Url;
$action = $this->context->action->id;
$module = $this->context->module->id;
?>
<ul class="nav nav-pills">
    <li <?= ($action === 'index') ? 'class="active"' : '' ?>>
        <a href="<?= $this->context->getReturnUrl(['/admin/'.$module]) ?>">
            <?php if($action == 'edit' || $action == 'photos') : ?>
                <i class="glyphicon glyphicon-chevron-left font-12"></i>
            <?php endif; ?>
            <?= Yii::t('easyii', 'List') ?>
        </a>
    </li>
    <li <?= ($action === 'create') ? 'class="active"' : '' ?>><a href="<?= Url::to(['/admin/'.$module.'/a/create']) ?>"><?= Yii::t('easyii', 'Create') ?></a></li>
    <li class="active category-helper">
        <a href="<?= Url::to('/admin/projectcategory') ?>" ><?= yii::t('db', 'Project Category'); ?></a>
    </li>
</ul>
<br/>