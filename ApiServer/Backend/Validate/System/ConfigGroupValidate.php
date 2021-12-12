<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Validate\System;

use Phpben\Imi\Validate\Validate;

class ConfigGroupValidate extends Validate
{
    protected $rule = [
    ];

    protected $message = [
        'password.require' => '请输入密码',
    ];

    protected $scene = [
    ];
}
