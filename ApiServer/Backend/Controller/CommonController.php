<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Controller;

use Phpben\Imi\Auth\AuthManager;
use ImiApp\ImiServer\HttpController;
use Imi\Aop\Annotation\Inject;

class CommonController extends HttpController
{
    /**
     * Auth
     * @Inject(name=AuthManager::class,args={"backend"})
     * 
     * @var \Phpben\Imi\Auth\AuthManager
     */
    protected $auth;
}
