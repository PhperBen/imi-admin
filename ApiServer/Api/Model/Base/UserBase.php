<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Api\Model\Base;

use Imi\Config\Annotation\ConfigValue;
use Imi\Model\Annotation\Column;
use Imi\Model\Annotation\DDL;
use Imi\Model\Annotation\Entity;
use Imi\Model\Annotation\Table;
use ImiApp\ImiServer\AbstractModel as Model;

/**
 * 用户表 基类.
 *
 * @Entity(camel=false, bean=true)
 * @Table(name=@ConfigValue(name="@app.models.ImiApp\ApiServer\Api\Model\User.name", default="user"), id={"id"}, dbPoolName=@ConfigValue(name="@app.models.ImiApp\ApiServer\Api\Model\User.poolName"))
 * @DDL(sql="CREATE TABLE `user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `username` varchar(32) COLLATE utf8mb4_general_ci NOT NULL COMMENT '账号',
  `password` varchar(32) COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码',
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '邮箱',
  `mobile` varchar(11) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '手机号码',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `create_time` int NOT NULL COMMENT '创建时间',
  `update_time` int NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='用户表'", decode="")
 *
 * @property int|null $id 
 * @property int|null $status 状态
 * @property string|null $username 账号
 * @property string|null $password 密码
 * @property string|null $email 邮箱
 * @property string|null $mobile 手机号码
 * @property string|float|int|null $money 余额
 * @property int|null $createTime 创建时间
 * @property int|null $updateTime 更新时间
 */
abstract class UserBase extends Model
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
     * 状态.
     * status
     * @Column(name="status", type="tinyint", length=1, accuracy=0, nullable=false, default="1", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var int|null
     */
    protected ?int $status = 1;

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
     * 账号.
     * username
     * @Column(name="username", type="varchar", length=32, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $username = NULL;

    /**
     * 获取 username - 账号.
     *
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * 赋值 username - 账号.
     * @param string|null $username username
     * @return static
     */
    public function setUsername($username)
    {
        $this->username = null === $username ? null : (string)$username;
        return $this;
    }

    /**
     * 密码.
     * password
     * @Column(name="password", type="varchar", length=32, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $password = NULL;

    /**
     * 获取 password - 密码.
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * 赋值 password - 密码.
     * @param string|null $password password
     * @return static
     */
    public function setPassword($password)
    {
        $this->password = null === $password ? null : (string)$password;
        return $this;
    }

    /**
     * 邮箱.
     * email
     * @Column(name="email", type="varchar", length=255, accuracy=0, nullable=true, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $email = NULL;

    /**
     * 获取 email - 邮箱.
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * 赋值 email - 邮箱.
     * @param string|null $email email
     * @return static
     */
    public function setEmail($email)
    {
        $this->email = null === $email ? null : (string)$email;
        return $this;
    }

    /**
     * 手机号码.
     * mobile
     * @Column(name="mobile", type="varchar", length=11, accuracy=0, nullable=true, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $mobile = NULL;

    /**
     * 获取 mobile - 手机号码.
     *
     * @return string|null
     */
    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    /**
     * 赋值 mobile - 手机号码.
     * @param string|null $mobile mobile
     * @return static
     */
    public function setMobile($mobile)
    {
        $this->mobile = null === $mobile ? null : (string)$mobile;
        return $this;
    }

    /**
     * 余额.
     * money
     * @Column(name="money", type="decimal", length=10, accuracy=2, nullable=false, default="0.00", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|float|int|null
     */
    protected string|float|int|null $money = NULL;

    /**
     * 获取 money - 余额.
     *
     * @return string|float|int|null
     */
    public function getMoney(): string|float|int|null
    {
        return $this->money;
    }

    /**
     * 赋值 money - 余额.
     * @param string|float|int|null $money money
     * @return static
     */
    public function setMoney($money)
    {
        $this->money = null === $money ? null : $money;
        return $this;
    }

    /**
     * 创建时间.
     * create_time
     * @Column(name="create_time", type="int", length=0, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
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
     * @Column(name="update_time", type="int", length=0, accuracy=0, nullable=false, default="0", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var int|null
     */
    protected ?int $updateTime = 0;

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
