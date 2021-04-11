<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 5/16/2018
 * Time: 12:26 PM
 */

namespace app\models\user;

use yii;
use yii\base\Model;
use yii\helpers\Html;

class VerificationCodeForm extends Model
{
    // Session Key - verification_code
    const SK_VC = 'verification_code';

    // Session Key - verified_user
    const SK_VU = 'verified_user';

    // Session Value - verified
    const SV_VU = 'verified';

    public $code;

    public function rules()
    {
        return [
            ['code', 'required'],
            ['code', 'integer'],
            ['code', 'validateCode']
        ];
    }

    public function validateCode()
    {
        $session = yii::$app->session;

        if($session->get(self::SK_VC) == $this->code) {

            $session->set(self::SK_VU, self::SV_VU);

            $session->remove(VerificationCodeForm::SK_VC);

            return true;
        }

        $this->addError('code', Html::encode(yii::t('db', 'Wrong verification code')));
    }

    /**
     * @param $phone
     * @param $message
     */
    public static function sendSms($phone, $message)
    {
        //Comment when commit
//        return $message;

        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                    <SMS-InsRequest>
                        <CLIENT from="MEDILAND" pwd="M3d1l4nd" user="medilandapi"/>
                        <INSERT datacoding="0" to="'.$phone.'" >
                            <TEXT>'.$message.'</TEXT>
                        </INSERT>
                    </SMS-InsRequest>';

        $url = 'http://89.108.99.126/sendsmsapi/';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_PROXY, false);
        $output = curl_exec($ch);
        if(curl_errno($ch))
        {
            echo 'Error curl: ' . curl_error($ch);
        }
//        print($output);
        curl_close($ch);
    }
}