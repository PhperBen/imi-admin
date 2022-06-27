<?php

declare(strict_types=1);

namespace ImiApp\ImiServer;

use Imi\Server\Http\Message\Proxy\RequestProxy;
use Imi\Bean\Annotation\Inherit;

/**
 * @Inherit
 */
class Request extends \Imi\Server\Http\Message\Proxy\RequestProxyObject
{
    /**
     * 取Swoole原始的POST包体
     * @return mixed
     */
    public function getRaw()
    {
        return json_decode($this->getSwooleRequest()->rawContent(), true);
    }

    /**
     * 获取post(兼容application/json和application/x-www-urlencode)
     * @param string|null $name
     * @param $default
     * @return mixed
     */
    public function post(?string $name = null, $default = null)
    {
        $value = parent::post($name, $default);
        if ((!$value || $default == $value) && ($this->getParsedBody()[$name] ?? null)) {
            return $this->getParsedBody()[$name];
        }
        return $value;
    }

}