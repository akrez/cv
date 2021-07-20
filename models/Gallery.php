<?php

namespace app\models;

use app\components\Image;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "gallery".
 *
 * @property string $name
 * @property int|null $updated_at
 * @property int $width
 * @property int $height
 * @property int|null $product_id
 * @property string $user_email
 *
 * @property User $userEmail
 * @property Item[] $items
 */
class Gallery extends ActiveRecord
{
    public $image;

    public static function tableName()
    {
        return 'gallery';
    }

    public function rules()
    {
        return [
            [['name', 'width', 'height'], 'required'],
            [['updated_at', 'width', 'height', 'product_id'], 'integer'],
            [['user_email'], 'email'],
            [['name'], 'string', 'max' => 16],
            [['name'], 'unique'],
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['email' => 'user_email']);
    }

    public static function getUrl($name, $schema = null)
    {
        return Url::to(Yii::getAlias('@web/image') . '/' . $name, $schema);
    }

    public static function getImageBasePath()
    {
        return Yii::getAlias('@webroot/image');
    }

    public static function getImagePath($name)
    {
        return Yii::getAlias('@webroot/image/') . $name;
    }

    public function delete()
    {
        self::deleteImage($this->name);
        return parent::delete();
    }

    public static function deleteImage($galleryName)
    {
        $path = self::getImagePath($galleryName);
        return @unlink($path);
    }

    public static function findByName($name)
    {
        return self::find()->where(['name' => $name])->one();
    }

    /*
    @return Gallery
    */
    public static function upload($src)
    {
        $gallery = new Gallery();

        $handler = new Image();
        $handler->save($src, self::getImageBasePath());
        if ($handler->getError()) {
            $gallery->addErrors(['name' => $handler->getError()]);
        } else {
            $info = $handler->getInfo();
            $gallery->width = $info['desWidth'];
            $gallery->height = $info['desHeight'];
            $gallery->name = $info['desName'];
            $gallery->user_email = \Yii::$app->user->getId();
            $gallery->save();
        }
        return $gallery;
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

    /**
     * Gets query for [[Items]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::class, ['gallery_name' => 'name']);
    }
}
