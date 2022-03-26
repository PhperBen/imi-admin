<?php

declare(strict_types=1);

namespace ImiApp\ImiServer;

use Imi\Aop\Annotation\Inject;
use ImiApp\ImiServer\Traits\Service;

abstract class AbstractService
{
    use Service;

    /**
     * 请求
     * @Inject(Request::class)
     */
    public $request;

    /**
     * 错误信息
     * @var string
     */
    protected string $_error = '操作失败';

    /**
     * 获取错误信息
     * @return string
     */
    public function getError(): string
    {
        return $this->_error;
    }

    /**
     * 设置错误信息
     * @param string $error
     * @return $this
     */
    protected function setError(string $error)
    {
        $this->_error = $error;
        return $this;
    }
}