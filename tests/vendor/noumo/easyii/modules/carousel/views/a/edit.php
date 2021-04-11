<?php
$this->title = Yii::t('easyii', 'Edit carousel');

?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', [
    'model' => $model,
    'carouselUploads' => $carouselUploads,
    'pages' => $pages,
    'categories' => $categories,
    'altCategory' => $altCategory,
]) ?>