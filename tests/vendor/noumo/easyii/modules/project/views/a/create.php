<?php
$this->title = Yii::t('easyii', 'Create Project');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', [
    'model' => $model,
    'category' => $category

]) ?>