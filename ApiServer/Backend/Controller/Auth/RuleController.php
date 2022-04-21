<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Controller\Auth;

use Imi\Server\Http\Route\Annotation\Action;
use Imi\Server\Http\Route\Annotation\Controller;
use Imi\Server\Http\Route\Annotation\Route;
use ImiApp\ApiServer\Backend\Model\SoAuthRule;
use Phpben\Imi\Auth\Annotation\Auth;
use Phpben\Imi\Validate\Annotation\Validate;
use Psr\Http\Message\ResponseInterface;
use Imi\Aop\Annotation\Inject;
use ImiApp\ApiServer\Backend\Controller\CommonController;

/**
 * @Auth(name="backend")
 * @Controller("/auth/rule/")
 */
class RuleController extends CommonController
{
    /**
     * @Inject("AuthRuleService")
     * 
     * @var \ImiApp\ApiServer\Backend\Service\Auth\RuleService
     */
    protected $service;

    /**
     * 读取
     * @Action
     * @Route("read")
     * @return ResponseInterface
     */
    public function read(): ResponseInterface
    {
        return $this->response->success('操作成功', $this->service->getList($this->auth->auth()));
    }

    /**
     * 控制器
     * @Action
     * @Route(url="controllers",method="GET")
     * @return ResponseInterface
     */
    public function controllers(): ResponseInterface
    {
        return $this->response->success('操作成功', $this->service->getControllers());
    }

    /**
     * 方法
     * @Action
     * @Route(url="methods",method="POST")
     * @Validate
     * @param $data
     * @return ResponseInterface
     */
    public function methods($data): ResponseInterface
    {
        try {
            $data->class = str_replace('\\\\', '\\', $data->class);
            if (!class_exists($data->class)) {
                return $this->response->error('命名空间不存在');
            }
        } catch (\Exception $e) {
            return $this->response->error('命名空间不存在');
        }
        return $this->response->success('操作成功', $this->service->getMethods($data->class));
    }

    /**
     * 创建
     * @Action
     * @Route(url="create",method="POST")
     * @Validate
     * @param $data
     * @return ResponseInterface
     */
    public function create($data): ResponseInterface
    {
        $create = $this->service->create($data);
        return $create ? $this->response->success('创建成功', SoAuthRule::find($create)->toArray()) : $this->response->error($this->service->getError());
    }

    /**
     * 更新
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
     * 删除
     * @Action
     * @Route(url="delete",method="POST")
     * @return ResponseInterface
     */
    public function delete(): ResponseInterface
    {
        return $this->service->delete() ? $this->response->success('删除成功') : $this->response->error($this->service->getError());
    }

    /**
     * 拖拽排序
     * @Action
     * @Route(url="sort",method="POST")
     * @Validate
     * @param $data
     * @return ResponseInterface
     */
    public function sort($data): ResponseInterface
    {
        return $this->service->draggable($data) ? $this->response->success('操作成功') : $this->response->error($this->service->getError());
    }
}
