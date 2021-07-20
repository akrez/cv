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
    'fieldConfig' => [
        'template' => '<div class="input-group">{label}{input}</div>{hint}{error}',
        'labelOptions' => [
            'class' => 'input-group-addon',
        ],
    ],
    'options' => [
        'data-pjax' => true,
        'enctype' => 'multipart/form-data',
    ],
]);
?>
<div class="panel panel-default <?= $field->is_multiple ? 'panel-info' : 'panel-primary' ?>">
    <div class="panel-heading clearfix">
        <span class="pull-left">
            <?= $field->subtitle ?>
        </span>
        <span class="pull-right">
            <?= $model->id ? ' ' . Html::a('✖', ['site/profile', 'action' => 'delete', 'id' => $model->id, 'field_id' => $field->id,], ['style' => 'color: red;']) : '' ?>
        </span>
    </div>
    <div class="panel-body">
        <div class="row">
            <?php
            if (!$field->hide_header) {
                echo '<div class="col-sm-12">';
                echo $form->field($model, 'header')->textInput()->label($field->header_label ? $field->header_label : null);
                echo '</div>';
            }
            if (!$field->hide_body) {
                echo '<div class="col-sm-12">';
                echo $form->field($model, 'body')->textarea()->label($field->body_label ? $field->body_label : $field->subtitle);
                echo '</div>';
            }
            if ($field->show_tag) {
                echo '<div class="col-sm-12">';
                echo $form->field($model, 'tag')->textInput()->label($field->tag_label ? $field->tag_label : null);
                echo '</div>';
            }
            if ($field->show_gallery) {
                echo '<div class="col-sm-12">';
                $imageInputId = hash('sha256', 'image-' . $field->title . '-' . $field->subtitle . '-' . $model->id);
                if ($model->gallery_name) {
                    echo Html::img(Gallery::getUrl($model->gallery_name), ["class" => "img img-responsive"]);
                    echo Html::a('<span class="glyphicon glyphicon-remove"></span>' . Yii::t('yii', 'Delete'), ['site/profile', 'action' => 'delete-gallery', 'id' => $model->id, 'field_id' => $field->id,], ['class' => 'btn btn-danger btn-block btn-social mt-15']);
                } else {
                    echo Html::label('<span class="glyphicon glyphicon-upload"></span>' . Yii::t('yii', 'Upload'), $imageInputId, ['class' => 'btn btn-info btn-block btn-social']);
                }
                echo Html::activeFileInput($model, 'image', ['style' => 'display: none', 'id' => $imageInputId]);
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <div class="panel-footer clearfix">
        <div class="row">
            <div class="col-sm-12">
                <?= Html::submitButton($model->isNewRecord ? ' <span class="glyphicon glyphicon-plus"></span> ' . Yii::t('app', 'Create') : ' <span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('app', 'Update'), ['class' => 'btn btn-block btn-social ' . ($model->isNewRecord ? 'btn-success' : 'btn-default')]); ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>