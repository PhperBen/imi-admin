<?php
declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Validate;

use Phpben\Imi\Validate\Validate;

class UserValidate extends Validate
{
    protected $rule = [
		'id' => 'require|integer',
		'status' => 'require',
		'username' => 'require',
		'email' => 'require',
		'mobile' => 'require',
		'money' => 'require',
        'token' => 'require',
        'password' => '',
    ];

    protected $message = [
    ];

    protected $scene = [
        'create' => ['status', 'username', 'email', 'mobile', 'money',  'password'],
        'update' => ['id', 'status', 'username', 'email', 'mobile', 'money', 'password'],
    ];
}
