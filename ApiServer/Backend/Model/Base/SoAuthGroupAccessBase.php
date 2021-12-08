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
 * 权限关联 基类.
 *
 * @Entity(camel=true, bean=true)
 * @Table(name=@ConfigValue(name="@app.models.ImiApp\ApiServer\Backend\Model\SoAuthGroupAccess.name", default="so_auth_group_access"), dbPoolName=@ConfigValue(name="@app.models.ImiApp\ApiServer\Backend\Model\SoAuthGroupAccess.poolName"))
 * @DDL(sql="CREATE TABLE `so_auth_group_access` (
  `uid` int unsigned NOT NULL AUTO_INCREMENT COMMENT '用户',
  `gid` int NOT NULL COMMENT '组们',
  KEY `uid` (`uid`),
  KEY `gid` (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='权限关联'", decode="")
 *
 * @property int|null $uid 用户
 * @property int|null $gid 组们
 */
abstract class SoAuthGroupAccessBase extends Model
{
    /**
     * 用户.
     * uid
     * @Column(name="uid", type="int unsigned", length=0, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=true)
     * @var int|null
     */
    protected ?int $uid = NULL;

    /**
     * 获取 uid - 用户.
     *
     * @return int|null
     */
    public function getUid(): ?int
    {
        return $this->uid;
    }

    /**
     * 赋值 uid - 用户.
     * @param int|null $uid uid
     * @return static
     */
    public function setUid($uid)
    {
        $this->uid = null === $uid ? null : (int)$uid;
        return $this;
    }

    /**
     * 组们.
     * gid
     * @Column(name="gid", type="int", length=0, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var int|null
     */
    protected ?int $gid = NULL;

    /**
     * 获取 gid - 组们.
     *
     * @return int|null
     */
    public function getGid(): ?int
    {
        return $this->gid;
    }

    /**
     * 赋值 gid - 组们.
     * @param int|null $gid gid
     * @return static
     */
    public function setGid($gid)
    {
        $this->gid = null === $gid ? null : (int)$gid;
        return $this;
    }

}
