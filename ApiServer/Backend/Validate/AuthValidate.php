<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Validate;

use Phpben\Imi\Validate\Validate;

class AuthValidate extends Validate
{
    protected $rule = [
        'password' => 'require|min:6|max:64',
        'username' => 'require|min:5|max:32',
    ];

    protected $message = [
        'password.require' => '请输入密码',
        'username.require' => '请输入账号',
        'username.min' => '账号不能小于5位',
        'password.min' => '密码不能小于6位',
        'username.max' => '账号不难大于32位',
        'password.max' => '密码不能大于64位',
    ];

    protected $scene = [
        'login' => ['username', 'password']
    ];
}
