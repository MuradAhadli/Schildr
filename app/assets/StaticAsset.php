<?php
namespace app\assets;

use yii\helpers\FileHelper;
use yii;

class StaticAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/media';

    public $js = [
        'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js',
        'js/bootstrap.min.js',
    ];


    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init(){
        parent::init();

        $this->css = [
            'css/bootstrap.min.css',
        ];

    }
}
