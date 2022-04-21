<?php
declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Controller;

use Imi\Server\Http\Route\Annotation\Action;
use Imi\Server\Http\Route\Annotation\Controller;
use Imi\Server\Http\Route\Annotation\Route;
use Phpben\Imi\Validate\Annotation\Validate;
use Psr\Http\Message\ResponseInterface;
use Imi\Aop\Annotation\Inject;
use Phpben\Imi\Auth\Annotation\Auth;

use ImiApp\ApiServer\Backend\Controller\CommonController as CommonController;

/**
 * @Auth(name="backend")
 * @Controller("/user/")
 */
class UserController extends CommonController
{
    /**
     * @Inject("UserService")
     * 
     * @var \ImiApp\ApiServer\Backend\Service\UserService
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
     * @Route(url="operate",method="POST")
     * @return ResponseInterface
    */
    public function operate(): ResponseInterface
    {
        return $this->service->operate() ? $this->response->success('操作成功') : $this->response->error($this->service->getError());
    }

        
}