<?php
use yii\captcha\Captcha;
use yii\bootstrap\ActiveForm;
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-sm-4 col-12">
        </div>
        <div class="col-sm-4 col-12">
            <h3 style="margin-bottom: 20px;"> Signin </h3>
            <?php
            $form = ActiveForm::begin();
            ?>
            <?= $form->field($model, 'email')->textInput() ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'captcha', ['template' => '{input}<small>{hint}</small>{error}'])->widget(Captcha::class) ?>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block" style="float: right;"> Signin </button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>