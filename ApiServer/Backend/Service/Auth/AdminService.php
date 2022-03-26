<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Service\Auth;

use Imi\Bean\Annotation\Inherit;
use Imi\Util\Random;
use ImiApp\ApiServer\Backend\Model\SoAdmin;
use ImiApp\ApiServer\Backend\Model\SoAdminLoginLog;
use ImiApp\ApiServer\Backend\Model\SoAdminOperateLog;
use ImiApp\ApiServer\Backend\Model\SoAuthGroup;
use ImiApp\ApiServer\Backend\Model\SoAuthGroupAccess;
use ImiApp\ImiServer\AbstractService;
use Imi\Bean\Annotation\Bean;
use Imi\Aop\Annotation\Inject;
use ImiApp\ImiServer\Exception\ServiceException;
use Phpben\Imi\Auth\AuthManager;

/**
 * @Inherit
 * @Bean("AuthAdminService")
 */
class AdminService extends AbstractService
{
    /**
     * Auth
     * @Inject(name=AuthManager::class,args={"backend"})
     */
    protected $auth;

    /**
     * @var string
     */
    public $model = SoAdmin::class;

    protected $grouName = [];
    protected $groups = [];

    public function getOperateLog(): array
    {
        $page = (int)$this->request->request('page', 1);
        $data = SoAdminOperateLog::query()->where('admin_id', '=', $this->auth->user()->id)->order('id', 'desc')->paginate($page, 10);
        return [
            'list' => $data->getList(),
            'total' => $data->getTotal(),
            'pageSize' => $data->getLimit(),
            'currentPage' => $data->getPageCount()
        ];
    }

    public function getLoginLog(): array
    {
        $page = (int)$this->request->request('page', 1);
        $data = SoAdminLoginLog::query()->where('username', '=', $this->auth->user()->username)->order('id', 'desc')->paginate($page, 10);
        return [
            'list' => $data->getList(),
            'total' => $data->getTotal(),
            'pageSize' => $data->getLimit(),
            'currentPage' => $data->getPageCount()
        ];
    }

    public function updateProfile($data): bool
    {
        $user = $this->model::find($this->auth->user()->id);
        if ($data['password']) {
            $data['salt'] = Random::letterAndNumber(6);
            $data['password'] = md5(md5($data['password']) . $data['salt']);
        } else {
            unset($data['password']);
        }
        if (!$data['avatar']) {
            unset($data['avatar']);
        }
        if (!$data['email']) {
            unset($data['email']);
        }
        $user->update($data);
        return true;
    }

    /**
     * 限定查询
     * @param $model
     */
    protected function _before_read(&$model)
    {
        $isSuper = $this->auth->auth()->isSuper();
        $user = $this->auth->user();
        $childrenAdminIds = $this->auth->auth()->getChildrenAdminIds($isSuper);
        $childrenGroupIds = $this->auth->auth()->getChildrenGroupIds($isSuper);
        $groups = $childrenGroupIds ? SoAuthGroup::query()->whereIn('id', $childrenGroupIds)->field('id', 'name')->select()->getArray() : [];
        $groupName = [];
        foreach ($groups as $k => $v) {
            $groupName[$v['id']] = $v['name'];
        }
        $authGroupList = $childrenGroupIds ? SoAuthGroupAccess::query()->whereIn('gid', $childrenGroupIds)->field('uid', 'gid')->select()->getArray() : [];
        $adminGroupName = [];
        foreach ($authGroupList as $k => $v) {
            if (isset($groupName[$v['gid']])) {
                $adminGroupName[$v['uid']][$v['gid']] = $groupName[$v['gid']];
            }
        }
        $groups = $this->auth->auth()->getGroups();
        foreach ($groups as $m => $n) {
            $adminGroupName[$user->id][$n['id']] = $n['name'];
        }
        $this->grouName = $adminGroupName;
        if (!$childrenAdminIds) {
            throw new ServiceException('暂无数据');
        }
        $model = $model->whereIn('id', $childrenAdminIds)->field('id', 'username', 'avatar', 'email', 'mobile', 'status', 'create_time', 'update_time');
    }

    /**
     * 追加数据
     * @param $data
     */
    protected function _after_read(&$data)
    {
        $adminGroupName = $this->grouName;
        foreach ($data['list'] as $k => $v) {
            $groups = $adminGroupName[$v->getId()] ?? [];
            $v->append([
                'groups'=>array_keys($groups),
                'groups_text'=>array_values($groups),
            ]);
        }
    }

    protected function _before_create(&$data)
    {
        $data['salt'] = Random::letterAndNumber(6);
        $data['password'] = md5(md5($data['password']) . $data['salt']);
        $group = $data['groups'];
        unset($data['groups']);
        $childrenGroupIds = $this->auth->auth()->getChildrenGroupIds($this->auth->auth()->isSuper());
        $group = array_intersect($childrenGroupIds, $group);
        if (!$group) {
            throw new ServiceException('父组别超出权限范围');
        }
        $this->group = $group;
    }

    protected function _after_create($id, $model)
    {
        foreach ($this->group as $value) {
            SoAuthGroupAccess::query()->insert(['uid' => $id, 'gid' => $value]);
        }
    }

    protected function _before_update(&$data)
    {
        $password = $this->request->post('password');
        if ($password) {
            $data['salt'] = Random::letterAndNumber(6);
            $data['password'] = md5(md5($data['password']) . $data['salt']);
        } else {
            if (isset($data['password'])) {
                unset($data['password']);
            }
            if (isset($data['salt'])) {
                unset($data['salt']);
            }
        }
        $group = $data['groups'];
        unset($data['groups']);
        $childrenGroupIds = $this->auth->auth()->getChildrenGroupIds($this->auth->auth()->isSuper());
        $group = array_intersect($childrenGroupIds, $group);
        if (!$group) {
            throw new ServiceException('父组别超出权限范围');
        }
        $this->group = $group;
    }

    protected function _after_update($id, $model)
    {
        SoAuthGroupAccess::query()->where('uid', '=', $id)->delete();
        foreach ($this->group as $value) {
            SoAuthGroupAccess::query()->insert(['uid' => $id, 'gid' => $value]);
        }
    }

    protected function _before_delete(&$ids)
    {
        $isSuper = $this->auth->auth()->isSuper();
        $user = $this->auth->user();
        $childrenAdminIds = $this->auth->auth()->getChildrenAdminIds($isSuper);
        $childrenGroupIds = $this->auth->auth()->getChildrenGroupIds($isSuper);
        $ids = array_intersect($childrenAdminIds, array_filter($ids));
        $query = SoAuthGroupAccess::query()->whereIn('gid', $childrenGroupIds)->field('uid')->select()->getColumn();
        $adminList = $this->model::query()->whereIn('id', $ids)->whereIn('id', $query)->select()->getArray();
        if ($adminList) {
            $deleteIds = [];
            foreach ($adminList as $k => $v) {
                $deleteIds[] = $v['id'];
            }
            $deleteIds = array_values(array_diff($deleteIds, [$user->id]));
            if ($deleteIds) {
                $ids = array_merge($ids, $deleteIds);
                SoAuthGroupAccess::query()->whereIn('uid', $deleteIds)->delete();
            }
        }
    }
}