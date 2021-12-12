<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Model;

use Imi\Bean\Annotation\Inherit;
use ImiApp\ApiServer\Backend\Model\Base\SoAuthRuleBase;

/**
 * 权限菜单.
 *
 * @Inherit
 */
class SoAuthRule extends SoAuthRuleBase
{
    public static function getSortBy(): string
    {
        return 'desc';
    }

    public static function getSortPk(): string
    {
        return 'sort';
    }
}
