<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Controller;

use ImiApp\ImiServer\HttpController;
use Imi\Server\Http\Route\Annotation\Action;
use Imi\Server\Http\Route\Annotation\Controller;
use Imi\Server\Http\Route\Annotation\Route;
use Phpben\Imi\Auth\Annotation\Auth;
use Phpben\Imi\Auth\AuthManager;
use Phpben\Imi\Validate\Annotation\Validate;
use Psr\Http\Message\ResponseInterface;

/**
 * @Auth(name="backend",nocheck="*",nologin={"login"})
 * @Controller("/auth/")
 */
class AuthController extends HttpController
{
    /**
     * @Action
     * @Route(url="login",method="POST")
     * @Validate
     */
    public function login($data): ResponseInterface
    {
        $auth = new AuthManager('backend');
        if ($user = $auth->login($data->username, $data->password)) {
            return $this->response->success('登陆成功', [
                'token' => $user->token,
                'username' => $user->username,
                'avatar' => $user->avatar,
            ]);
        }
        return $this->response->error('账号或密码错误');
    }

    /**
     * @Action
     * @Route(url="auth",method="GET")
     */
    public function auth()
    {
        return 1;
    }
}
