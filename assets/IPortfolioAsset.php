<?php

namespace app\assets;

use yii\web\AssetBundle;

class IPortfolioAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "theme/IPortfolio/vendor/icofont/icofont.min.css",
        "theme/IPortfolio/vendor/boxicons/css/boxicons.min.css",
        "theme/IPortfolio/vendor/venobox/venobox.css",
        "theme/IPortfolio/vendor/owl.carousel/assets/owl.carousel.min.css",
        "theme/IPortfolio/vendor/aos/aos.css",
        "theme/IPortfolio/css/style.css",
    ];
    public $js = [
        "theme/IPortfolio/vendor/jquery/jquery.min.js",
        "theme/IPortfolio/vendor/bootstrap/js/bootstrap.bundle.min.js",
        "theme/IPortfolio/vendor/jquery.easing/jquery.easing.min.js",
        "theme/IPortfolio/vendor/php-email-form/validate.js",
        "theme/IPortfolio/vendor/waypoints/jquery.waypoints.min.js",
        "theme/IPortfolio/vendor/counterup/counterup.min.js",
        "theme/IPortfolio/vendor/isotope-layout/isotope.pkgd.min.js",
        "theme/IPortfolio/vendor/venobox/venobox.min.js",
        "theme/IPortfolio/vendor/owl.carousel/owl.carousel.min.js",
        "theme/IPortfolio/vendor/typed.js/typed.min.js",
        "theme/IPortfolio/vendor/aos/aos.js",
        "theme/IPortfolio/js/main.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'app\assets\cdn\OpenSansAsset',
    ];
}
