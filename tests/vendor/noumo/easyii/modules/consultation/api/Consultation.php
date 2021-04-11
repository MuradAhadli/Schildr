<?php
namespace yii\easyii\modules\consultation\api;

use Yii;
use yii\easyii\modules\consultation\models\Consultation as ConsultationModel;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\easyii\widgets\ReCaptcha;


/**
 * Consultation module API
 * @package yii\easyii\modules\consultation\api
 *
 * @method static string form(array $options = []) Returns fully worked standalone html form.
 * @method static array save(array $attributes) If you using your own form, this function will be useful for manual saving consultation's.
 */

class Consultation extends \yii\easyii\components\API
{
    const SENT_VAR = 'consultation_sent';

    private $_defaultFormOptions = [
        'errorUrl' => '',
        'successUrl' => ''
    ];

    public function api_form($options = [])
    {
        $model = new ConsultationModel;
        $settings = Yii::$app->getModule('admin')->activeModules['consultation']->settings;
        $options = array_merge($this->_defaultFormOptions, $options);

        ob_start();
        $form = ActiveForm::begin([
            'enableClientValidation' => true,
            'action' => Url::to(['/admin/consultation/send'])
        ]);

        echo Html::hiddenInput('errorUrl', $options['errorUrl'] ? $options['errorUrl'] : Url::current([self::SENT_VAR => 0]));
        echo Html::hiddenInput('successUrl', $options['successUrl'] ? $options['successUrl'] : Url::current([self::SENT_VAR => 1]));

        echo $form->field($model, 'name');
        echo $form->field($model, 'email')->input('email');

        if($settings['enablePhone']) echo $form->field($model, 'phone');
        if($settings['enableTitle']) echo $form->field($model, 'title');

        echo $form->field($model, 'text')->textarea();

        if($settings['enableCaptcha']) echo $form->field($model, 'reCaptcha')->widget(ReCaptcha::className());

        echo Html::submitButton(Yii::t('easyii', 'Send'), ['class' => 'btn btn-primary']);
        ActiveForm::end();

        return ob_get_clean();
    }

    public function api_save($data)
    {
        $model = new ConsultationModel($data);
        if($model->save()){
            return ['result' => 'success'];
        } else {
            return ['result' => 'error', 'error' => $model->getErrors()];
        }
    }
}