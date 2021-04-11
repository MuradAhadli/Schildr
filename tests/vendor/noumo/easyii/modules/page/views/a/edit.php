<?php
$this->title = Yii::t('easyii', 'Edit page');
?>
<?= $this->render('_menu') ?>

<?= $this->render('_submenu', ['model' => $model]) ?>

<?= $this->render('_form', ['model' => $model]) ?>