<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;

class Helper extends Component
{
    public static function store(&$newModel, $post, $staticAttributes = [], $setFlash = true)
    {
        if (!$newModel->load($post)) {
            return null;
        }
        //
        $isNewRecord = $newModel->isNewRecord;
        $newModel->setAttributes($staticAttributes, false);
        $isSuccessful = $newModel->save();
        //
        if (!$setFlash) {
            return $isSuccessful;
        }
        //
        if ($isSuccessful) {
            if ($isNewRecord) {
                Yii::$app->session->setFlash('success', 'Created successfully');
            } else {
                Yii::$app->session->setFlash('success', 'Edited successfully');
            }
        } else {
            $errors = $newModel->getErrorSummary(true);
            Yii::$app->session->setFlash('danger', reset($errors));
        }
        //
        return $isSuccessful;
    }

    public static function delete(&$model, $setFlash = true)
    {
        $isSuccessful = $model->delete();
        if ($setFlash) {
            if ($isSuccessful) {
                Yii::$app->session->setFlash('success', 'Successfully removed');
            } else {
                Yii::$app->session->setFlash('danger', 'Could not be deleted');
            }
        }
        return $isSuccessful;
    }

    public static function deleteAttribute(&$model, $attribute, $value = null, $setFlash = true)
    {
        $model->$attribute = $value;
        $isSuccessful = $model->save();
        if ($setFlash) {
            if ($isSuccessful) {
                Yii::$app->session->setFlash('success', 'Successfully removed');
            } else {
                Yii::$app->session->setFlash('danger', 'Could not be deleted');
            }
        }
        return $isSuccessful;
    }

    public static function findOrFail(ActiveQuery $query)
    {
        $model = $query->one();
        if ($model) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
    }
}
