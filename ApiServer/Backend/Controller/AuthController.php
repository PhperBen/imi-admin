<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Controller;

use Imi\Server\Http\Controller\HttpController;
use Imi\Server\Http\Route\Annotation\Action;
use Imi\Server\Http\Route\Annotation\Controller;
use Imi\Server\Http\Route\Annotation\Route;
use Phpben\Imi\Auth\Annotation\Auth;
use Phpben\Imi\Validate\Annotation\Validate;

/**
 * @Auth(name="backend",nologin={"login"})
 * @Controller("/auth/")
 */
class AuthController extends HttpController
{
    /**
     * @Action
     * @Route(url="login",method="POST")
     * @Validate
     */
    public function login($data)
    {
        return $data;
    }

}
