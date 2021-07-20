<?php

use app\models\Content;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Profile';
?>
<div class="field-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    foreach ($fields as $fieldTitle => $fieldsTitle) {
        echo '<hr /><div class="row"><div class="col-sm-12"><h2 class="text-info mt-0 mb-20">' . $fieldTitle . '</h2></div></div>';
        foreach ($fieldsTitle as $fieldSubtitle => $field) {
            if (!isset($contents[$field->id])) {
                $contents[$field->id] = [];
            }
            if ($field->is_multiple || !$contents[$field->id]) {
                $contents[$field->id][] = new Content();
            }
            foreach ($contents[$field->id] as $contentModel) {
                echo $this->render('_content_form', [
                    'model' => $contentModel,
                    'field' => $field,
                ]);
            }
        }
    }
    ?>
</div>