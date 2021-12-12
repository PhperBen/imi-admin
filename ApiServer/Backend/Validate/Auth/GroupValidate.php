<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Validate\Auth;

use Phpben\Imi\Validate\Validate;

class GroupValidate extends Validate
{
    protected $rule = [
        'pid' => 'require|integer',
        'name' => 'require',
        'rules' => 'require',
        'id' => 'require|integer',
    ];

    protected $message = [
        'id.require' => '未传入ID',
        'id.integer' => 'ID格式错误',
        'pid.require' => '未传入PID',
        'pid.integer' => 'PID格式错误',
        'name.require' => '请填写名称',
        'rules.require' => '请选择规则',
    ];

    protected $scene = [
        'create' => ['pid', 'name', 'rules'],
        'update' => ['pid', 'name', 'rules', 'id'],
    ];
}
