<?php

declare(strict_types=1);

namespace ImiApp\ImiServer;

use Imi\Server\Http\Message\Proxy\RequestProxy;
use Imi\Bean\Annotation\Inherit;

/**
 * @Inherit
 */
class Request extends RequestProxy
{
    public function getRaw()
    {
        return json_decode($this->getSwooleRequest()->rawContent(), true);
    }

}