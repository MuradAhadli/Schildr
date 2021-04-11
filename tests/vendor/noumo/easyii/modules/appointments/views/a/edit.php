<?php
use yii\helpers\Html;

$this->title = $model->doctorName;
?>
<?= $this->render('_menu') ?>

    <table class="table table-striped">
        <caption>Randevu məlumatları</caption>
        <tr>
            <th>Arzu olunan həkim</th>
            <td><?= $model->doctorName ?></td>
        </tr>
        <tr>
            <th>Arzu olunan vaxt</th>
            <td><?= $model->date_from.' - '.$model->date_to ?></td>
        </tr>
        <tr>
            <th>Mesaj</th>
            <td><?= Html::encode($model->message) ?></td>
        </tr>
    </table>

    <table class="table table-striped">
        <caption>Xəstə məlumatları</caption>
        <tr>
            <th>Ad</th>
            <td><?= Html::encode($model->patient['username']) ?></td>
        </tr>
        <tr>
            <th><?= Yii::t('db', 'birthday') ?></th>
            <td><?= Html::encode(date('d.m.Y', $model->patient['birthday'])) ?></td>
        </tr>
        <tr>
            <th><?= Yii::t('db', 'phone') ?></th>
            <td><?= Html::encode($model->patient['phone']) ?></td>
        </tr>
        <tr>
            <th><?= Yii::t('db', 'email') ?></th>
            <td><?= Html::encode($model->patient['email']) ?></td>
        </tr>
    </table>

<?php

if(($model->status == $model::STATUS_NEW) || ($model->status == $model::STATUS_WAIT)) {

   echo $this->render('_form', ['model' => $model]);
}
else if($model->status == $model::STATUS_ACCEPT) {

    echo '<h3 class="text-'.$model->statusLabel.'"> <b>Randevu vaxti:</b>  '.date('d.m.y, H:i', $model->exact_time).'</h3>';
    echo '<div class="text-'.$model->statusLabel.'"> <b>Mesaj:</b>  '.\yii\helpers\HtmlPurifier::process($model->doctor_message).'</div>';
}
else {
    echo '<div class="text-'.$model->statusLabel.'"> <b>Mesaj:</b>  '.\yii\helpers\HtmlPurifier::process($model->doctor_message).'</div>';
}

?>