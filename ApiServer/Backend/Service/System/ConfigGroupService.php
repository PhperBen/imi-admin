<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Service\System;

use Imi\Bean\Annotation\Inherit;
use ImiApp\ApiServer\Backend\Model\SoConfigGroup;
use ImiApp\ImiServer\AbstractService;
use Imi\Bean\Annotation\Bean;
use ImiApp\ImiServer\Exception\ServiceException;

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

    /**
     * 读取
     * @param bool $isPage
     * @return mixed
     */
    public function read(bool $isPage = true): mixed
    {
        return $this->model::getAssocList($this->model::query()->order("sort", "desc"));
    }

    protected function _before_create($data)
    {
        if ($data['pid'] !== 0) {
            $res = $this->model::find($data['pid']);
            if ($res['pid'] !== 0) {
                throw new ServiceException("只支持二级分类");
            }
        }
    }

    protected function _before_update($data)
    {
        if ($data['pid'] !== 0) {
            $res = $this->model::find($data['pid']);
            if ($res['pid'] !== 0) {
                throw new ServiceException("只支持二级分类");
            }
        }
    }
}
