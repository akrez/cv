<?php

use app\models\Status;
use app\models\User;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$form = ActiveForm::begin([
    'action' => Url::current(['site/user', 'email' => $model->email]),
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
        <?= $form->field($model, 'email')->textInput(['disabled' => !$model->isNewRecord]) ?>
    </div>
    <div class="col-sm-3">
        <?= $form->field($model, 'status')->dropDownList(User::statusList()) ?>
    </div>
    <div class="col-sm-3">
        <?= $form->field($model, 'is_admin')->dropDownList(Status::noYesList()) ?>
    </div>
    <div class="col-sm-3">
        <?= $form->field($model, 'password')->textInput() ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <?= $form->field($model, 'theme')->dropDownList(User::themeList()) ?>
    </div>
    <div class="col-sm-3">
        <?= $form->field($model, 'subdomain')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-3">
        <?= $form->field($model, 'domain')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-3">
        <?= Html::submitButton($model->isNewRecord ? ' <span class="glyphicon glyphicon-plus"></span> ' . Yii::t('app', 'Create') : ' <span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('app', 'Update'), ['class' => 'btn btn-block btn-social ' . ($model->isNewRecord ? 'btn-success' : 'btn-primary')]); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>