<?php

namespace app\models;

use yii\base\Model as BaseModel;

class Model extends BaseModel
{
    public function attributeLabels()
    {
        return static::attributeLabelsList();
    }

    public static function attributeLabelsList()
    {
        return [
            'id' => 'ID',
            //
            'title' => 'Title',
            'subtitle' => 'Subtitle',
            'is_multiple' => 'Is Multiple',
            'hide_header' => 'Hide Header',
            'hide_body' => 'Hide Body',
            'show_tag' => 'Show Tag',
            'show_gallery' => 'Show Gallery',
            'header_label' => 'Header Label',
            'body_label' => 'Body Label',
            'tag_label' => 'Tag Label',
            'gallery_label' => 'Gallery Label',
            //
            'header' => 'Header',
            'body' => 'Body',
            'tag' => 'Tag',
            'created_at' => 'Created At',
            //
            'field_id' => 'Field',
            'gallery_name' => 'Gallery',
            'user_email' => 'User',
        ];
    }
}
