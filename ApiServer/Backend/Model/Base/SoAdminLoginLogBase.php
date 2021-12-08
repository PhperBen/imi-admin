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
 * 管理员登陆日志 基类.
 *
 * @Entity(camel=true, bean=true)
 * @Table(name=@ConfigValue(name="@app.models.ImiApp\ApiServer\Backend\Model\SoAdminLoginLog.name", default="so_admin_login_log"), id={"id"}, dbPoolName=@ConfigValue(name="@app.models.ImiApp\ApiServer\Backend\Model\SoAdminLoginLog.poolName"))
 * @DDL(sql="CREATE TABLE `so_admin_login_log` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '账号',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '密码',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '请求内容',
  `ip` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'IP地址',
  `status` tinyint unsigned NOT NULL COMMENT '登陆状态',
  `create_time` int unsigned NOT NULL COMMENT '登陆时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='管理员登陆日志'", decode="")
 *
 * @property int|null $id 
 * @property string|null $username 账号
 * @property string|null $password 密码
 * @property string|null $content 请求内容
 * @property string|null $ip IP地址
 * @property int|null $status 登陆状态
 * @property int|null $createTime 登陆时间
 */
abstract class SoAdminLoginLogBase extends Model
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
     * 账号.
     * username
     * @Column(name="username", type="varchar", length=255, accuracy=0, nullable=true, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
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
     * @Column(name="password", type="varchar", length=255, accuracy=0, nullable=true, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
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
     * 请求内容.
     * content
     * @Column(name="content", type="text", length=0, accuracy=0, nullable=true, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $content = NULL;

    /**
     * 获取 content - 请求内容.
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * 赋值 content - 请求内容.
     * @param string|null $content content
     * @return static
     */
    public function setContent($content)
    {
        $this->content = null === $content ? null : (string)$content;
        return $this;
    }

    /**
     * IP地址.
     * ip
     * @Column(name="ip", type="varchar", length=15, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $ip = NULL;

    /**
     * 获取 ip - IP地址.
     *
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * 赋值 ip - IP地址.
     * @param string|null $ip ip
     * @return static
     */
    public function setIp($ip)
    {
        $this->ip = null === $ip ? null : (string)$ip;
        return $this;
    }

    /**
     * 登陆状态.
     * status
     * @Column(name="status", type="tinyint unsigned", length=0, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var int|null
     */
    protected ?int $status = NULL;

    /**
     * 获取 status - 登陆状态.
     *
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * 赋值 status - 登陆状态.
     * @param int|null $status status
     * @return static
     */
    public function setStatus($status)
    {
        $this->status = null === $status ? null : (int)$status;
        return $this;
    }

    /**
     * 登陆时间.
     * create_time
     * @Column(name="create_time", type="int unsigned", length=0, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var int|null
     */
    protected ?int $createTime = NULL;

    /**
     * 获取 createTime - 登陆时间.
     *
     * @return int|null
     */
    public function getCreateTime(): ?int
    {
        return $this->createTime;
    }

    /**
     * 赋值 createTime - 登陆时间.
     * @param int|null $createTime create_time
     * @return static
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = null === $createTime ? null : (int)$createTime;
        return $this;
    }

}
