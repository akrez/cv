<?php

namespace app\models;

use app\models\Content;
use Yii;

/**
 * This is the model class for table "{{%field}}".
 *
 * @property int $id
 * @property string $title
 * @property string $subtitle
 * @property int $is_multiple
 * @property int|null $hide_header
 * @property int|null $hide_body
 * @property int|null $show_tag
 * @property int|null $show_gallery
 * @property string|null $header_label
 * @property string|null $body_label
 * @property string|null $tag_label
 * @property string|null $gallery_label
 *
 * @property Content[] $contents
 */
class Field extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%field}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'subtitle', 'is_multiple'], 'required'],
            [['is_multiple', 'hide_header', 'hide_body', 'show_tag', 'show_gallery'], 'in', 'range' => array_keys(Status::noYesList())],
            [['title', 'subtitle'], 'string', 'max' => 61],
            [['header_label', 'body_label', 'tag_label', 'gallery_label'], 'string', 'max' => 65],
        ];
    }

    /**
     * Gets query for [[Contents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContents()
    {
        return $this->hasMany(Content::class, ['field_id' => 'id']);
    }
}
