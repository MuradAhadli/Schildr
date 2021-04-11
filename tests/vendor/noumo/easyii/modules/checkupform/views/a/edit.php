<?php
use yii\helpers\Html;
use \yii\easyii\modules\checkupform\models\CheckUp;
use \yii\helpers\Url;

$this->title = $model['checkup_name'];
?>

    <table class="table table-striped">
        <caption>Pasient məlumatları</caption>
        <tr>
            <th>Check-up</th>
            <td><?= $model['checkup_name'] ?></td>
        </tr>
        <tr>
            <th>Ad və Soyad</th>
            <td><?= $model['username'] ?></td>
        </tr>
        <tr>
            <th>Doğum tarixi</th>
            <td><?= ($model['birthday']) ? date('d-m-Y',$model['birthday']) : '' ?></td>
        </tr>
        <tr>
            <th>E-mail</th>
            <td><?= $model['email'] ?></td>
        </tr>
        <tr>
            <th>Telefon</th>
            <td><?= $model['phone'] ?></td>
        </tr>
        <tr class="<?= CheckUp::getStatusClass($model['status']) ?>">
            <th>Status</th>
            <td><?= CheckUp::getStatusSituation($model['status']) ?></td>
        </tr>
        <tr>
            <th>Yaranma tarixi</th>
            <td><?= date('d-m-Y, H:i:s',$model['created_at']) ?></td>
        </tr>
        <tr>
            <th>Mesaj</th>
            <td><?= $model['text'] ?></td>
        </tr>
    </table>
<?php if ($model['status'] == 1):?>
        <a href="<?= Url::to(['/admin/checkupform/a/status', 'id' => $model['form_id']]) ?>" class="btn btn-success">Əlaqə saxlanılıb</a>
<?php endif; ?>