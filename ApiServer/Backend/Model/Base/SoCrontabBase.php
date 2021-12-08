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
 * 监控任务 基类.
 *
 * @Entity(camel=true, bean=true)
 * @Table(name=@ConfigValue(name="@app.models.ImiApp\ApiServer\Backend\Model\SoCrontab.name", default="so_crontab"), id={"id"}, dbPoolName=@ConfigValue(name="@app.models.ImiApp\ApiServer\Backend\Model\SoCrontab.poolName"))
 * @DDL(sql="CREATE TABLE `so_crontab` (
  `id` int NOT NULL,
  `type` enum('command','curl','class') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '类型',
  `rule` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '规则',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '内容',
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '参数',
  `status` tinyint unsigned DEFAULT '1' COMMENT '状态',
  `create_time` int unsigned NOT NULL COMMENT '创建时间',
  `update_time` int unsigned DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='监控任务'", decode="")
 *
 * @property int|null $id 
 * @property string|null $type 类型
 * @property string|null $rule 规则
 * @property string|null $content 内容
 * @property string|null $params 参数
 * @property int|null $status 状态
 * @property int|null $createTime 创建时间
 * @property int|null $updateTime 更新时间
 */
abstract class SoCrontabBase extends Model
{
    /**
     * id.
     * @Column(name="id", type="int", length=0, accuracy=0, nullable=false, default="", isPrimaryKey=true, primaryKeyIndex=0, isAutoIncrement=false)
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
     * 类型.
     * type
     * @Column(name="type", type="enum", length=0, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $type = NULL;

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
     * 规则.
     * rule
     * @Column(name="rule", type="varchar", length=255, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $rule = NULL;

    /**
     * 获取 rule - 规则.
     *
     * @return string|null
     */
    public function getRule(): ?string
    {
        return $this->rule;
    }

    /**
     * 赋值 rule - 规则.
     * @param string|null $rule rule
     * @return static
     */
    public function setRule($rule)
    {
        $this->rule = null === $rule ? null : (string)$rule;
        return $this;
    }

    /**
     * 内容.
     * content
     * @Column(name="content", type="text", length=0, accuracy=0, nullable=true, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $content = NULL;

    /**
     * 获取 content - 内容.
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * 赋值 content - 内容.
     * @param string|null $content content
     * @return static
     */
    public function setContent($content)
    {
        $this->content = null === $content ? null : (string)$content;
        return $this;
    }

    /**
     * 参数.
     * params
     * @Column(name="params", type="text", length=0, accuracy=0, nullable=true, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $params = NULL;

    /**
     * 获取 params - 参数.
     *
     * @return string|null
     */
    public function getParams(): ?string
    {
        return $this->params;
    }

    /**
     * 赋值 params - 参数.
     * @param string|null $params params
     * @return static
     */
    public function setParams($params)
    {
        $this->params = null === $params ? null : (string)$params;
        return $this;
    }

    /**
     * 状态.
     * status
     * @Column(name="status", type="tinyint unsigned", length=0, accuracy=0, nullable=true, default="1", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
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
