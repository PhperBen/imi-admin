<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Controller;

use Imi\Server\Http\Route\Annotation\Action;
use Imi\Server\Http\Route\Annotation\Controller;
use Imi\Server\Http\Route\Annotation\Route;
use Imi\Util\ArrayUtil;
use ImiApp\ApiServer\Backend\Model\SoAuthRule;
use Phpben\Imi\Auth\Annotation\Auth;
use Phpben\Imi\Validate\Annotation\Validate;
use Psr\Http\Message\ResponseInterface;
use Imi\Aop\Annotation\Inject;

/**
 * @Auth(name="backend",nocheck="*",nologin={"login"})
 * @Controller("/auth/")
 */
class AuthController extends CommonController
{
    /**
     * @Inject("AuthService")
     */
    protected $service;

    /**
     * 登陆
     * @Action
     * @Route(url="login",method="POST")
     * @Validate
     * @param $data
     * @return ResponseInterface
     */
    public function login($data): ResponseInterface
    {
        if ($user = $this->auth->login($data->username, $data->password)) {
            return $this->response->success('登陆成功', [
                'token' => $user->token,
                'username' => $user->username,
                'email' => $user->email,
                'avatar' => $user->avatar,
            ]);
        }
        return $this->response->error('账号或密码错误');
    }

    /**
     * @Action
     * @Route(url="auth",method="GET")
     * @return ResponseInterface
     */
    public function auth(): ResponseInterface
    {
        $ruleIds = $this->auth->auth()->getRuleIds();
        $menu = $this->service->getMenu($ruleIds);
        $permissions = $this->service->getPermissions($ruleIds);
        return $this->response->success('操作成功', [
            'menu' => $menu,
            'permissions' => $permissions,
        ]);
    }

    /**
     * @Action
     * @Route(url="logout",method="GET")
     * @return ResponseInterface
     */
    public function logout(): ResponseInterface
    {
        $this->auth->logout();
        return $this->response->success('退出登陆成功');
    }

}
