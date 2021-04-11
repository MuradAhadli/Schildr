<?php
namespace yii\easyii;

use Yii;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\View;
use yii\base\Application;
use yii\base\BootstrapInterface;

use yii\easyii\models\Module;
use yii\easyii\models\Setting;
use yii\easyii\assets\LiveAsset;

class AdminModule extends \yii\base\Module implements BootstrapInterface
{
    const VERSION = 0.9;

    public $settings;
    public $activeModules;
    public $allModules;
    public $controllerLayout = '@easyii/views/layouts/main';

    private $_installed;

    public function init()
    {
        parent::init();

        if (Yii::$app->cache === null) {
            throw new \yii\web\ServerErrorHttpException('Please configure Cache component.');
        }

        $this->activeModules = Module::findAllActive();

        $modules = [];
        foreach ($this->activeModules as $name => $module) {
            $modules[$name]['class'] = $module->class;
            if (is_array($module->settings)) {
                $modules[$name]['settings'] = $module->settings;
            }
        }

        $this->setModules($modules);

        if (Yii::$app instanceof yii\web\Application) {
            define('IS_ROOT', !Yii::$app->user->isGuest && Yii::$app->user->identity->isRoot());
            define('LIVE_EDIT', !Yii::$app->user->isGuest && Yii::$app->session->get('easyii_live_edit'));
        }
    }


    public function bootstrap($app)
    {
        Yii::setAlias('easyii', '@vendor/noumo/easyii');

        \Yii::$container->set(\dosamigos\tinymce\TinyMce::className(), [
            'options' => ['rows' => 10],
            'clientOptions' => [
                'plugins' => [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality",
                    "emoticons template paste textcolor colorpicker textpattern imagetools codesample toc noneditable",
                ],
                'toolbar1' => 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | responsivefilemanager link image media',
                'toolbar2' => "print preview media | forecolor backcolor | fontsizeselect | emoticons fontawesome | codesample",
                'external_filemanager_path' => yii::getAlias('@web').'/app/media/plugins/responsivefilemanager/filemanager/',
                'filemanager_title' => 'Responsive Filemanager',
                'external_plugins' => [
                    'filemanager' => yii::getAlias('@web').'/app/media/plugins/responsivefilemanager/filemanager/plugin.min.js',
                    //Иконка/кнопка загрузки файла в панеле иснструментов.
                    'responsivefilemanager' => yii::getAlias('@web').'/app/media/plugins/responsivefilemanager/tinymce/plugins/responsivefilemanager/plugin.min.js',
                ],
                'relative_urls' => false,

                'templates' => [
                    [
                        'title' => 'Department',
                        'content' => 'Test 2',
                        'url' => Url::to(['/admin/template/department'])
                    ]
                ],
            ]
        ]);

        if (!$app->user->isGuest && strpos($app->request->pathInfo, 'admin') === false) {
            $app->on(Application::EVENT_BEFORE_REQUEST, function () use ($app) {
                $app->getView()->on(View::EVENT_BEGIN_BODY, [$this, 'renderToolbar']);
            });
        }
    }

    public function renderToolbar()
    {
        $view = Yii::$app->getView();
        echo $view->render('@easyii/views/layouts/frontend-toolbar.php');
    }

    public function getInstalled()
    {
        if ($this->_installed === null) {
            try {
                $this->_installed = Yii::$app->db->createCommand("SHOW TABLES LIKE 'easyii_%'")->query()->count() > 0 ? true : false;
            } catch (\Exception $e) {
                $this->_installed = false;
            }
        }
        return $this->_installed;
    }
}
