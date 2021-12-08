<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Validate;

use Phpben\Imi\Validate\Validate;

class AuthValidate extends Validate
{
    protected $rule =   [
        'password'  => 'require',
        'as'  => 'require',
    ];

    protected $message  =   [
        'password.require' => '名称必须',
    ];

    protected $scene = [
        'login'=>['password']
    ];
}
