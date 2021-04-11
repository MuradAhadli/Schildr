<?php
namespace  app\models;

use yii;

class Partners extends \yii\easyii\modules\partners\models\Partners
{
    public static function tableName()
    {
        return 'easyii_partners';
    }

    public function rules()
    {
        return [];
    }

    public static function getPartners()
    {
        return parent::find()
            ->select([
                'easyii_partners.id',
                'easyii_partners.client_id',
                'easyii_partners.image',
                'easyii_partners.created_at',
                'easyii_partners.updated_at',
                'easyii_partners.rating',
                'easyii_partners.status',
                'easyii_partners_lang.full_name',
                'easyii_partners_lang.position',
                'easyii_partners_lang.review',
            ])
            ->where(['language' => yii::$app->language])
            ->leftJoin('easyii_partners_lang','easyii_partners.id = easyii_partners_lang.partner_id')
            ->asArray()
            ->all();
    }
}