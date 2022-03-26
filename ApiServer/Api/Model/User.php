<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Api\Model;

use Imi\Bean\Annotation\Inherit;
use ImiApp\ApiServer\Api\Model\Base\UserBase;

/**
 * 用户表.
 *
 * @Inherit
 */
class User extends UserBase
{
    public static function getOperates(): array
    {
        return ["status"];
    }

    public static function getSearchColumns(): array
    {
        return ["id"];
    }
}
