<?php
$this->title = Yii::t('easyii', 'Create Partners');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', [
    'model' => $model,
    'clients' => $clients
]) ?>