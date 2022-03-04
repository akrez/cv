<?php

namespace app\assets;

use yii\web\AssetBundle;

class MyResumeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'theme/MyResume/vendor/icofont/icofont.min.css',
        'theme/MyResume/vendor/boxicons/css/boxicons.min.css',
        'theme/MyResume/vendor/venobox/venobox.css',
        'theme/MyResume/vendor/owl.carousel/assets/owl.carousel.min.css',
        'theme/MyResume/vendor/aos/aos.css',
        'theme/MyResume/css/style.css',
    ];
    public $js = [
        'theme/MyResume/vendor/jquery.easing/jquery.easing.min.js',
        'theme/MyResume/vendor/php-email-form/validate.js',
        'theme/MyResume/vendor/waypoints/jquery.waypoints.min.js',
        'theme/MyResume/vendor/counterup/counterup.min.js',
        'theme/MyResume/vendor/isotope-layout/isotope.pkgd.min.js',
        'theme/MyResume/vendor/venobox/venobox.min.js',
        'theme/MyResume/vendor/owl.carousel/owl.carousel.min.js',
        'theme/MyResume/vendor/typed.js/typed.min.js',
        'theme/MyResume/vendor/aos/aos.js',
        'theme/MyResume/js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'app\assets\cdn\OpenSansAsset',
    ];
}
