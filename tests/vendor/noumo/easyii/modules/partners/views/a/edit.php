<?php
$this->title = $model->full_name;
?>
<?= $this->render('_menu') ?>

<?= $this->render('_form', [
    'model' => $model,
    'clients' => $clients
]) ?>