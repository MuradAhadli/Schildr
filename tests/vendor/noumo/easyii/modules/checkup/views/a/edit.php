<?php
$this->title = $model->name;
?>
<?= $this->render('_menu') ?>

<?= $this->render('_submenu', ['model' => $model]) ?>

<?= $this->render('_form', ['model' => $model]) ?>