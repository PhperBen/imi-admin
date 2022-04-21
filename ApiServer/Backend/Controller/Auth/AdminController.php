<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Controller\Auth;

use Imi\Server\Http\Route\Annotation\Action;
use Imi\Server\Http\Route\Annotation\Controller;
use Imi\Server\Http\Route\Annotation\Route;
use ImiApp\ApiServer\Backend\Model\SoAdmin;
use ImiApp\ApiServer\Backend\Model\SoAdminOperateLog;
use ImiApp\ApiServer\Backend\Model\SoAuthGroupAccess;
use Phpben\Imi\Auth\Annotation\Auth;
use Phpben\Imi\Validate\Annotation\Validate;
use Psr\Http\Message\ResponseInterface;
use Imi\Aop\Annotation\Inject;
use ImiApp\ApiServer\Backend\Controller\CommonController;

/**
 * @Auth(name="backend")
 * @Controller("/auth/admin/")
 */
class AdminController extends CommonController
{
    /**
     * @Inject("AuthAdminService")
     * 
     * @var \ImiApp\ApiServer\Backend\Service\Auth\AdminService
     */
    protected $service;

    /**
     * @Action
     * @Route("read")
     * @return ResponseInterface
     */
    public function read(): ResponseInterface
    {
        return $this->response->success(null, $this->service->read() ?: []);
    }

    /**
     * @Action
     * @Route(url="create",method="POST")
     * @Validate
     * @param $data
     * @return ResponseInterface
     */
    public function create($data): ResponseInterface
    {
        return $this->service->create($data) ? $this->response->success('创建成功') : $this->response->error($this->service->getError());
    }

    /**
     * @Action
     * @Route(url="update",method="POST")
     * @Validate
     * @param $data
     * @return ResponseInterface
     */
    public function update($data): ResponseInterface
    {
        return $this->service->update($data) ? $this->response->success('更新成功') : $this->response->error($this->service->getError());
    }

    /**
     * @Action
     * @Route(url="delete",method="POST")
     * @return ResponseInterface
     */
    public function delete(): ResponseInterface
    {
        return $this->service->delete() ? $this->response->success('删除成功') : $this->response->error($this->service->getError());
    }

    /**
     * @Action
     * @Route("operatelog")
     * @return ResponseInterface
     */
    public function operatelog(): ResponseInterface
    {
        return $this->response->success(null, $this->service->getOperateLog());
    }

    /**
     * @Action
     * @Route("loginlog")
     * @return ResponseInterface
     */
    public function loginlog(): ResponseInterface
    {
        return $this->response->success(null, $this->service->getLoginLog());
    }

    /**
     * @Action
     * @Route(url="profile",method="POST")
     * @return ResponseInterface
     */
    public function profile(): ResponseInterface
    {
        $body = $this->request->getParsedBody();
        return $this->response->success('更新成功', $this->service->updateProfile([
            'avatar' => $body['avatar'] ?? "",
            'password' => $body['password'] ?? "",
            'email' => $body['email'] ?? "",
        ]));
    }

}