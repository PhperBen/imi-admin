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
 * 权限分组 基类.
 *
 * @Entity(camel=false, bean=true)
 * @Table(name=@ConfigValue(name="@app.models.ImiApp\ApiServer\Backend\Model\SoAuthGroup.name", default="so_auth_group"), id={"id"}, dbPoolName=@ConfigValue(name="@app.models.ImiApp\ApiServer\Backend\Model\SoAuthGroup.poolName"))
 * @DDL(sql="CREATE TABLE `so_auth_group` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `pid` int unsigned NOT NULL COMMENT '父亲',
  `name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '组名',
  `rules` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '规则',
  `status` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int unsigned NOT NULL COMMENT '创建时间',
  `update_time` int unsigned DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='权限分组'", decode="")
 *
 * @property int|null $id 
 * @property int|null $pid 父亲
 * @property string|null $name 组名
 * @property string|null $rules 规则
 * @property int|null $status 状态
 * @property int|null $createTime 创建时间
 * @property int|null $updateTime 更新时间
 */
abstract class SoAuthGroupBase extends Model
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
     * 组名.
     * name
     * @Column(name="name", type="varchar", length=32, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $name = NULL;

    /**
     * 获取 name - 组名.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * 赋值 name - 组名.
     * @param string|null $name name
     * @return static
     */
    public function setName($name)
    {
        $this->name = null === $name ? null : (string)$name;
        return $this;
    }

    /**
     * 规则.
     * rules
     * @Column(name="rules", type="text", length=0, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $rules = NULL;

    /**
     * 获取 rules - 规则.
     *
     * @return string|null
     */
    public function getRules(): ?string
    {
        return $this->rules;
    }

    /**
     * 赋值 rules - 规则.
     * @param string|null $rules rules
     * @return static
     */
    public function setRules($rules)
    {
        $this->rules = null === $rules ? null : (string)$rules;
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
