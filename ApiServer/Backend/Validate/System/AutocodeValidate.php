<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Validate\System;

use Phpben\Imi\Validate\Validate;

class AutocodeValidate extends Validate
{
    protected $rule = [
        'path' => "require",
        'column' => 'require',
        'other' => 'require',
        'relation' => "",
        'model' => "require",
        'download' => "",
    ];

    protected $message = [
        'path.require' => '未传入路径',
        'column.require' => '未传入字段',
        'other.require' => '未传入其他配置',
        'model.require' => '未传入模型',
    ];

    protected $scene = [
        'create' => ['path', 'column', 'relation', 'other', 'model', 'download'],
    ];
}
