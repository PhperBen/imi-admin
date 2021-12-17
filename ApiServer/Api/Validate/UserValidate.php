<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Api\Validate;

use Phpben\Imi\Validate\Validate;

class UserValidate extends Validate
{
    protected $rule = [
        'newpassword' => 'require|min:6|max:64',
        'password' => 'require|min:6|max:64',
        'username' => 'require|min:5|max:32',
        'email' => 'require|email',
        'mobile' => 'require|mobile',
        'code' => 'require',
    ];

    protected $message = [
        'password.require' => '请输入密码',
        'username.require' => '请输入账号',
        'username.min' => '账号不能小于5位',
        'password.min' => '密码不能小于6位',
        'username.max' => '账号不难大于32位',
        'password.max' => '密码不能大于64位',
        'email.require' => '邮箱格式错误',
        'email.email' => '邮箱格式错误',
        'mobile.require' => '手机格式错误',
        'code.require' => '请输入验证码',
        'mobile.mobile' => '手机格式错误',
        'newpassword.require' => '请输入新密码',
        'newpassword.min' => '新密码不能小于6位',
        'newpassword.max' => '新密码不能大于64位',
    ];

    protected $scene = [
        'login' => ['username', 'password'],
        'register' => ['username', 'password', 'mobile', 'email', 'code'],
        'resetpwd' => ['username', 'password', 'code'],
        'changeemail' => ['code', 'email'],
        'changemobile' => ['code', 'mobile'],
        'changepwd' => ['password', 'newpassword'],
    ];

    public function __construct()
    {
        $this->scene['resetpwd'][] = config('user_verify');
        parent::__construct();
    }
}
