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
 * 附件列表 基类.
 *
 * @Entity(camel=false, bean=true)
 * @Table(name=@ConfigValue(name="@app.models.ImiApp\ApiServer\Backend\Model\SoAttachment.name", default="so_attachment"), id={"id"}, dbPoolName=@ConfigValue(name="@app.models.ImiApp\ApiServer\Backend\Model\SoAttachment.poolName"))
 * @DDL(sql="CREATE TABLE `so_attachment` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'local' COMMENT '存储类型',
  `admin_id` int unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  `user_id` int unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '存储路径',
  `parent` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '父级',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '在线地址',
  `filename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '文件名称',
  `size` int unsigned NOT NULL COMMENT '文件大小',
  `mediatype` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '文件类型',
  `extension` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '文件后缀',
  `create_time` int unsigned NOT NULL COMMENT '创建时间',
  `update_time` int unsigned DEFAULT '0' COMMENT '更新时间',
  `delete_time` int unsigned DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `filename` (`filename`),
  KEY `url` (`url`),
  KEY `path` (`path`),
  KEY `admin_id` (`admin_id`),
  KEY `user_id` (`user_id`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='附件列表'", decode="")
 *
 * @property int|null $id 
 * @property string|null $type 存储类型
 * @property int|null $adminId 管理员ID
 * @property int|null $userId 用户ID
 * @property string|null $path 存储路径
 * @property string|null $parent 父级
 * @property string|null $url 在线地址
 * @property string|null $filename 文件名称
 * @property int|null $size 文件大小
 * @property string|null $mediatype 文件类型
 * @property string|null $extension 文件后缀
 * @property int|null $createTime 创建时间
 * @property int|null $updateTime 更新时间
 * @property int|null $deleteTime 删除时间
 */
abstract class SoAttachmentBase extends Model
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
     * 存储类型.
     * type
     * @Column(name="type", type="varchar", length=255, accuracy=0, nullable=false, default="local", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $type = 'local';

    /**
     * 获取 type - 存储类型.
     *
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * 赋值 type - 存储类型.
     * @param string|null $type type
     * @return static
     */
    public function setType($type)
    {
        $this->type = null === $type ? null : (string)$type;
        return $this;
    }

    /**
     * 管理员ID.
     * admin_id
     * @Column(name="admin_id", type="int unsigned", length=0, accuracy=0, nullable=false, default="0", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
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
     * 用户ID.
     * user_id
     * @Column(name="user_id", type="int unsigned", length=0, accuracy=0, nullable=false, default="0", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var int|null
     */
    protected ?int $userId = NULL;

    /**
     * 获取 userId - 用户ID.
     *
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * 赋值 userId - 用户ID.
     * @param int|null $userId user_id
     * @return static
     */
    public function setUserId($userId)
    {
        $this->userId = null === $userId ? null : (int)$userId;
        return $this;
    }

    /**
     * 存储路径.
     * path
     * @Column(name="path", type="varchar", length=255, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $path = NULL;

    /**
     * 获取 path - 存储路径.
     *
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * 赋值 path - 存储路径.
     * @param string|null $path path
     * @return static
     */
    public function setPath($path)
    {
        $this->path = null === $path ? null : (string)$path;
        return $this;
    }

    /**
     * 父级.
     * parent
     * @Column(name="parent", type="varchar", length=255, accuracy=0, nullable=true, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $parent = NULL;

    /**
     * 获取 parent - 父级.
     *
     * @return string|null
     */
    public function getParent(): ?string
    {
        return $this->parent;
    }

    /**
     * 赋值 parent - 父级.
     * @param string|null $parent parent
     * @return static
     */
    public function setParent($parent)
    {
        $this->parent = null === $parent ? null : (string)$parent;
        return $this;
    }

    /**
     * 在线地址.
     * url
     * @Column(name="url", type="varchar", length=255, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $url = NULL;

    /**
     * 获取 url - 在线地址.
     *
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * 赋值 url - 在线地址.
     * @param string|null $url url
     * @return static
     */
    public function setUrl($url)
    {
        $this->url = null === $url ? null : (string)$url;
        return $this;
    }

    /**
     * 文件名称.
     * filename
     * @Column(name="filename", type="varchar", length=255, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $filename = NULL;

    /**
     * 获取 filename - 文件名称.
     *
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * 赋值 filename - 文件名称.
     * @param string|null $filename filename
     * @return static
     */
    public function setFilename($filename)
    {
        $this->filename = null === $filename ? null : (string)$filename;
        return $this;
    }

    /**
     * 文件大小.
     * size
     * @Column(name="size", type="int unsigned", length=0, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var int|null
     */
    protected ?int $size = NULL;

    /**
     * 获取 size - 文件大小.
     *
     * @return int|null
     */
    public function getSize(): ?int
    {
        return $this->size;
    }

    /**
     * 赋值 size - 文件大小.
     * @param int|null $size size
     * @return static
     */
    public function setSize($size)
    {
        $this->size = null === $size ? null : (int)$size;
        return $this;
    }

    /**
     * 文件类型.
     * mediatype
     * @Column(name="mediatype", type="varchar", length=255, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $mediatype = NULL;

    /**
     * 获取 mediatype - 文件类型.
     *
     * @return string|null
     */
    public function getMediatype(): ?string
    {
        return $this->mediatype;
    }

    /**
     * 赋值 mediatype - 文件类型.
     * @param string|null $mediatype mediatype
     * @return static
     */
    public function setMediatype($mediatype)
    {
        $this->mediatype = null === $mediatype ? null : (string)$mediatype;
        return $this;
    }

    /**
     * 文件后缀.
     * extension
     * @Column(name="extension", type="varchar", length=255, accuracy=0, nullable=false, default="", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var string|null
     */
    protected ?string $extension = NULL;

    /**
     * 获取 extension - 文件后缀.
     *
     * @return string|null
     */
    public function getExtension(): ?string
    {
        return $this->extension;
    }

    /**
     * 赋值 extension - 文件后缀.
     * @param string|null $extension extension
     * @return static
     */
    public function setExtension($extension)
    {
        $this->extension = null === $extension ? null : (string)$extension;
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

    /**
     * 删除时间.
     * delete_time
     * @Column(name="delete_time", type="int unsigned", length=0, accuracy=0, nullable=true, default="0", isPrimaryKey=false, primaryKeyIndex=-1, isAutoIncrement=false)
     * @var int|null
     */
    protected ?int $deleteTime = NULL;

    /**
     * 获取 deleteTime - 删除时间.
     *
     * @return int|null
     */
    public function getDeleteTime(): ?int
    {
        return $this->deleteTime;
    }

    /**
     * 赋值 deleteTime - 删除时间.
     * @param int|null $deleteTime delete_time
     * @return static
     */
    public function setDeleteTime($deleteTime)
    {
        $this->deleteTime = null === $deleteTime ? null : (int)$deleteTime;
        return $this;
    }

}
