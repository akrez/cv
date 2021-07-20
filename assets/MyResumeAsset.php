<?php

namespace app\assets;

use yii\web\AssetBundle;

class MyResumeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendor/icofont/icofont.min.css',
        'vendor/boxicons/css/boxicons.min.css',
        'vendor/venobox/venobox.css',
        'vendor/owl.carousel/assets/owl.carousel.min.css',
        'vendor/aos/aos.css',
        'theme/MyResume/css/style.css',
    ];
    public $js = [
        'vendor/jquery.easing/jquery.easing.min.js',
        'vendor/php-email-form/validate.js',
        'vendor/waypoints/jquery.waypoints.min.js',
        'vendor/counterup/counterup.min.js',
        'vendor/isotope-layout/isotope.pkgd.min.js',
        'vendor/venobox/venobox.min.js',
        'vendor/owl.carousel/owl.carousel.min.js',
        'vendor/typed.js/typed.min.js',
        'vendor/aos/aos.js',
        'theme/MyResume/js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'app\assets\cdn\OpenSansAsset',
    ];
}
