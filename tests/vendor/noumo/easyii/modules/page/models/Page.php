<?php

namespace yii\easyii\modules\page\models;

use Yii;
use yii\easyii\behaviors\SeoBehavior;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use yii\easyii\behaviors\SortableController;
use yii\easyii\behaviors\SortableModel;
use yii\easyii\models\Cover;
use yii\easyii\models\Module;
use yii\easyii\models\Photo;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\VarDumper;
use yii\easyii\behaviors\Taggable;

class Page extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;
    const IMAGE_WIDTH = 1250;
    const IMAGE_HEIGHT = 720;

    public static function tableName()
    {
        return 'easyii_pages';
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'text', 'short'], 'trim'],
            ['image', 'image', 'maxSize' => 1024 * 1024 * 10, 'extensions' => 'png'],
            [['title', 'module_class'], 'string', 'max' => 128],
            [['external_link'], 'string', 'max' => 255],
            ['slug', 'match', 'pattern' => self::$SLUG_PATTERN, 'message' => Yii::t('easyii', 'Slug can contain only 0-9, a-z and "-" characters (max: 128).')],
            ['status', 'default', 'value' => self::STATUS_ON],
            [['section', 'parent_id'], 'integer'],
            ['parent_id', 'default', 'value' => 0]
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('easyii', 'Title'),
            'text' => Yii::t('easyii', 'Text'),
            'short' => Yii::t('easyii', 'Short'),
            'slug' => Yii::t('easyii', 'Slug'),
            'image' => Yii::t('easyii', 'Image'),
            'module_class' => Yii::t('easyii', 'Module'),
            'status' => Yii::t('easyii', 'Status'),
        ];
    }

    public function behaviors()
    {
        return [
            SortableModel::className(),
            'seoBehavior' => SeoBehavior::className(),
//            'taggabble' => Taggable::className(),
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => yii::$app->params['languages'],
                //'languageField' => 'language',
                //'localizedPrefix' => '',
                'requireTranslations' => true,
                'dynamicLangClass' => true,
//                'langClassName' => NewsLang::className(), // or namespace/for/a/class/PostLang
                'defaultLanguage' => yii::$app->language,
                'langForeignKey' => 'page_id',
                'tableName' => "easyii_pages_lang",
                'attributes' => [
                    'title', 'text', 'short', 'slug'
                ]
            ],
        ];
    }

    public function getModules()
    {
        return ArrayHelper::toArray(yii::$app->getModule('admin')->activeModules);

    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $settings = Yii::$app->getModule('admin')->activeModules['page']->settings;

            if (!$insert && $this->image != $this->oldAttributes['image'] && $this->oldAttributes['image']) {
                @unlink(Yii::getAlias('@webroot') . $this->oldAttributes['image']);
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            yii::$app->db->createCommand()
                ->update(
                    Module::tableName(),
                    ['page_id' => $this->id],
                    ['class' => $this->module_class]
                )
                ->execute();

            return parent::afterSave($insert, $changedAttributes);
        }

        if (isset($changedAttributes['module_class'])) {
            $db = yii::$app->db;

            $transaction = $db->beginTransaction();

            try {
                $db->createCommand()
                    ->update(
                        Module::tableName(),
                        ['page_id' => $this->id],
                        ['class' => $this->module_class]
                    )
                    ->execute();

                $db->createCommand()
                    ->update(
                        Module::tableName(),
                        ['page_id' => 0],
                        ['class' => $changedAttributes['module_class']]
                    )
                    ->execute();

                $transaction->commit();
            } catch (\Exception $e) {

                $transaction->rollBack();
                throw $e;
            }
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete()
    {
        parent::afterDelete();

        yii::$app->db->createCommand()
            ->update(
                Module::tableName(),
                ['page_id' => 0],
                ['class' => $this->module_class]
            )
            ->execute();

        Cover::deleteAll(['item_id' => $this->id, 'class' => self::className()]);

        Photo::deleteAll(['item_id' => $this->id, 'class' => self::className()]);

        if ($this->image) {
            @unlink(Yii::getAlias('@webroot') . $this->image);
        }
    }

    public function getParentPages()
    {
        $pages = self::find()
            ->localized(yii::$app->language);

        if (isset($_GET['id'])) {
            $pages = $pages->where(['<>', 'id', yii::$app->request->get('id')]);
        }
        $pages = $pages->asArray()
            ->all();

        return ArrayHelper::map($pages, 'id', 'translation.title');
    }


    public static function getAllPages()
    {
        return Page::find()
            ->select([
                'easyii_pages.id',
                'easyii_pages_lang.title',
            ])
            ->where([
                'status' => 1,
                'language' => yii::$app->language
            ])
            ->leftJoin('easyii_pages_lang', 'easyii_pages.id = easyii_pages_lang.page_id')
            ->asArray()
            ->all();
    }


    public static function getPageById($page_id)
    {
       return self::find()
            ->select([
                'easyii_pages_lang.title'
            ])
            ->leftJoin('easyii_pages_lang', 'easyii_pages.id = easyii_pages_lang.page_id')
            ->where([
                'easyii_pages.id' => $page_id,
                'language' => yii::$app->language
            ])
            ->asArray()
            ->one();
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

}