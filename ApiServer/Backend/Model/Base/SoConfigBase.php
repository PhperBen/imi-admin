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
 * 配置 基类.
 *
 * @Entity(camel=true, bean=true)
 * @Table(name=@ConfigValue(name="@app.models.ImiApp\ApiServer\Backend\Model\SoConfig.name", default="so_config"), id={"id"}, dbPoolName=@ConfigValue(name="@app.models.ImiApp\ApiServer\Backend\Model\SoConfig.poolName"))
 * @DDL(sql="CREATE TABLE `so_config` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `pid` int unsigned NOT NULL COMMENT '配置组',
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '配置键',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '配置名称',
  `tip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '' COMMENT '提示说明',
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'string' COMMENT '配置类型',
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '' COMMENT '配置值',
  `variable` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '' COMMENT '配置变量',
  `create_time` int unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='配置'", decode="")
 *
 * @property int|null $id 
 * @property int|null $pid 配置组
 * @property string|null $key 配置键
 * @property string|null $name 配置名称
 * @property string|null $tip 提示说明
 * @property string|null $type 配置类型
 * @property string|null $value 配置值
 * @property string|null $variable 配置变量
 * @property int|null $createTime 创建时间
 */
abstract class SoConfigBase extends Model
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
     * 配置组.
     * pid
     * @Column(name="pid", type="int unsigned", length=0, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var int|null
     */
    protected ?int $pid = NULL;

    /**
     * 获取 pid - 配置组.
     *
     * @return int|null
     */
    public function getPid(): ?int
    {
        return $this->pid;
    }

    /**
     * 赋值 pid - 配置组.
     * @param int|null $pid pid
     * @return static
     */
    public function setPid($pid)
    {
        $this->pid = null === $pid ? null : (int)$pid;
        return $this;
    }

    /**
     * 配置键.
     * key
     * @Column(name="key", type="varchar", length=255, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $key = NULL;

    /**
     * 获取 key - 配置键.
     *
     * @return string|null
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * 赋值 key - 配置键.
     * @param string|null $key key
     * @return static
     */
    public function setKey($key)
    {
        $this->key = null === $key ? null : (string)$key;
        return $this;
    }

    /**
     * 配置名称.
     * name
     * @Column(name="name", type="varchar", length=255, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $name = NULL;

    /**
     * 获取 name - 配置名称.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * 赋值 name - 配置名称.
     * @param string|null $name name
     * @return static
     */
    public function setName($name)
    {
        $this->name = null === $name ? null : (string)$name;
        return $this;
    }

    /**
     * 提示说明.
     * tip
     * @Column(name="tip", type="varchar", length=255, accuracy=0, nullable=true, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $tip = '';

    /**
     * 获取 tip - 提示说明.
     *
     * @return string|null
     */
    public function getTip(): ?string
    {
        return $this->tip;
    }

    /**
     * 赋值 tip - 提示说明.
     * @param string|null $tip tip
     * @return static
     */
    public function setTip($tip)
    {
        $this->tip = null === $tip ? null : (string)$tip;
        return $this;
    }

    /**
     * 配置类型.
     * type
     * @Column(name="type", type="varchar", length=255, accuracy=0, nullable=true, default="string", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $type = 'string';

    /**
     * 获取 type - 配置类型.
     *
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * 赋值 type - 配置类型.
     * @param string|null $type type
     * @return static
     */
    public function setType($type)
    {
        $this->type = null === $type ? null : (string)$type;
        return $this;
    }

    /**
     * 配置值.
     * value
     * @Column(name="value", type="varchar", length=255, accuracy=0, nullable=true, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $value = '';

    /**
     * 获取 value - 配置值.
     *
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * 赋值 value - 配置值.
     * @param string|null $value value
     * @return static
     */
    public function setValue($value)
    {
        $this->value = null === $value ? null : (string)$value;
        return $this;
    }

    /**
     * 配置变量.
     * variable
     * @Column(name="variable", type="varchar", length=255, accuracy=0, nullable=true, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $variable = '';

    /**
     * 获取 variable - 配置变量.
     *
     * @return string|null
     */
    public function getVariable(): ?string
    {
        return $this->variable;
    }

    /**
     * 赋值 variable - 配置变量.
     * @param string|null $variable variable
     * @return static
     */
    public function setVariable($variable)
    {
        $this->variable = null === $variable ? null : (string)$variable;
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
