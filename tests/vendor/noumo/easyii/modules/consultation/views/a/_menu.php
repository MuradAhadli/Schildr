<?php
use yii\helpers\Url;
use yii\easyii\modules\consultation\models\Consultation;

$action = $this->context->action->id;
$module = $this->context->module->id;

$noAnswer = Consultation::getCountNoAnswer();
$new = Consultation::getCountNew();

$backTo = null;
$indexUrl = Url::to(['/admin/'.$module]);
$noanswerUrl = Url::to(['/admin/'.$module.'/a/noanswer/']);
$allUrl = Url::to(['/admin/'.$module.'/a/all']);

//\yii\helpers\VarDumper::dump($data,10,1); die();
if($action === 'view')
{
    $returnUrl = $this->context->getReturnUrl($indexUrl);

    if(strpos($returnUrl, 'noanswer') !== false){
        $backTo = 'noanswer';
        $noanswerUrl = $returnUrl;
    } elseif(strpos($returnUrl, 'all') !== false) {
        $backTo = 'all';
        $allUrl = $returnUrl;
    } else {
        $backTo = 'index';
        $indexUrl = $returnUrl;
    }
}
?>
<ul class="nav nav-pills">
    <li <?= ($action === 'index') ? 'class="active"' : '' ?>>
        <a href="<?= $indexUrl ?>">
            <?php if($backTo === 'index') : ?>
                <i class="glyphicon glyphicon-chevron-left font-12"></i>
            <?php endif; ?>
            <?= Yii::t('db', 'New') ?>
            <?php if($this->context->new > 0) : ?>
                <span class="badge"><?= $new ?></span>
            <?php endif; ?>
        </a>
    </li>
    <li <?= ($action === 'noanswer') ? 'class="active"' : '' ?>>
        <a href="<?= $noanswerUrl ?>">
            <?php if($backTo === 'noanswer') : ?>
                <i class="glyphicon glyphicon-chevron-left font-12"></i>
            <?php endif; ?>
            <?= Yii::t('db', 'No answer') ?>
            <?php if($this->context->noAnswer > 0) : ?>
                <span class="badge"><?= $noAnswer ?></span>
            <?php endif; ?>
        </a>
    </li>
    <li <?= ($action === 'all') ? 'class="active"' : '' ?>>
        <a href="<?= $allUrl ?>">
            <?php if($backTo === 'all') : ?>
                <i class="glyphicon glyphicon-chevron-left font-12"></i>
            <?php endif; ?>
            <?= Yii::t('db', 'All') ?>
        </a>
    </li>

</ul>
<br/>
