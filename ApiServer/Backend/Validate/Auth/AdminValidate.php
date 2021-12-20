<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Validate\Auth;

use Phpben\Imi\Validate\Validate;

class AdminValidate extends Validate
{
    protected $rule = [
        'email' => 'require|email',
        'mobile' => 'require|mobile',
        'username' => 'require|min:5|max:32',
        'password' => 'require|min:6|max:64',
        'status' => 'require|in:0,1',
        'groups' => 'require',
        'id' => 'require|integer',
        'avatar' => '',
    ];

    protected $message = [
        'email.require' => '请填写邮箱',
        'email.email' => '邮箱格式错误',
        'mobile.require' => '请填写手机号码',
        'mobile.mobile' => '手机号码格式错误',
        'username.require' => '请填写账号',
        'password.require' => '请填写密码',
        'username.min' => '账号不能小于五位数',
        'username.max' => '账号不能大于32位数',
        'password.min' => '密码不能小于六位数',
        'status.require' => '请选择状态',
        'status.in' => '状态格式错误',
        'groups.require' => '请选择用户组',
        'id.require' => '未传入ID',
        'id.integer' => 'ID格式错误',
    ];

    protected $scene = [
        'create' => ['email', 'mobile', 'username', 'password', 'status', 'groups', 'avatar'],
        'update' => ['id', 'email', 'mobile', 'username', 'status', 'groups', 'avatar'],
    ];
}
