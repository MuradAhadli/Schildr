<?php
$this->title = Yii::t('easyii', 'Create carousel');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', [
    'model' => $model,
    'pages' => $pages,
    'categories' => $categories,
    'altCategory' => $altCategory

]) ?>