<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Model\Base;

use Imi\Config\Annotation\ConfigValue;
use Imi\Model\Annotation\Column;
use Imi\Model\Annotation\DDL;
use Imi\Model\Annotation\Entity;
use Imi\Model\Annotation\Table;
use ImiApp\ImiServer\AbstractModel as Model;

/**
 * 配置分组 基类.
 *
 * @Entity(camel=false, bean=true)
 * @Table(name=@ConfigValue(name="@app.models.ImiApp\ApiServer\Backend\Model\SoConfigGroup.name", default="so_config_group"), id={"id"}, dbPoolName=@ConfigValue(name="@app.models.ImiApp\ApiServer\Backend\Model\SoConfigGroup.poolName"))
 * @DDL(sql="CREATE TABLE `so_config_group` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `pid` int unsigned NOT NULL COMMENT '父亲',
  `sort` int unsigned NOT NULL DEFAULT '50' COMMENT '排序',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '名称',
  `create_time` int unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='配置分组'", decode="")
 *
 * @property int|null $id 
 * @property int|null $pid 父亲
 * @property int|null $sort 排序
 * @property string|null $name 名称
 * @property int|null $createTime 创建时间
 */
abstract class SoConfigGroupBase extends Model
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
     * 名称.
     * name
     * @Column(name="name", type="varchar", length=255, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
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

}
