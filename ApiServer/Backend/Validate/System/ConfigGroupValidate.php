<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Validate\System;

use Phpben\Imi\Validate\Validate;

class ConfigGroupValidate extends Validate
{
    protected $rule = [
        'id' => "require|integer",
        'pid' => 'require|integer',
        'ids' => 'require',
        'changeid' => 'require',
        'changepid' => '',
        'name' => "require",
        'sort' => "",
    ];

    protected $message = [
        'id.require' => '未传入ID',
        'id.integer' => 'ID格式错误',
        'pid.require' => 'PID格式错误',
        'pid.integer' => 'PID格式错误',
        'ids.require' => '未传入ID',
        'changeid.require' => '未传入ID',
        'name.require' => '请填写名称',
    ];

    protected $scene = [
        'sort' => ['pid', 'changeid', 'changepid', 'ids'],
        'create' => ['pid', 'name','sort'],
        'update' => ['id', 'pid', 'name','sort'],
    ];
}
