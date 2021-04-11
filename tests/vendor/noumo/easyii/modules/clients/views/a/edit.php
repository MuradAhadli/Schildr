<?php
$this->title = $model->name;
?>
<?= $this->render('_menu') ?>

<?= $this->render('_form', ['model' => $model]) ?>