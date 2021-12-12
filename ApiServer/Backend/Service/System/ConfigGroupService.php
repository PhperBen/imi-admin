<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Service;

use Imi\Bean\Annotation\Inherit;
use ImiApp\ApiServer\Backend\Model\SoConfigGroup;
use ImiApp\ImiServer\AbstractService;
use Imi\Bean\Annotation\Bean;

/**
 * @Inherit
 * @Bean("SystemConfigGroupService")
 */
class ConfigGroupService extends AbstractService
{
    /**
     * @var string
     */
    public $model = SoConfigGroup::class;
}
