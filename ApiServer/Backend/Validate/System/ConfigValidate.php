<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Validate\System;

use Phpben\Imi\Validate\Validate;

class ConfigValidate extends Validate
{
    protected $rule = [
        'pid' => "require|integer",
        'name' => "require",
        'type' => "require|alpha",
        'key' => "require|alphaDash",
        'value' => "",
        'tip' => "",
        'variable' => "",
    ];

    protected $message = [
    ];

    protected $scene = [
        'create' => ['pid', 'name', 'type', 'key', 'value', 'tip', 'variable'],
    ];
}
