<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Model\Base;

use Imi\Config\Annotation\ConfigValue;
use Imi\Model\Annotation\Column;
use Imi\Model\Annotation\DDL;
use Imi\Model\Annotation\Entity;
use Imi\Model\Annotation\Table;
use Imi\Model\Model as Model;

/**
 * 权限菜单 基类.
 *
 * @Entity(camel=true, bean=true)
 * @Table(name=@ConfigValue(name="@app.models.ImiApp\ApiServer\Backend\Model\SoAuthRule.name", default="so_auth_rule"), id={"id"}, dbPoolName=@ConfigValue(name="@app.models.ImiApp\ApiServer\Backend\Model\SoAuthRule.poolName"))
 * @DDL(sql="CREATE TABLE `so_auth_rule` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `sort` int unsigned NOT NULL DEFAULT '50' COMMENT '排序',
  `status` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `pid` int unsigned NOT NULL COMMENT '父亲',
  `name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '名称',
  `icon` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '图标',
  `route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '路由',
  `redirect` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '重定向',
  `type` enum('menu','iframe','button','redirect') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'menu' COMMENT '类型',
  `view` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '视图',
  `create_time` int unsigned NOT NULL COMMENT '创建时间',
  `update_time` int unsigned DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='权限菜单'", decode="")
 *
 * @property int|null $id 
 * @property int|null $sort 排序
 * @property int|null $status 状态
 * @property int|null $pid 父亲
 * @property string|null $name 名称
 * @property string|null $icon 图标
 * @property string|null $route 路由
 * @property string|null $redirect 重定向
 * @property string|null $type 类型
 * @property string|null $view 视图
 * @property int|null $createTime 创建时间
 * @property int|null $updateTime 更新时间
 */
abstract class SoAuthRuleBase extends Model
{
    /**
     * id.
     * @Column(name="id", type="int unsigned", length=0, accuracy=0, nullable=false, default="", isPrimaryKey=true, primaryKeyIndex=0, isAutoIncrement=true)
     * @var int|null
     */
    protected ?int $id = NULL;

    /**
     * 获取 id.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * 赋值 id.
     * @param int|null $id id
     * @return static
     */
    public function setId($id)
    {
        $this->id = null === $id ? null : (int)$id;
        return $this;
    }

    /**
     * 排序.
     * sort
     * @Column(name="sort", type="int unsigned", length=0, accuracy=0, nullable=false, default="50", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var int|null
     */
    protected ?int $sort = NULL;

    /**
     * 获取 sort - 排序.
     *
     * @return int|null
     */
    public function getSort(): ?int
    {
        return $this->sort;
    }

    /**
     * 赋值 sort - 排序.
     * @param int|null $sort sort
     * @return static
     */
    public function setSort($sort)
    {
        $this->sort = null === $sort ? null : (int)$sort;
        return $this;
    }

    /**
     * 状态.
     * status
     * @Column(name="status", type="tinyint unsigned", length=0, accuracy=0, nullable=false, default="1", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var int|null
     */
    protected ?int $status = NULL;

    /**
     * 获取 status - 状态.
     *
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * 赋值 status - 状态.
     * @param int|null $status status
     * @return static
     */
    public function setStatus($status)
    {
        $this->status = null === $status ? null : (int)$status;
        return $this;
    }

    /**
     * 父亲.
     * pid
     * @Column(name="pid", type="int unsigned", length=0, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var int|null
     */
    protected ?int $pid = NULL;

    /**
     * 获取 pid - 父亲.
     *
     * @return int|null
     */
    public function getPid(): ?int
    {
        return $this->pid;
    }

    /**
     * 赋值 pid - 父亲.
     * @param int|null $pid pid
     * @return static
     */
    public function setPid($pid)
    {
        $this->pid = null === $pid ? null : (int)$pid;
        return $this;
    }

    /**
     * 名称.
     * name
     * @Column(name="name", type="varchar", length=32, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $name = NULL;

    /**
     * 获取 name - 名称.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * 赋值 name - 名称.
     * @param string|null $name name
     * @return static
     */
    public function setName($name)
    {
        $this->name = null === $name ? null : (string)$name;
        return $this;
    }

    /**
     * 图标.
     * icon
     * @Column(name="icon", type="varchar", length=64, accuracy=0, nullable=true, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $icon = NULL;

    /**
     * 获取 icon - 图标.
     *
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * 赋值 icon - 图标.
     * @param string|null $icon icon
     * @return static
     */
    public function setIcon($icon)
    {
        $this->icon = null === $icon ? null : (string)$icon;
        return $this;
    }

    /**
     * 路由.
     * route
     * @Column(name="route", type="varchar", length=255, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $route = NULL;

    /**
     * 获取 route - 路由.
     *
     * @return string|null
     */
    public function getRoute(): ?string
    {
        return $this->route;
    }

    /**
     * 赋值 route - 路由.
     * @param string|null $route route
     * @return static
     */
    public function setRoute($route)
    {
        $this->route = null === $route ? null : (string)$route;
        return $this;
    }

    /**
     * 重定向.
     * redirect
     * @Column(name="redirect", type="varchar", length=255, accuracy=0, nullable=true, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $redirect = NULL;

    /**
     * 获取 redirect - 重定向.
     *
     * @return string|null
     */
    public function getRedirect(): ?string
    {
        return $this->redirect;
    }

    /**
     * 赋值 redirect - 重定向.
     * @param string|null $redirect redirect
     * @return static
     */
    public function setRedirect($redirect)
    {
        $this->redirect = null === $redirect ? null : (string)$redirect;
        return $this;
    }

    /**
     * 类型.
     * type
     * @Column(name="type", type="enum", length=0, accuracy=0, nullable=false, default="menu", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $type = 'menu';

    /**
     * 获取 type - 类型.
     *
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * 赋值 type - 类型.
     * @param string|null $type type
     * @return static
     */
    public function setType($type)
    {
        $this->type = null === $type ? null : (string)$type;
        return $this;
    }

    /**
     * 视图.
     * view
     * @Column(name="view", type="varchar", length=255, accuracy=0, nullable=true, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $view = NULL;

    /**
     * 获取 view - 视图.
     *
     * @return string|null
     */
    public function getView(): ?string
    {
        return $this->view;
    }

    /**
     * 赋值 view - 视图.
     * @param string|null $view view
     * @return static
     */
    public function setView($view)
    {
        $this->view = null === $view ? null : (string)$view;
        return $this;
    }

    /**
     * 创建时间.
     * create_time
     * @Column(name="create_time", type="int unsigned", length=0, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var int|null
     */
    protected ?int $createTime = NULL;

    /**
     * 获取 createTime - 创建时间.
     *
     * @return int|null
     */
    public function getCreateTime(): ?int
    {
        return $this->createTime;
    }

    /**
     * 赋值 createTime - 创建时间.
     * @param int|null $createTime create_time
     * @return static
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = null === $createTime ? null : (int)$createTime;
        return $this;
    }

    /**
     * 更新时间.
     * update_time
     * @Column(name="update_time", type="int unsigned", length=0, accuracy=0, nullable=true, default="0", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var int|null
     */
    protected ?int $updateTime = NULL;

    /**
     * 获取 updateTime - 更新时间.
     *
     * @return int|null
     */
    public function getUpdateTime(): ?int
    {
        return $this->updateTime;
    }

    /**
     * 赋值 updateTime - 更新时间.
     * @param int|null $updateTime update_time
     * @return static
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = null === $updateTime ? null : (int)$updateTime;
        return $this;
    }

}
