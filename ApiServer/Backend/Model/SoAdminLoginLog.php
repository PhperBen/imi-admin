<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Model;

use Imi\Bean\Annotation\Inherit;
use ImiApp\ApiServer\Backend\Model\Base\SoAdminLoginLogBase;

/**
 * 管理员登陆日志.
 *
 * @Inherit
 */
class SoAdminLoginLog extends SoAdminLoginLogBase
{

    public static function write($data)
    {
        $model = self::newInstance();
        unset($data['user_id']);
        $data['content'] = '';
        $data['status'] = 1;
        $model->insert($data);
    }

}
