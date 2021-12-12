<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Service\Auth;

use Imi\Bean\Annotation\Inherit;
use ImiApp\ApiServer\Backend\Model\SoAuthGroup;
use ImiApp\ApiServer\Backend\Model\SoAuthGroupAccess;
use ImiApp\ImiServer\AbstractService;
use Imi\Bean\Annotation\Bean;
use Imi\Aop\Annotation\Inject;
use ImiApp\ImiServer\Exception\ServiceException;
use Phpben\Imi\Auth\AuthManager;

/**
 * @Inherit
 * @Bean("AuthGroupService")
 */
class GroupService extends AbstractService
{
    /**
     * Auth
     * @Inject(name=AuthManager::class,args={"backend"})
     */
    protected $auth;

    /**
     * @var string
     */
    public $model = SoAuthGroup::class;

    /**
     * 创建前处理
     * @param $data
     */
    protected function _before_create(&$data)
    {
        $ids = $this->auth->auth()->getChildrenGroupIds(true);
        if ($data['pid'] !== 0 && !in_array($data['pid'], $ids)) {
            throw new ServiceException('所选父级不存在');
        }
        if ($data['pid'] !== 0) {
            $parent = $this->model::find($data['pid']);
            if (!$parent) {
                throw new ServiceException("父级分组不存在");
            }
            $parent_rules = is_string($parent['rules']) ? explode(',', $parent['rules']) : $parent['rules'];
        } else {
            if (!$this->auth->auth()->isSuper()) {
                throw new ServiceException("请选择父级");
            }
            $parent_rules = $this->auth->auth()->getRuleIds();
        }
        $currentrules = $this->auth->auth()->getRuleIds();
        $rules = $data['rules'];
        $rules = in_array('*', $parent_rules) ? $rules : array_intersect($parent_rules, $rules);
        $rules = in_array('*', $currentrules) ? $rules : array_intersect($currentrules, $rules);
        if (in_array('*', $rules)) {
            throw new ServiceException("规则选择错误");
        }
        $data['rules'] = implode(',', $rules);
    }

    public function _before_delete(&$ids)
    {
        $grouplist = $this->auth->auth()->getGroups();
        $group_ids = array_map(function ($group) {
            return $group['id'];
        }, $grouplist);
        $ids = array_diff($ids, $group_ids);
        $grouplist = $this->model::query()->whereIn('id', $ids)->select()->getArray();
        foreach ($grouplist as $k => $v) {
            $groupone = SoAuthGroupAccess::query()->where('gid', '=', $v['id'])->select()->get();
            if ($groupone) {
                $ids = array_diff($ids, [$v['id']]);
                continue;
            }
            $groupone = $this->model::query()->where('pid', '=', $v['id'])->select()->get();
            if ($groupone) {
                $ids = array_diff($ids, [$v['id']]);
            }
        }
        if (!$ids) {
            throw new ServiceException("不能删除有管理员或有下级组的用户组");
        }
    }

    public function _before_update(&$data)
    {
        $childrenGroupIds = $this->auth->auth()->getChildrenGroupIds(true);
        if (!in_array($data['id'], $childrenGroupIds)) {
            throw new ServiceException('数据不存在');
        }
        if ($data['pid'] == 0) {
            if (!$this->auth->auth()->isSuper()) {
                throw new ServiceException("请选择父级");
            }
            $parent_rules = $this->auth->auth()->getRuleIds();
        } else {
            if (!in_array($data['pid'], $childrenGroupIds)) {
                throw new ServiceException('所选父级不存在');
            }
            if (in_array($data['pid'], (array)$this->model::find($data['id'])->getChildrenIds(null, true))) {
                throw new ServiceException("父级分组不存在");
            }
            $parent = $this->model::find($data['pid']);
            if (!$parent) {
                throw new ServiceException("父级分组不存在");
            }
            $parent_rules = is_string($parent['rules']) ? explode(',', $parent['rules']) : $parent['rules'];
        }
        $currentrules = $this->auth->auth()->getRuleIds();
        $rules = $data['rules'];
        $rules = in_array('*', $parent_rules) ? $rules : array_intersect($parent_rules, $rules);
        $rules = in_array('*', $currentrules) ? $rules : array_intersect($currentrules, $rules);
        $data['rules'] = implode(',', $rules);
        if ($childrenIds = (array)$this->model::find($data['id'])->getChildrenIds()) {
            $children_auth_groups = $this->model::query()->whereIn('id', $childrenIds)->select()->getArray();
            foreach ($children_auth_groups as $key => $children_auth_group) {
                $this->model::query()->where("id", '=', $children_auth_group['id'])->update(['rules' => implode(',', array_intersect(explode(',', $children_auth_group['rules']), $rules))]);
            }
        }
    }
}