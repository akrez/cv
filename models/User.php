<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int|null $updated_at
 * @property int|null $created_at
 * @property int $status
 * @property string|null $token
 * @property string|null $password_hash
 * @property string|null $verify_token
 * @property int|null $verify_at
 * @property string|null $reset_token
 * @property int|null $reset_at
 * @property string $email
 * @property string $theme
 * @property string|null $subdomain
 * @property string|null $domain
 * @property int|null $is_admin
 *
 * @property Gallery[] $galleries
 * @property Item[] $items
 */
class User extends ActiveRecord implements IdentityInterface
{

    const TIMEOUT_RESET = 120;

    public $image;
    public $password;
    public $_user;
    //
    public $des;
    //
    public $captcha;

    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status',], 'in', 'range' => array_keys(self::statusList()), 'on' => self::SCENARIO_DEFAULT,],
            [['status', 'email', 'theme'], 'required', 'on' => self::SCENARIO_DEFAULT,],
            [['email'], 'email', 'on' => self::SCENARIO_DEFAULT,],
            [['subdomain', 'domain', 'theme'], 'string', 'max' => 61, 'on' => self::SCENARIO_DEFAULT,],
            [['is_admin'], 'boolean', 'on' => self::SCENARIO_DEFAULT,],
            [['password',], 'string', 'strict' => false, 'min' => 6, 'on' => self::SCENARIO_DEFAULT,],
            [['email'], 'unique', 'on' => self::SCENARIO_DEFAULT,],
            //
            [['email',], 'required', 'on' => 'signin',],
            [['email',], 'email', 'on' => 'signin',],
            [['password',], 'required', 'on' => 'signin',],
            [['password',], 'signinValidation', 'on' => 'signin',],
            [['password',], 'string', 'strict' => false, 'min' => 6, 'on' => 'signin',],
            [['captcha',], 'required', 'on' => 'signin',],
            [['captcha',], 'captcha', 'on' => 'signin',],
        ];
    }

    public function signinValidation($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = self::find()->where(['status' => [Status::STATUS_ACTIVE, Status::STATUS_DISABLE]])->andWhere(['email' => $this->email])->one();
            if ($user && $user->validatePassword($this->password)) {
                return $this->_user = $user;
            }
            $this->addError($attribute, Yii::t('yii', '{attribute} is invalid.', ['attribute' => $this->getAttributeLabel($attribute)]));
        }
        return $this->_user = null;
    }

    ////

    public static function findIdentity($email)
    {
        return static::find()->where(['email' => $email])->andWhere(['status' => [Status::STATUS_ACTIVE, Status::STATUS_DISABLE]])->one();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()->where(['token' => $token])->andWhere(['status' => [Status::STATUS_ACTIVE, Status::STATUS_DISABLE]])->one();
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->token;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /////

    public function setPasswordHash($password)
    {
        return $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function setAuthKey()
    {
        return $this->token = Yii::$app->security->generateRandomString();
    }

    public static function generateToken($attribute)
    {
        do {
            $rand = mt_rand(10000, 99999);
            $model = self::find()->where([$attribute => $rand])->one();
        } while ($model != null);
        return $rand;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function getUser()
    {
        return $this->_user;
    }

    public static function statusList()
    {
        return [
            Status::STATUS_UNVERIFIED => 'Unverified',
            Status::STATUS_ACTIVE => 'Active',
            Status::STATUS_DISABLE => 'Disable',
            Status::STATUS_BLOCKED => 'Blocked',
            Status::STATUS_DELETED => 'Deleted',
        ];
    }

    public static function themeList()
    {
        return [
            'MyResume' => 'MyResume',
        ];
    }

    public static function getUserOfHost($url, $mainHost)
    {
        $url = str_replace(' ', '', $url);
        $url = strtolower($url);
        foreach (['https://', 'http://', 'www'] as $prefix) {
            if (substr($url, 0, strlen($prefix)) == $prefix) {
                $url = substr($url, strlen($prefix));
            }
        }
        $url = explode('/', $url);
        $url = $url[0];
        //
        $urlArray = explode('.', $url);
        //
        $domain = array_slice($urlArray, count($urlArray) - 2, count($urlArray));
        $domain = implode('.', $domain);
        //
        $subdomain = null;
        if (count($urlArray) > 2 && $domain == $mainHost) {
            $subdomain = array_slice($urlArray, 0, count($urlArray) - 2);
            $subdomain = implode('.', $subdomain);
        }

        return static::getUserByHost($domain, $subdomain);
    }

    public static function getUserByHost($domain, $subdomain = null)
    {
        $conditions = ['OR',];
        $conditions[] = [
            'AND',
            ['not', ['domain' => null]],
            ['not', ['domain' => '']],
            ['domain' => $domain],
        ];
        if ($subdomain) {
            $conditions[] = [
                'AND',
                ['not', ['subdomain' => null]],
                ['not', ['subdomain' => '']],
                ['subdomain' => $subdomain],
            ];
        }

        return User::find()->where($conditions)->one();
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        return [
            'email' => $this->email,
            'theme' => $this->theme,
            'subdomain' => $this->subdomain,
            'domain' => $this->domain,
        ];
    }
}
