<?php
namespace app\assets\cdn;

use yii\web\AssetBundle;

class SiteAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'cdn/css/bootstrap-social.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapThemeAsset',
        'app\assets\cdn\FontSahelAsset',
    ];
}
