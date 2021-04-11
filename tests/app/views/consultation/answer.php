<?php
/**
 * Created by PhpStorm.
 * User: idealand
 * Date: 7/9/18
 * Time: 21:50
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Cavab';

?>

<?php $form = ActiveForm::begin(); ?>
<center><a class="navbar-brand m-0" target="_blank" style="padding-top: 30px;" href="<?= Url::to(['/']) ?>"><img src="<?= yii::getAlias('@web') ?>/app/media/img/logo.jpg"></a></center>
<div style="padding: 30px">
    <?php if(empty($message)){ ?>

    <?php if($model->private != 1){ ?>
        <?php if(!empty($model->phone)){ ?>
        <div>Mobil: <b><?=$model->phone?></b></div>
        <?php } ?>
        <?php if(!empty($model->birthday)){ ?>
        <div>Doğum tarixi: <b><?=date('d.m.Y', $model->birthday)?></b></div>
        <?php } ?>
        <?php if(!empty($model->email)){ ?>
        <div>Email: <b><?=$model->email?></b></div>
        <?php } ?>
        <?php if(!empty($model->firstname) && !empty($model->lastname)){ ?>
        <div>Ad, Soyad: <b><?=$model->firstname?> <?=$model->lastname?></b></div>
        <?php } ?>
    <?php } ?>

    <?php if(!empty($model->department_id)){ ?>
    <div>Şöbə: <b><?=$department?></b></div>
    <?php } ?>
    <?php if(!empty($model->assign)){ ?>
    <div>Həkim: <b><?=$doctor?></b></div>
    <?php } ?>
    <?php if(!empty($model->cretaed_by)){ ?>
    <div>Yaradıb: <b><?=$model->cretaed_by?></b></div>
    <?php } ?>
    <?php if(!empty($model->created_at)){ ?>
    <div>Tarix: <b><?=date('d.m.Y', $model->created_at)?></b></div>
    <?php } ?>
    <?php if(!empty($model->text)){ ?>
    <br />
    <div>Sual: <b><?=$model->text?></b></div>
    <?php } ?>
    <br />
    <?= $form->field($model, 'answer_text')->textarea(['rows' => 5])->label('Cavab:')?>

    <center><?= Html::submitButton('GÖNDƏR', ['class' => 'btn btn-success']) ?></center>

    <?php }else{ ?>
        <center><h3><?=$message?></h3></center>
    <?php } ?>

    <?php ActiveForm::end(); ?>
</div>