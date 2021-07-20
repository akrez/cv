<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%content}}".
 *
 * @property int $id
 * @property string|null $header
 * @property string|null $body
 * @property string|null $tag
 * @property int $field_id
 * @property string|null $gallery_name
 * @property string $user_email
 * @property int|null $created_at
 *
 * @property Field $field
 * @property Gallery $galleryName
 * @property User $userEmail
 */
class Content extends ActiveRecord
{
    public $image;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%content}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['body'], 'string'],
            [['!field_id', '!user_email'], 'required'],
            [['header'], 'string', 'max' => 260],
            [['tag'], 'string', 'max' => 65],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * Gets query for [[Field]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(Field::class, ['id' => 'field_id']);
    }

    /**
     * Gets query for [[GalleryName]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGalleryName()
    {
        return $this->hasOne(Gallery::class, ['name' => 'gallery_name']);
    }

    /**
     * Gets query for [[UserEmail]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserEmail()
    {
        return $this->hasOne(User::class, ['email' => 'user_email']);
    }
}
