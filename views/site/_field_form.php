<?php

use app\models\Status;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Field */
/* @var $form yii\widgets\ActiveForm */
?>


<?php
$form = ActiveForm::begin([
    'action' => Url::current(['site/field', 'id' => $model->id, 'delete' => null,]),
    'fieldConfig' => [
        'template' => '<div class="input-group">{label}{input}</div>{hint}{error}',
        'labelOptions' => [
            'class' => 'input-group-addon',
        ],
    ]
]);
?>
<div class="row">
    <div class="col-sm-3">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-3">
        <?= $form->field($model, 'subtitle')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-3">
        <?= $form->field($model, 'is_multiple')->dropDownList(Status::noYesList()) ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <?= $form->field($model, 'header_label')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-3">
        <?= $form->field($model, 'body_label')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-3">
        <?= $form->field($model, 'tag_label')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-sm-3">
        <?= $form->field($model, 'gallery_label')->textInput(['maxlength' => true]) ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-2">
        <?= $form->field($model, 'hide_header')->dropDownList(Status::noYesList()) ?>
    </div>
    <div class="col-sm-2">
        <?= $form->field($model, 'hide_body')->dropDownList(Status::noYesList()) ?>
    </div>
    <div class="col-sm-2">
        <?= $form->field($model, 'show_tag')->dropDownList(Status::noYesList()) ?>
    </div>
    <div class="col-sm-2">
        <?= $form->field($model, 'show_gallery')->dropDownList(Status::noYesList()) ?>
    </div>
    <div class="col-sm-2">
        <?= Html::submitButton($model->isNewRecord ? ' <span class="glyphicon glyphicon-plus"></span> ' . Yii::t('app', 'Create') : ' <span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('app', 'Update'), ['class' => 'btn btn-block btn-social ' . ($model->isNewRecord ? 'btn-success' : 'btn-primary')]); ?>
    </div>
    <div class="col-sm-2">
        <?php
        if (!$model->isNewRecord) :
            echo Html::a(' <span class="glyphicon glyphicon-trash"></span> ' . Yii::t('yii', 'Delete'), Url::to(['site/field', 'id' => $model->id, 'delete' => true,]), [
                'class' => 'btn btn-danger btn-block btn-social',
                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            ]);
        endif;
        ?>
    </div>
</div>
<?php ActiveForm::end(); ?>