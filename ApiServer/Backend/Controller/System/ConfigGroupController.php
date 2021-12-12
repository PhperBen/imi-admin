<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Controller\System;

use Imi\Server\Http\Route\Annotation\Action;
use Imi\Server\Http\Route\Annotation\Controller;
use Imi\Server\Http\Route\Annotation\Route;
use Phpben\Imi\Auth\Annotation\Auth;
use Phpben\Imi\Validate\Annotation\Validate;
use Psr\Http\Message\ResponseInterface;
use Imi\Aop\Annotation\Inject;

/**
 * @Auth("backend")
 * @Controller("/system/config/group/")
 */
class ConfigGroupController extends CommonController
{
    /**
     * @Inject("SystemConfigGroupService")
     */
    protected $service;
}
