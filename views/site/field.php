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
    foreach ($fields as $fieldTitle => $fieldsTitle) {
        echo '<div class="alert alert-info" role="alert"><h3 class="text-info m-0">' . ucfirst($fieldTitle) . '</h3></div>';
        foreach ($fieldsTitle as $fieldSubtitle => $field) {
            echo $this->render('_field_form', [
                'model' => ($model && $field->id == $model->id ? $model : $field),
            ]);
        }
    }
    ?>
</div>