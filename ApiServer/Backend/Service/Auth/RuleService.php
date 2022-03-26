<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Service\Auth;

use Imi\Bean\Annotation\Inherit;
use Imi\Util\ArrayUtil;
use Imi\Util\Imi;
use ImiApp\ApiServer\Backend\Model\SoAuthRule;
use ImiApp\ImiServer\AbstractService;
use Imi\Bean\Annotation\Bean;
use Imi\Aop\Annotation\Inject;

/**
 * @Inherit
 * @Bean("AuthRuleService")
 */
class RuleService extends AbstractService
{
    /**
     * @var string
     */
    public $model = SoAuthRule::class;

    /**
     * 创建
     * @param $data
     * @return bool
     */
    public function create($data)
    {
        $model = $this->model::newInstance();
        $model->insert($data);
        return $model->getId();
    }

    /**
     * 删除前查找所有id下级一并删除
     * @param $ids
     */
    protected function _before_delete(&$ids)
    {
        $ids = array_merge($ids, $this->model::getChildPk($ids));
    }

    /**
     * 返回树状数据
     * @param $auth
     * @return array
     */
    public function getList($auth): array
    {
        $ids = $auth->getRuleIds();
        $query = SoAuthRule::query();
        !($ids === ['*']) && $query = $query->whereIn('id', $ids);
        $list = $query->order("sort", "desc")->select()->getArray();
        foreach ($list as &$item) {
            $item = $item->toArray();
        }
        return ArrayUtil::toTreeAssoc($list, 'id', 'pid');
    }

    /**
     * 返回所有控制器
     * @return array
     */
    public function getControllers(): array
    {
        $files = [];
        getControllerFiles(Imi::getNamespacePaths('ImiApp\ApiServer')[0], $files);
        return $files;
    }

    /**
     * 返回控制器方法
     * @param string $class
     * @return array
     */
    public function getMethods(string $class): array
    {
        return get_public_class_methods($class);
    }
}