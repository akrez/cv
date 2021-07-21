<?php

use app\models\Gallery;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $field app\models\Field */

if (!function_exists('calcColsSize')) {

    function calcColsSize($field)
    {
        $capacity = ($field->show_gallery ? 7 : 9);

        $scales = [
            'tag' => $field->show_tag ? 2 : 0,
            'header' => !$field->hide_header ? 2 : 0,
            'body' => !$field->hide_body ? 3 : 0,
        ];
        $scales = array_filter($scales);

        $last = '_';
        $result = [$last => 0];
        foreach ($scales as $key => $scale) {
            $last = $key;
            $result[$key] = $scale;
            $capacity = $capacity - $scale;
        }
        $result[$last] = $result[$last] + $capacity;

        return $result;
    }
}

$colsSize = calcColsSize($field);
?>

<?php
$uniqueHash = hash('sha256', 'image-' . $field->title . '-' . $i  . '-' . $field->subtitle . '-' . $model->id);
$form = ActiveForm::begin([
    'action' => Url::to(['site/profile', 'action' => 'content', 'id' => $model->id, 'field_id' => $field->id,]),
    'options' => [
        'data-pjax' => true,
        'enctype' => 'multipart/form-data',
    ],
    'id' => 'id-' . $uniqueHash,
]);
$adminPermission = Yii::$app->user->can('adminPermission');
$btnLabel = "<label>&nbsp;</label>";
?>

<div class="row">
    <?php
    if (isset($colsSize['header'])) {
        echo '<div class="col-sm-' . $colsSize['header'] . '">';
        echo $adminPermission ? Html::tag('small', " ('" . $field->title . "', '" . $field->subtitle . "', 'header')", ['class' => 'text-muted']) : '';
        echo $form->field($model, 'header')->textInput()->label(ucfirst($field->header_label ? $field->header_label : $field->title));
        echo '</div>';
    }
    if (isset($colsSize['body'])) {
        echo '<div class="col-sm-' . $colsSize['body'] . '">';
        echo $adminPermission ? Html::tag('small', " ('" . $field->title . "', '" . $field->subtitle . "', 'body')", ['class' => 'text-muted']) : '';
        echo $form->field($model, 'body')->textInput()->label(ucfirst($field->body_label ? $field->body_label : $field->subtitle));
        echo '</div>';
    }
    if (isset($colsSize['tag'])) {
        echo '<div class="col-sm-' . $colsSize['tag'] . '">';
        echo $adminPermission ? Html::tag('small', " ('" . $field->title . "', '" . $field->subtitle . "', 'tag')", ['class' => 'text-muted']) : '';
        echo $form->field($model, 'tag')->textInput()->label($field->tag_label ? ucfirst($field->tag_label) : null);
        echo '</div>';
    }
    if ($colsSize['_']) {
        echo '<div class="col-sm-' . $colsSize['_'] . '"></div>';
    }
    if ($field->show_gallery) {
        $imageInputId = 'image-' . $uniqueHash;
        $imageUrl = Gallery::getUrl($model->gallery_name);
        echo '<div class="col-sm-2">';
        echo $adminPermission ? '<div>' . Html::tag('small', " ('" . $field->title . "', '" . $field->subtitle . "', 'gallery_name')", ['class' => 'text-muted']) . '</div>' : '';
        echo '<label class="control-label">' . ($field->gallery_label ? ucfirst($field->gallery_label) : '') . '&nbsp;</label>';
        echo '<div class="row">';
        if ($model->gallery_name) {
            echo '<div class="col-sm-12">' .
                '<div class="input-group">' .
                '<div class="form-control form-control-img">' . Html::img($imageUrl) . '</div>' .
                Html::a('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>', ['site/profile', 'action' => 'delete-gallery', 'id' => $model->id, 'field_id' => $field->id,], ['class' => 'btn btn-default text-danger input-group-addon']) .
                '</div>' .
                '</div>';
        } else {
            echo '<div class="col-sm-12">';
            echo Html::label('Upload', $imageInputId, ['class' => 'btn btn-default btn-block']);
            echo '</div>';
        }
        echo Html::activeFileInput($model, 'image', ['style' => 'display: none', 'id' => $imageInputId, 'class' => 'gallery-input']);
        echo '</div></div>';
    }
    ?>
    <div class="col-sm-<?= $model->isNewRecord ? 3 : 2 ?>">
        <?php
        echo $adminPermission ? '<div>&nbsp;</div>' : '';
        echo $btnLabel . Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-block ' . ($model->isNewRecord ? 'btn-success' : 'btn-primary')]);
        ?>
    </div>
    <?php
    if (!$model->isNewRecord) {
        echo '<div class="col-sm-1">' . $btnLabel;
        echo $adminPermission ? '<div>&nbsp;</div>' : '';
        echo Html::a('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>', ['site/profile', 'action' => 'delete', 'id' => $model->id, 'field_id' => $field->id,], ['class' => 'btn btn-danger btn-block']);
        echo '</div>';
    }
    ?>
</div>
<?php ActiveForm::end(); ?>