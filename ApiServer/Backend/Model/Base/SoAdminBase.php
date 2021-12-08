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
 * 管理员列表 基类.
 *
 * @Entity(camel=true, bean=true)
 * @Table(name=@ConfigValue(name="@app.models.ImiApp\ApiServer\Backend\Model\SoAdmin.name", default="so_admin"), id={"id"}, dbPoolName=@ConfigValue(name="@app.models.ImiApp\ApiServer\Backend\Model\SoAdmin.poolName"))
 * @DDL(sql="CREATE TABLE `so_admin` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `username` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名',
  `password` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码',
  `salt` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码盐',
  `email` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '' COMMENT '邮箱',
  `mobile` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '' COMMENT '手机号码',
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '' COMMENT '头像',
  `failures` int unsigned DEFAULT '0' COMMENT '失败次数',
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '' COMMENT 'TOKEN',
  `home_rule` int unsigned DEFAULT '0' COMMENT '默认菜单',
  `create_time` int unsigned NOT NULL COMMENT '创建时间',
  `update_time` int unsigned DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='管理员列表'", decode="")
 *
 * @property int|null $id 
 * @property int|null $status 状态
 * @property string|null $username 用户名
 * @property string|null $password 密码
 * @property string|null $salt 密码盐
 * @property string|null $email 邮箱
 * @property string|null $mobile 手机号码
 * @property string|null $avatar 头像
 * @property int|null $failures 失败次数
 * @property string|null $token TOKEN
 * @property int|null $homeRule 默认菜单
 * @property int|null $createTime 创建时间
 * @property int|null $updateTime 更新时间
 */
abstract class SoAdminBase extends Model
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
     * 用户名.
     * username
     * @Column(name="username", type="varchar", length=32, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $username = NULL;

    /**
     * 获取 username - 用户名.
     *
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * 赋值 username - 用户名.
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
     * 密码盐.
     * salt
     * @Column(name="salt", type="varchar", length=10, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $salt = NULL;

    /**
     * 获取 salt - 密码盐.
     *
     * @return string|null
     */
    public function getSalt(): ?string
    {
        return $this->salt;
    }

    /**
     * 赋值 salt - 密码盐.
     * @param string|null $salt salt
     * @return static
     */
    public function setSalt($salt)
    {
        $this->salt = null === $salt ? null : (string)$salt;
        return $this;
    }

    /**
     * 邮箱.
     * email
     * @Column(name="email", type="varchar", length=32, accuracy=0, nullable=true, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $email = '';

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
    protected ?string $mobile = '';

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
     * 头像.
     * avatar
     * @Column(name="avatar", type="varchar", length=255, accuracy=0, nullable=true, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $avatar = '';

    /**
     * 获取 avatar - 头像.
     *
     * @return string|null
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * 赋值 avatar - 头像.
     * @param string|null $avatar avatar
     * @return static
     */
    public function setAvatar($avatar)
    {
        $this->avatar = null === $avatar ? null : (string)$avatar;
        return $this;
    }

    /**
     * 失败次数.
     * failures
     * @Column(name="failures", type="int unsigned", length=0, accuracy=0, nullable=true, default="0", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var int|null
     */
    protected ?int $failures = NULL;

    /**
     * 获取 failures - 失败次数.
     *
     * @return int|null
     */
    public function getFailures(): ?int
    {
        return $this->failures;
    }

    /**
     * 赋值 failures - 失败次数.
     * @param int|null $failures failures
     * @return static
     */
    public function setFailures($failures)
    {
        $this->failures = null === $failures ? null : (int)$failures;
        return $this;
    }

    /**
     * TOKEN.
     * token
     * @Column(name="token", type="varchar", length=255, accuracy=0, nullable=true, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $token = '';

    /**
     * 获取 token - TOKEN.
     *
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * 赋值 token - TOKEN.
     * @param string|null $token token
     * @return static
     */
    public function setToken($token)
    {
        $this->token = null === $token ? null : (string)$token;
        return $this;
    }

    /**
     * 默认菜单.
     * home_rule
     * @Column(name="home_rule", type="int unsigned", length=0, accuracy=0, nullable=true, default="0", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var int|null
     */
    protected ?int $homeRule = NULL;

    /**
     * 获取 homeRule - 默认菜单.
     *
     * @return int|null
     */
    public function getHomeRule(): ?int
    {
        return $this->homeRule;
    }

    /**
     * 赋值 homeRule - 默认菜单.
     * @param int|null $homeRule home_rule
     * @return static
     */
    public function setHomeRule($homeRule)
    {
        $this->homeRule = null === $homeRule ? null : (int)$homeRule;
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
