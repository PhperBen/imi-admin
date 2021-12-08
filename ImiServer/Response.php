<?php

declare(strict_types=1);

namespace ImiApp\ImiServer;

use Hyperf\HttpMessage\Stream\SwooleStream;
use Imi\Server\Http\Message\Proxy\ResponseProxy;
use Imi\Util\Http\Consts\ResponseHeader;
use Imi\Util\Http\Consts\MediaType;

class Response extends ResponseProxy
{
    /**
     * 失败响应
     * @param string $message
     * @param mixed|array $data
     * @param int $code
     * @return Response|ResponseProxy
     */
    public function error(string $message = '', mixed $data = [], int $code = 500): Response|ResponseProxy
    {
        $data = [
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];
        return $this->json($data);
    }

    /**
     * 成功响应
     * @param string $message
     * @param mixed|array $data
     * @param int $code
     * @return Response|ResponseProxy
     */
    public function success(string $message = '', mixed $data = [], int $code = 200): Response|ResponseProxy
    {
        $data = [
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];
        return $this->json($data);
    }

    /**
     * json数据
     * @param array $data 内容
     * @param int $code 状态码
     * @return Response|ResponseProxy
     */
    public function json(array $data, int $code = 200): Response|ResponseProxy
    {
        return $this->withHeader(ResponseHeader::CONTENT_TYPE, MediaType::APPLICATION_JSON_UTF8)->withStatus(200)->withBody(new SwooleStream(json_encode($data, 256 | 64)));
    }
}