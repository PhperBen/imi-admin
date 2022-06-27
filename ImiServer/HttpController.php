<?php

declare(strict_types=1);

namespace ImiApp\ImiServer;

use Imi\Aop\Annotation\Inject;

class HttpController extends \Imi\Server\Http\Controller\HttpCOntroller
{
    /**
     * 响应
     * @Inject(Response::class)
     */
    public \Imi\Server\Http\Message\Contract\IHttpResponse $response;

    /**
     * 请求
     * @Inject(Request::class)
     */
    public \Imi\Server\Http\Message\Contract\IHttpRequest $request;

}