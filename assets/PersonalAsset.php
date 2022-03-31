<?php

namespace app\assets;

use yii\web\AssetBundle;

class PersonalAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'theme/Personal/vendor/bootstrap/css/bootstrap.min.css',
        'theme/Personal/vendor/icofont/icofont.min.css',
        'theme/Personal/vendor/remixicon/remixicon.css',
        'theme/Personal/vendor/owl.carousel/assets/owl.carousel.min.css',
        'theme/Personal/vendor/boxicons/css/boxicons.min.css',
        'theme/Personal/vendor/venobox/venobox.css',
        'theme/Personal/css/style.css',
    ];
    public $js = [
        'theme/Personal/vendor/jquery/jquery.min.js',
        'theme/Personal/vendor/bootstrap/js/bootstrap.bundle.min.js',
        'theme/Personal/vendor/jquery.easing/jquery.easing.min.js',
        'theme/Personal/vendor/php-email-form/validate.js',
        'theme/Personal/vendor/waypoints/jquery.waypoints.min.js',
        'theme/Personal/vendor/counterup/counterup.min.js',
        'theme/Personal/vendor/owl.carousel/owl.carousel.min.js',
        'theme/Personal/vendor/isotope-layout/isotope.pkgd.min.js',
        'theme/Personal/vendor/venobox/venobox.min.js',
        'theme/Personal/js/main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'app\assets\cdn\OpenSansAsset',
    ];
}
