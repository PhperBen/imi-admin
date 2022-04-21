<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Controller\System;

use Imi\App;
use Imi\AppContexts;
use Imi\Server\Http\Route\Annotation\Action;
use Imi\Server\Http\Route\Annotation\Controller;
use Imi\Server\Http\Route\Annotation\Route;
use Imi\Util\File;
use Phpben\Imi\Auth\Annotation\Auth;
use Phpben\Imi\Validate\Annotation\Validate;
use Psr\Http\Message\ResponseInterface;
use ImiApp\ApiServer\Backend\Controller\CommonController;
use Imi\Aop\Annotation\Inject;

/**
 * @Auth(name="backend",nologin={"zip"})
 * @Controller("/system/autocode/")
 */
class AutocodeController extends CommonController
{
    /**
     * @Inject("SystemAutocodeService")
     * 
     * @var \ImiApp\ApiServer\Backend\Service\System\AutocodeService
     */
    protected $service;

    /**
     * @Action
     * @Route("models")
     * @return ResponseInterface
     */
    public function models(): ResponseInterface
    {
        return $this->response->success(null, $this->service->getModels());
    }

    /**
     * @Action
     * @Route("info")
     * @return ResponseInterface
     */
    public function info(): ResponseInterface
    {
        return $this->response->success(null, $this->service->getInfo($this->request->request('model')));
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
        $service = $this->service->build($data);
        return $service ? $this->response->success("操作成功", $service) : $this->response->error($this->service->getError());
    }

    /**
     * @Action
     * @Route(url="exec",method="POST")
     * @Validate(security=false)
     * @param $data
     * @return ResponseInterface
     */
    public function exec($data): ResponseInterface
    {
        $service = $this->service->exec($data);
        return $service ? $this->response->success("操作成功", $service) : $this->response->error($this->service->getError());
    }

    /**
     * @Action
     * @Route(url="zip",method="GET")
     * @return ResponseInterface
     */
    public function zip(): ResponseInterface
    {
        $zipFile = File::path(App::get(AppContexts::APP_PATH), '/.runtime') . '/build.zip';
        if (!file_exists($zipFile)) {
            return $this->response->error('文件不存在');
        }
        return $this->response->sendFile($zipFile);
    }
}