<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Controller\System;

use Imi\Server\Http\Route\Annotation\Action;
use Imi\Server\Http\Route\Annotation\Controller;
use Imi\Server\Http\Route\Annotation\Route;
use Phpben\Imi\Auth\Annotation\Auth;
use Phpben\Imi\Validate\Annotation\Validate;
use Psr\Http\Message\ResponseInterface;
use ImiApp\ApiServer\Backend\Controller\CommonController;
use Imi\Aop\Annotation\Inject;

/**
 * @Auth("backend")
 * @Controller("/system/config/")
 */
class ConfigController extends CommonController
{
    /**
     * @Inject("SystemConfigService")
     * 
     * @var \ImiApp\ApiServer\Backend\Service\System\ConfigService
     */
    protected $service;

    /**
     * @Action
     * @Route("read")
     * @return ResponseInterface
     */
    public function read(): ResponseInterface
    {
        return $this->response->success(null, $this->service->read());
    }

    /**
     * @Action
     * @Route(url="create",method="POST")
     * @Validate(security=false)
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
     * @return ResponseInterface
     */
    public function update(): ResponseInterface
    {
        return $this->service->update($this->request->getParsedBody()) ? $this->response->success('保存成功') : $this->response->error($this->service->getError());
    }
}
