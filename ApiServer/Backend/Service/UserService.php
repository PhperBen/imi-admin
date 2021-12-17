<?php
declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Service;

use Imi\Bean\Annotation\Inherit;
use ImiApp\ImiServer\AbstractService;
use Imi\Bean\Annotation\Bean;
use Imi\Aop\Annotation\Inject;
use ImiApp\ImiServer\Exception\ServiceException;
use ImiApp\ApiServer\Backend\Model\User as Model;

/**
 * @Inherit
 * @Bean("UserService")
 */
class UserService extends AbstractService
{
    /**
     * @var string
     */
    public $model = Model::class;

}