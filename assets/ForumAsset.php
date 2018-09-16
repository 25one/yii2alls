<?php

namespace app\assets;

use yii\web\AssetBundle;

class ForumAsset extends AssetBundle
{
    //public $basePath = '@webroot';
    //public $baseUrl = '@web';
    public $sourcePath = '@app/modules/forum';
    public $css = [
        'css/mymod.css',
    ];
    public $js = [
        //'forum/js/forum.js',  //...public $basePath = '@webroot'; public $baseUrl = '@web'; (...Â web/forum/js)
        'js/forum.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
