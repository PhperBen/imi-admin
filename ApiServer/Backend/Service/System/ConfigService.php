<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Service;

use Imi\Bean\Annotation\Inherit;
use ImiApp\ApiServer\Backend\Model\SoConfig;
use ImiApp\ImiServer\AbstractService;
use Imi\Bean\Annotation\Bean;

/**
 * @Inherit
 * @Bean("SystemConfigService")
 */
class ConfigService extends AbstractService
{
    /**
     * @var string
     */
    public $model = SoConfig::class;
}
