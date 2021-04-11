<?php
namespace yii\easyii\modules\consultation;

class ConsultationModule extends \yii\easyii\components\Module
{
    public $settings = [
        'mailAdminOnNewConsultation' => true,
        'subjectOnNewConsultation' => 'New consultation',
        'templateOnNewConsultation' => '@easyii/modules/consultation/mail/en/new_consultation',

        'answerTemplate' => '@easyii/modules/consultation/mail/en/answer',
        'answerSubject' => 'Answer on your consultation message',
        'answerHeader' => 'Hello,',
        'answerFooter' => 'Best regards.',

        'enableTitle' => false,
        'enablePhone' => true,
        'enableCaptcha' => false,
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'Consultation',
            'ru' => 'Обратная связь',
        ],
        'icon' => 'earphone',
        'order_num' => 60,
    ];

    public static $app_route = '/consultation/index';
}