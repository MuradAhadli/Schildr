<?php

namespace yii\easyii\modules\project\models;

use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\Taggable;
use yii\easyii\models\Photo;
use yii\easyii\modules\project\models\EasyiiProject;
use yii\helpers\StringHelper;

class ProjectUploads extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const IMAGE_WIDTH = 890;
    const IMAGE_HEIGHT = 555;


    public static function tableName()
    {
        return 'easyii_project_uploads';
    }

    public function rules()
    {
        return [
            [['project_id'], 'required'],
            ['image', 'image', 'minWidth' => self::IMAGE_WIDTH, 'minHeight' => self::IMAGE_HEIGHT, 'maxSize' => 1024 * 1024 * 10, 'extensions' => 'png, PNG, jpg, JPG, jpeg, JPEG,'],
        ];
    }


    public static function getUploadsByParent($parent_id)
    {
        return self::find()
            ->where([
                'project_id' => $parent_id
            ])
            ->orderBy('is_base DESC')
            ->asArray()
            ->all();
    }

}