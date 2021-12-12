<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Validate\Auth;

use Phpben\Imi\Validate\Validate;

class RuleValidate extends Validate
{
    protected $rule = [
        'class' => 'require',
        'pid' => 'require|integer',
        'id' => 'require|integer',
        'status' => 'require|in:1,0',
        'name' => 'require',
        'type' => 'require|in:button,link,iframe,menu',
        'icon' => '',
        'alias' => '',
        'sort' => '',
        'rule' => '',
        'path' => '',
        'ids' => 'require',
        'changeid' => 'require',
        'changepid' => '',
    ];

    protected $message = [
        'ids.require' => '未传入IDS',
        'changeid.require' => '未传入ID',
        'class.require' => '请选择控制器',
        'pid.require' => '请选择父级',
        'pid.integer' => '父级格式错误',
        'name.require' => '请输入名称',
        'type.require' => '请选择类型',
        'type.in' => '类型格式错误',
        'id.integer' => 'ID格式错误',
        'id.require' => '未传入ID',
        'status.in' => '状态格式错误',
        'status.require' => '状态未传入',
    ];

    protected $scene = [
        'methods' => ['class'],
        'create' => ['pid', 'name', 'type'],
        'sort' => ['pid', 'changeid', 'changepid', 'ids'],
        'update' => ['id', 'status', 'name', 'type', 'pid', 'icon', 'alias', 'sort', 'rule', 'path'],
    ];
}
