<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Model;

use Imi\Bean\Annotation\Inherit;
use ImiApp\ApiServer\Backend\Model\Base\SoAdminOperateLogBase;

/**
 * 管理员操作日志.
 *
 * @Inherit
 */
class SoAdminOperateLog extends SoAdminOperateLogBase
{
    public static function write($data)
    {
        $model = self::newInstance();
        $data['admin_id'] = $data['user_id'];
        $data['username'] = SoAdmin::find($data['user_id'])->getUsername();
        $data['route_name'] = $data['controller'];
        unset($data['controller'], $data['user_id']);
        $model->insert($data);
    }

}
