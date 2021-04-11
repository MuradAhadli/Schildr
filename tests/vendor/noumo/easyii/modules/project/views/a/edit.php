<?php
$this->title = $model->translation->title;
?>
<?= $this->render('_menu') ?>

<?= $this->render('_form', [
    'model' => $model,
    'category' => $category,
    'uploads' => $uploads,
]) ?>