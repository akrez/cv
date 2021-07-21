<?php

use yii\widgets\Pjax;
use app\models\Content;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Profile';
$this->registerCss("
.m-0 {
    margin: 0;
}
.splash-style {
    background-image: url('" . Yii::getAlias('@web/loading.svg') . "');
    display: none;
    background-color: rgba(0, 0, 0, 0.67);
    inset: 0px;
    position: absolute;
    z-index: 9998;
    background-repeat: no-repeat;
    background-position: center;
}
.form-control-img {
    overflow: hidden;
    padding: 0;
    text-align: center;
    background-color: #eee;
}
.form-control-img img {
    max-width: 100%;
    max-height: 100%;
}
");
$this->registerJs("
$(document).on('pjax:beforeSend', function(xhr, options) {
    $('.ajax-splash-show').css('display', 'inline-block');
    $('.ajax-splash-hide').css('display', 'none');
});
$(document).on('pjax:complete', function(xhr, textStatus, options) {
    $('.ajax-splash-show').css('display', 'none');
    $('.ajax-splash-hide').css('display', 'inline-block');
});
$(document).on('change', '.gallery-input', function() {
    var input = $(this);
    var fileInput = $.trim(input.val());
    if (fileInput && fileInput !== '') {
        input.closest('form').submit();
    }
});
");
?>
<div class="field-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="ajax-splash-show splash-style"></div>
    <?php
    $i = 0;
    foreach ($fields as $fieldTitle => $fieldsTitle) {
        echo '<div class="alert alert-info" role="alert"><h3 class="text-info m-0">' . ucfirst($fieldTitle) . '</h3></div>';
        foreach ($fieldsTitle as $fieldSubtitle => $field) {
            if (!isset($contents[$field->id])) {
                $contents[$field->id] = [];
            }
            if ($field->is_multiple || !$contents[$field->id]) {
                $contents[$field->id][] = new Content();
            }
            Pjax::begin(['enablePushState' => false]);
            foreach ($contents[$field->id] as $contentModel) {
                echo $this->render('_content_form', [
                    'i' => $i,
                    'model' => $contentModel,
                    'field' => $field,
                ]);
                $i++;
            }
            Pjax::end();
        }
    }
    ?>
</div>