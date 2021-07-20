<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fields';
?>
<div class="field-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    echo $this->render('_field_form', [
        'model' => $newModel,
    ]);
    foreach ($models as $modelOfModels) {
        echo $this->render('_field_form', [
            'model' => ($model && $modelOfModels->id == $model->id ? $model : $modelOfModels),
        ]);
    }
    ?>
</div>