<?php

declare(strict_types=1);

namespace ImiApp\ImiServer;

use Imi\Server\Contract\IServer;
use Imi\Aop\Annotation\Inject;

class HttpController
{
    /**
     * 响应
     * @Inject(Response::class)
     */
    public $response;

    /**
     * 请求
     * @Inject(Request::class)
     */
    public $request;

    public function __construct(IServer $server)
    {
        $this->server = $server;
        if (method_exists($this, '__init')) {
            $this->__init();
        }
    }
}