<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    foreach ($models as $modelOfModels) {
        echo $this->render('_user_form', [
            'model' => ($model && $modelOfModels->id == $model->id ? $model : $modelOfModels),
        ]);
    }
    echo $this->render('_user_form', [
        'model' => $newModel,
    ]);
    ?>
</div>