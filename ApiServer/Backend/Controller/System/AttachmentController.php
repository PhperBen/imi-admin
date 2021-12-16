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
 * @Controller("/system/attachment/")
 */
class AttachmentController extends CommonController
{
    /**
     * @Inject("SystemAttachmentService")
     */
    protected $service;

    /**
     * @Action
     * @Route(url="create",method="POST")
     * @return ResponseInterface
     */
    public function create(): ResponseInterface
    {
        $create = $this->service->pull($this->request->getUploadedFiles());
        return $create ? $this->response->success('上传成功', $create) : $this->response->error($this->service->getError());
    }
}