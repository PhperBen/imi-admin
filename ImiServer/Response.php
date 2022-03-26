<?php

declare(strict_types=1);

namespace ImiApp\ImiServer;

use Imi\Util\Stream\MemoryStream;
use Imi\Server\Http\Message\Proxy\ResponseProxy;
use Imi\Util\Http\Consts\ResponseHeader;
use Imi\Util\Http\Consts\MediaType;
use Imi\Bean\Annotation\Inherit;
use Psr\Http\Message\ResponseInterface;

/**
 * @Inherit
 */
class Response extends ResponseProxy
{
    /**
     * 失败响应
     * @param string|null $message
     * @param mixed $data
     * @param int $code
     * @return ResponseInterface
     */
    public function error(?string $message = null, $data = null, int $code = 500): ResponseInterface
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
     * @param string|null $message
     * @param mixed $data
     * @param int $code
     * @return ResponseInterface
     */
    public function success(?string $message = null, $data = null, int $code = 200): ResponseInterface
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
     * @return ResponseInterface
     */
    public function json(array $data, int $code = 200): ResponseInterface
    {
        return $this->withHeader(ResponseHeader::CONTENT_TYPE, MediaType::APPLICATION_JSON_UTF8)->withStatus(200)->withBody(new MemoryStream(json_encode($data, 256 | 64)));
    }
}