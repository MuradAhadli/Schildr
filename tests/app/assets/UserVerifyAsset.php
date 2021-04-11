<?php
/**
 * Created by PhpStorm.
 * User: Cavid
 * Date: 5/15/2018
 * Time: 6:02 PM
 */

namespace app\assets;


use yii\web\AssetBundle;

class UserVerifyAsset extends AssetBundle
{
    public $sourcePath = '@app/media';

    public $js = [
        'js/user-verify.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}