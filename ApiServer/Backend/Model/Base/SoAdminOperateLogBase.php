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
 * 管理员操作日志 基类.
 *
 * @Entity(camel=false, bean=true)
 * @Table(name=@ConfigValue(name="@app.models.ImiApp\ApiServer\Backend\Model\SoAdminOperateLog.name", default="so_admin_operate_log"), id={"id"}, dbPoolName=@ConfigValue(name="@app.models.ImiApp\ApiServer\Backend\Model\SoAdminOperateLog.poolName"))
 * @DDL(sql="CREATE TABLE `so_admin_operate_log` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int unsigned NOT NULL COMMENT '管理员ID',
  `username` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '管理员账号',
  `route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '路由地址',
  `route_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '路由名称',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '请求内容',
  `ip` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'IP地址',
  `user_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'User-Agent',
  `create_time` int unsigned NOT NULL COMMENT '请求时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='管理员操作日志'", decode="")
 *
 * @property int|null $id 
 * @property int|null $adminId 管理员ID
 * @property string|null $username 管理员账号
 * @property string|null $route 路由地址
 * @property string|null $routeName 路由名称
 * @property string|null $content 请求内容
 * @property string|null $ip IP地址
 * @property string|null $userAgent User-Agent
 * @property int|null $createTime 请求时间
 */
abstract class SoAdminOperateLogBase extends Model
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
     * 管理员ID.
     * admin_id
     * @Column(name="admin_id", type="int unsigned", length=0, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var int|null
     */
    protected ?int $adminId = NULL;

    /**
     * 获取 adminId - 管理员ID.
     *
     * @return int|null
     */
    public function getAdminId(): ?int
    {
        return $this->adminId;
    }

    /**
     * 赋值 adminId - 管理员ID.
     * @param int|null $adminId admin_id
     * @return static
     */
    public function setAdminId($adminId)
    {
        $this->adminId = null === $adminId ? null : (int)$adminId;
        return $this;
    }

    /**
     * 管理员账号.
     * username
     * @Column(name="username", type="varchar", length=32, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $username = NULL;

    /**
     * 获取 username - 管理员账号.
     *
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * 赋值 username - 管理员账号.
     * @param string|null $username username
     * @return static
     */
    public function setUsername($username)
    {
        $this->username = null === $username ? null : (string)$username;
        return $this;
    }

    /**
     * 路由地址.
     * route
     * @Column(name="route", type="varchar", length=255, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $route = NULL;

    /**
     * 获取 route - 路由地址.
     *
     * @return string|null
     */
    public function getRoute(): ?string
    {
        return $this->route;
    }

    /**
     * 赋值 route - 路由地址.
     * @param string|null $route route
     * @return static
     */
    public function setRoute($route)
    {
        $this->route = null === $route ? null : (string)$route;
        return $this;
    }

    /**
     * 路由名称.
     * route_name
     * @Column(name="route_name", type="varchar", length=255, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $routeName = '';

    /**
     * 获取 routeName - 路由名称.
     *
     * @return string|null
     */
    public function getRouteName(): ?string
    {
        return $this->routeName;
    }

    /**
     * 赋值 routeName - 路由名称.
     * @param string|null $routeName route_name
     * @return static
     */
    public function setRouteName($routeName)
    {
        $this->routeName = null === $routeName ? null : (string)$routeName;
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
     * User-Agent.
     * user_agent
     * @Column(name="user_agent", type="varchar", length=255, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $userAgent = NULL;

    /**
     * 获取 userAgent - User-Agent.
     *
     * @return string|null
     */
    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    /**
     * 赋值 userAgent - User-Agent.
     * @param string|null $userAgent user_agent
     * @return static
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = null === $userAgent ? null : (string)$userAgent;
        return $this;
    }

    /**
     * 请求时间.
     * create_time
     * @Column(name="create_time", type="int unsigned", length=0, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var int|null
     */
    protected ?int $createTime = NULL;

    /**
     * 获取 createTime - 请求时间.
     *
     * @return int|null
     */
    public function getCreateTime(): ?int
    {
        return $this->createTime;
    }

    /**
     * 赋值 createTime - 请求时间.
     * @param int|null $createTime create_time
     * @return static
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = null === $createTime ? null : (int)$createTime;
        return $this;
    }

}
