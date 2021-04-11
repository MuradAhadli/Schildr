<?php
$this->title = Yii::t('easyii', 'Create Systems');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>