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
        'views\Personal.php/vendor/jquery/jquery.min.js',
        'views\Personal.php/vendor/bootstrap/js/bootstrap.bundle.min.js',
        'views\Personal.php/vendor/jquery.easing/jquery.easing.min.js',
        'views\Personal.php/vendor/php-email-form/validate.js',
        'views\Personal.php/vendor/waypoints/jquery.waypoints.min.js',
        'views\Personal.php/vendor/counterup/counterup.min.js',
        'views\Personal.php/vendor/owl.carousel/owl.carousel.min.js',
        'views\Personal.php/vendor/isotope-layout/isotope.pkgd.min.js',
        'views\Personal.php/vendor/venobox/venobox.min.js',
        'views\Personal.php/js/main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'app\assets\cdn\OpenSansAsset',
    ];
}
