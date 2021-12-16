<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Service\System;

use Imi\Bean\Annotation\Inherit;
use Imi\Config;
use Imi\Log\Log;
use ImiApp\ApiServer\Backend\Model\SoConfig;
use ImiApp\ApiServer\Backend\Model\SoConfigGroup;
use ImiApp\ImiServer\AbstractService;
use Imi\Bean\Annotation\Bean;
use ImiApp\ImiServer\Exception\ServiceException;

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

    public function read(bool $isPage = true): mixed
    {
        $group_id = (int)$this->request->request('group_id');
        if (!$group_id) {
            return [];
        }
        $group = SoConfigGroup::find($group_id);
        if (!$group || $group['pid'] !== 0) {
            return [];
        }
        $groups = SoConfigGroup::query()->where("pid", '=', $group_id)->select()->getArray();
        $list = [];
        foreach ($groups as $k => $v) {
            $config = $this->model::query()->where("pid", '=', $v['id'])->order("id", "asc")->select()->getArray();
            foreach ($config as &$item) {
                $item = $item->toArray();
                $item['value'] = is_null(json_decode($item['value'])) ? $item['value'] : json_decode($item['value'], true);
                $item['variable'] = is_null(json_decode($item['variable'])) ? $item['variable'] : json_decode($item['variable'], true);
            }
            $list[] = [
                'key' => $v['id'],
                'val' => $v['name'],
                'config' => $config,
            ];
        }
        return $list;
    }

    protected function _before_create($data)
    {
        $group = SoConfigGroup::find($data['pid']);
        if (!$group || $group['pid'] == 0) {
            throw new ServiceException('所选分类不存在');
        }
        $row = $this->model::find(['key' => $data['key']]);
        if ($row) {
            throw new ServiceException('配置已存在，不能重复添加');
        }
    }

    public function update($data): mixed
    {
        $config = [];
        foreach ($data as $k => $v) {
            $res = $this->model::find([
                'key' => $k
            ]);
            if ($res) {
                $config[$k] = $v;
                if (is_array($v)) $v = json_encode($v, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                $res->update(['value' => $v]);
            }
        }
        if (!$config) {
            $this->setError('配置不存在');
            return false;
        }
        try {
            $configDriver = Config::get('@app.beans.ConfigCenter.driver');
            $configClass = new $configDriver;
            $rowConfigs = $configClass->get();
            $newConfigs = array_merge($rowConfigs, $config);
            $configClass->pull($newConfigs);
        } catch (\Exception $e) {
            Log::error($e);
            $this->setError('配置驱动出错');
            return false;
        }
        return true;
    }
}
