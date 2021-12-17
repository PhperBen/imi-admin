<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Api\Controller;

use Phpben\Imi\Auth\AuthManager;
use ImiApp\ImiServer\HttpController;
use Imi\Aop\Annotation\Inject;

class CommonController extends HttpController
{
    /**
     * Auth
     * @Inject(AuthManager::class)
     */
    protected $auth;
}
