<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\easyii\assets\AdminAsset;
use yii\easyii\modules\consultation\models\Consultation;
use \yii\easyii\modules\appointments\models\Appointments;

//echo yii::$app->language;
$asset = AdminAsset::register($this);
$moduleName = $this->context->module->id;

$id = [];

$get = yii::$app->request->get();

if (isset($get['id']))
    $id = ['id' => $get['id']];

?>
<?php $this->beginPage() ?>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Yii::t('db', 'Control Panel') ?> - <?= Html::encode($this->title) ?></title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,cyrillic'
          rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="<?= $asset->baseUrl ?>/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?= $asset->baseUrl ?>/favicon.ico" type="image/x-icon">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div id="admin-body">
    <div class="container-fluid" style="padding-left: 0px; padding-right: 0px;">
        <div class="wrapper">
            <div class="header">
                <div class="nav">
                    <a href="<?= Yii::$app->homeUrl ?>" target="_blank" class="pull-left"><i
                                class="glyphicon glyphicon-home"></i> <?= Yii::t('db', 'Open site') ?></a>

                    <div class="pull-right">
                        <span class="username"><?= yii::$app->user->identity->username ?></span>
                        <a href="<?= Url::to(['/admin/sign/out']) ?>" class="pull-right"><i
                                    class="glyphicon glyphicon-log-out"></i> <?= Yii::t('db', 'Logout') ?></a>
                    </div>

                    <ul class="pull-right list-inline unstyled mb-0 langs">
                        <?php foreach (yii::$app->params['languages'] as $k => $v):
                            if (yii::$app->language == $k) continue;
                            ?>
                            <li>
                                <a href="<?= Url::to(array_merge(['language' => $k], $id)) ?>"><?= $k ?></a>
                            </li>
                        <?php endforeach; ?>


                    </ul>

                </div>
            </div>
            <div class="main">
                <div class="box sidebar">
                    <div class="logo">
                        <img src="<?= $asset->baseUrl ?>/img/logo_footer.png">
                    </div>
                    <?php foreach (Yii::$app->getModule('admin')->activeModules as $module) : ?>
                        <a href="<?= Url::to(["/admin/$module->name"]) ?>"
                           class="menu-item <?= $module->name . ' ' . ($moduleName == $module->name ? 'active' : '') ?>">
                            <?php if ($module->icon != '') : ?>
                                <i class="fa fa-<?= $module->icon ?>"></i>
                            <?php endif; ?>

                            <?= $module->title; ?>

                            <?php
                            if ($module->module_id == 20)
                                $module->notice = Appointments::getCountNew();

                            if ($module->notice > 0) :?>
                                <span class="badge">
                                        <?php

                                        if ($module->module_id == 28) {
                                            echo Consultation::getCountNew();
                                        } elseif ($module->module_id == 20) {
                                            echo Appointments::getCountNew();
                                        } else {
                                            echo $module->notice;
                                        }

                                        ?>
                                    </span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>

                    <?php if (IS_ROOT && yii::$app->user->id == 1) : ?>
                        <div class="menu-divider"></div>

                        <a href="<?= Url::to(['/admin/settings']) ?>"
                           class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'settings') ? 'active' : '' ?>">
                            <i class="glyphicon glyphicon-cog"></i>
                            <?= Yii::t('db', 'Settings') ?>
                        </a>
                        <a href="<?= Url::to(['/admin/modules']) ?>"
                           class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'modules') ? 'active' : '' ?>">
                            <i class="glyphicon glyphicon-folder-close"></i>
                            <?= Yii::t('db', 'Modules') ?>
                        </a>
                        <a href="<?= Url::to(['/admin/admins']) ?>"
                           class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'admins') ? 'active' : '' ?>">
                            <i class="glyphicon glyphicon-user"></i>
                            <?= Yii::t('db', 'Admins') ?>
                        </a>
                        <a href="<?= Url::to(['/admin/system']) ?>"
                           class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'system') ? 'active' : '' ?>">
                            <i class="glyphicon glyphicon-hdd"></i>
                            <?= Yii::t('db', 'System') ?>
                        </a>
                        <a href="<?= Url::to(['/admin/logs']) ?>"
                           class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'logs') ? 'active' : '' ?>">
                            <i class="glyphicon glyphicon-align-justify"></i>
                            <?= Yii::t('db', 'Logs') ?>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="box content">
                    <div class="page-title">
                        <?= $this->title ?>
                    </div>
                    <div class="container-fluid">
                        <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message) : ?>
                            <div class="alert alert-<?= $key ?>"><?= $message ?></div>
                        <?php endforeach; ?>
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
