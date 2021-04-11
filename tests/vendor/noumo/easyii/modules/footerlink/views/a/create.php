<?php
$this->title = Yii::t('easyii', 'Create Footer Link');
?>
<?= $this->render('_menu') ?>
<?= $this->render('_form', [
    'model' => $model,
    'footerLinks' => $footerLinks,

]) ?>