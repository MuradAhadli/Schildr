<?php
$this->title = $model->doctorName;
?>
<?= $this->render('_menu') ?>

<?= $this->render('_form', ['model' => $model]) ?>