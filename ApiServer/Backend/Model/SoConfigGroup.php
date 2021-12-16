<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Model;

use Imi\Bean\Annotation\Inherit;
use ImiApp\ApiServer\Backend\Model\Base\SoConfigGroupBase;
use Imi\Model\Tree\TTreeModel;
use Imi\Model\Annotation\Column;
use Imi\Model\Tree\Annotation\TreeModel;

/**
 * 配置分组.
 *
 * @Inherit
 * @TreeModel(idField="id", parentField="pid", childrenField="children")
 */
class SoConfigGroup extends SoConfigGroupBase
{
    use TTreeModel;

    /**
     * 子节点集合
     *
     * @Column(virtual=true)
     *
     * @var static[]
     */
    protected $children = [];

    /**
     * Get 子节点集合
     *
     * @return static[]
     */
    public function &getChildren()
    {
        return $this->children;
    }

    /**
     * Set 子节点集合
     *
     * @param static[] $children
     *
     * @return self
     */
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }

    public static function getSortPk(): string
    {
        return 'sort';
    }
}
