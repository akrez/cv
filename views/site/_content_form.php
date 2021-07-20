<?php

use app\models\Gallery;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $field app\models\Field */

?>

<?php
$form = ActiveForm::begin([
    'action' => Url::to(['site/profile', 'action' => 'content', 'id' => $model->id, 'field_id' => $field->id,]),
    'options' => [
        'data-pjax' => true,
        'enctype' => 'multipart/form-data',
    ],
]);
$btnLabel = "<label>&nbsp;</label>";

?>

<div class="row">
    <?php
    if (!$field->hide_header) {
        echo '<div class="col-sm-2">';
        echo $form->field($model, 'header')->textInput()->label($field->header_label ? $field->header_label : $field->title);
        echo '</div>';
    }
    if (!$field->hide_body) {
        echo '<div class="col-sm-3">';
        echo $form->field($model, 'body')->textInput()->label($field->body_label ? $field->body_label : $field->subtitle);
        echo '</div>';
    }
    if ($field->show_tag) {
        echo '<div class="col-sm-2">';
        echo $form->field($model, 'tag')->textInput()->label($field->tag_label ? $field->tag_label : null);
        echo '</div>';
    }
    if ($field->show_gallery) {
        $imageInputId = hash('sha256', 'image-' . $field->title . '-' . $field->subtitle . '-' . $model->id);
        echo '<div class="col-sm-3"><div class="row">';
        if ($model->gallery_name) {
            echo '<div class="col-sm-4">' . $btnLabel;
            echo Html::img(Gallery::getUrl($model->gallery_name), ["class" => "img img-responsive"]);
            echo '</div>';
            echo '<div class="col-sm-8">' . $btnLabel;
            echo Html::a('Delete' . ($field->gallery_label ? ' ' . $field->gallery_label : ''), ['site/profile', 'action' => 'delete-gallery', 'id' => $model->id, 'field_id' => $field->id,], ['class' => 'btn btn-warning btn-block']);
            echo '</div>';
        } else {
            echo '<div class="col-sm-12">' . $btnLabel;
            echo Html::label('Upload' . ($field->gallery_label ? ' ' . $field->gallery_label : ''), $imageInputId, ['class' => 'btn btn-info btn-block']);
            echo '</div>';
        }
        echo Html::activeFileInput($model, 'image', ['style' => 'display: none', 'id' => $imageInputId]);
        echo '</div></div>';
    }
    ?>
    <div class="col-sm-<?= $model->isNewRecord ? 2 : 1 ?>">
        <?= $btnLabel . Html::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class' => 'btn btn-block ' . ($model->isNewRecord ? 'btn-success' : 'btn-primary')]); ?>
    </div>
    <?php
    if (!$model->isNewRecord) {
        echo '<div class="col-sm-1">' . $btnLabel;
        echo Html::a('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>', ['site/profile', 'action' => 'delete', 'id' => $model->id, 'field_id' => $field->id,], ['class' => 'btn btn-danger btn-block']);
        echo '</div>';
    }
    ?>
</div>
<?php ActiveForm::end(); ?>