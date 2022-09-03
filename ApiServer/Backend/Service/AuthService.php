<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Service;

use Imi\Bean\Annotation\Inherit;
use ImiApp\ApiServer\Backend\Model\SoAuthRule;
use ImiApp\ImiServer\AbstractService;
use Imi\Bean\Annotation\Bean;

/**
 * @Inherit
 * @Bean("AuthService")
 */
class AuthService extends AbstractService
{
    /**
     * 获取按钮权限
     * @param array $ids
     * @return array
     */
    public function getPermissions(array $ids): array
    {
        $query = SoAuthRule::query()->where("status", '=', 1)->where("type", '=', 'button');
        !($ids === ['*']) && $query = $query->whereIn('id', $ids);
        $query = $query->field('alias')->select()->getArray();
        $result = [];
        foreach ($query as $item) {
            $result[] = $item['alias'];
        }
        return $result;
    }

    /**
     * 获取菜单树状结构
     * @param array $ids
     * @return array
     */
    public function getMenu(array $ids): array
    {
        $query = SoAuthRule::query()->where("status", '=', 1)->where("type", '!=', 'button');
        !($ids === ['*']) && $query = $query->whereIn('id', $ids);
        $list = $query->field('id', 'pid', 'name', 'path', 'type', 'icon')->order('sort', 'desc')->select()->getArray();
        $list = $this->_getMenu($list);
        foreach ($list as $key => &$item) {
            if ($key == 0 && isset($item['children']) && $item['children']) {
                $item['children'][0]['meta']['affix'] = true;
            }
        }
        return $list;
    }

    /**
     * 树状结构
     * @param array $list
     * @return array
     */
    private function _getMenu(array $list): array
    {
        $result = $tmpArr = [];
        foreach ($list as &$item) {
            $item['children'] = [];
            $item = $item->toArray();
            $item['meta'] = ['title' => $item['name'], 'icon' => $item['icon'], 'type' => $item['type']];
            unset($item['name'], $item['icon'], $item['type']);
            $item['meta']['type'] == 'menu' && $item['component'] = trim((string)$item['path'], '/');
            $item['name'] = $item['meta']['type'] == 'link' ? $item['meta']['title'] : str_replace('/', '_', trim((string)$item['path'], '/'));
            $tmpArr[$item['id']] = $item;
        }
        unset($item);
        foreach ($tmpArr as $item) {
            if (isset($tmpArr[$item['pid']])) {
                $tmpArr[$item['pid']]['children'][] = &$tmpArr[$item['id']];
            } else {
                $result[] = &$tmpArr[$item['id']];
            }
        }
        return $this->_setMenu($result);
    }

    /**
     * 去除多余键
     * @param array $list
     * @return array
     */
    private function _setMenu(array $list): array
    {
        foreach ($list as &$item) {
            unset($item['id'], $item['pid']);
            if (isset($item['children']) && $item['children']) {
                unset($item['component']);
                $item['children'] = $this->_setMenu($item['children']);
            }
        }
        return $list;
    }
}
