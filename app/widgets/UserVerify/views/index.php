<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 5/15/2018
 * Time: 5:56 PM
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

\app\assets\UserVerifyAsset::register($this);

?>

<div class="modal fade" id="verify_user_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    <?= Html::encode(yii::t('db', 'Confirm your number')) ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php $form = ActiveForm::begin([
                        'id' => 'verifiy_user_form',
                        'action' => ['/verify-user'],
                        'enableAjaxValidation' => true,
                        'validateOnChange' => false,
                        'validateOnBlur' => false,
                        'fieldConfig' => [
                            'errorOptions' => [
                                'class' => 'invalid-feedback'
                            ],
                            'enableLabel'=>false
                        ]
                    ]);
                ?>

                <?= $form->field($model, 'code') ?>

                <button type="submit" class="btn btn-success float-right">
                    <?= Html::encode(yii::t('db', 'Continue')) ?>
                </button>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>

<div class="loader">
    <img src="<?= yii::getAlias('@web'.'/app/media/img/icon/loader2.svg') ?>">
</div>

<script>
    var form_id = '<?= $form_id ?>';
    var phone_id = '<?= $phone_id ?>';
    var depend = '<?= $depend ?>';
</script>