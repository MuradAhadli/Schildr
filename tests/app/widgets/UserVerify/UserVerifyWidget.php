<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 5/15/2018
 * Time: 5:56 PM
 */

namespace app\widgets\UserVerify;


use app\models\user\VerificationCodeForm;
use yii\base\Widget;

class UserVerifyWidget extends Widget
{
    public $form_id;
    public $phone_id;
    public $depend;

    public function run()
    {
        return $this->render('index', [
            'model' => new VerificationCodeForm(),
            'form_id' => $this->form_id,
            'phone_id' => $this->phone_id,
            'depend' => $this->depend
        ]);
    }
}