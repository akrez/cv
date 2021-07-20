<?php

namespace app\models;

use Yii;

class Status extends Model
{
    const STATUS_UNVERIFIED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLE = 2;
    const STATUS_BLOCKED = 3;
    const STATUS_DELETED = 4;

    public static function getList()
    {
        return [
            self::STATUS_UNVERIFIED => 'Unverified',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_DISABLE => 'Disable',
            self::STATUS_BLOCKED => 'Blocked',
            self::STATUS_DELETED => 'Deleted',
        ];
    }

    public static function getLabel($item)
    {
        switch ($item) {
            case self::STATUS_UNVERIFIED:
                return 'Unverified';
            case self::STATUS_ACTIVE:
                return 'Active';
            case self::STATUS_DISABLE:
                return 'Disable';
            case self::STATUS_BLOCKED:
                return 'Blocked';
            case self::STATUS_DELETED:
                return 'Deleted';
        }
        return null;
    }

    public static function noYesList()
    {
        return [
            0 => Yii::t('yii', 'No'),
            1 => Yii::t('yii', 'Yes'),
        ];
    }
}
