<?php

use app\assets\cdn\SiteAsset;
use app\components\Alert;
use app\models\Site;
use yii\bootstrap\Html;
use yii\helpers\Url;

SiteAsset::register($this);
$this->title = ($this->title ? $this->title : Yii::$app->name);
$this->registerCss("
html, body {
    font-family: 'Sahel' !important;
    -moz-osx-font-smoothing: grayscale;
    -webkit-font-smoothing: antialiased;
    margin-top: 1em;
}
.mb-20 {
    margin-bottom: 20px;
}
.mt-15 {
    margin-top: 15px;
}
.mt-5 {
    margin-top: 5px;
}
.mt-0 {
    margin-top: 0;
} 
.m-0 {
    margin: 0;
}
");
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <?php if (!Yii::$app->user->getIsGuest()) { ?>
        <div class="container">
            <nav id="navbar" class="navbar navbar-default">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>"><?= Yii::$app->name ?></a>
                </div>
                <div id="navbar-collapse" class="collapse navbar-collapse">
                    <?php if (!Yii::$app->user->isGuest) : ?>
                        <ul class="nav navbar-nav">
                            <li><a href="<?= Url::toRoute(['/site/profile']) ?>">Profile</a></li>
                        </ul>
                    <?php endif; ?>
                    <?php if (Yii::$app->user->can('adminPermission')) : ?>
                        <ul class="nav navbar-nav">
                            <li><a href="<?= Url::toRoute(['/site/field']) ?>">Field</a></li>
                        </ul>
                        <ul class="nav navbar-nav">
                            <li><a href="<?= Url::toRoute(['/site/user']) ?>">User</a></li>
                        </ul>
                    <?php endif; ?>
                    <ul class="nav navbar-nav navbar-left">
                        <?php if (Yii::$app->user->isGuest) : ?>
                            <li><a href="<?= Url::toRoute(['/site/signin']) ?>" style="padding-left: 0;">Signin</a></li>
                        <?php else : ?>
                            <li><a href="<?= Url::toRoute(['/site/signout']) ?>">Signout</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
        </div>
    <?php } ?>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>
    </div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>