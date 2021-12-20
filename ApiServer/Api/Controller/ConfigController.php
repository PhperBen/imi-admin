<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Api\Controller;

use Imi\Server\Http\Route\Annotation\Action;
use Imi\Server\Http\Route\Annotation\Controller;
use Imi\Server\Http\Route\Annotation\Route;
use Psr\Http\Message\ResponseInterface;
use Imi\Aop\Annotation\Inject;

/**
 * 配置获取
 * @Controller("/config/")
 */
class ConfigController extends CommonController
{
    // 允许展示的配置
    protected array $config = [
        'user_verify',
        'login',
        'register',
    ];

    /**
     * 获取
     * @Action
     * @Route("get")
     * @return ResponseInterface
     */
    public function get(): ResponseInterface
    {
        return $this->response->success(null, $this->__getConfig());
    }

    /**
     * 配置可在此动态修改
     * @return array
     */
    private function __getConfig(): array
    {
        $config = [];
        foreach ($this->config as $name) {
            $config[$name] = config($name);
        }
        return $config;
    }
}
