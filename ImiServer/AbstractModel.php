<?php

declare(strict_types=1);

namespace ImiApp\ImiServer;

use Imi\Bean\Annotation\AnnotationManager;
use Imi\Bean\BeanFactory;
use Imi\Model\Annotation\Relation\RelationBase;
use Imi\Model\Model;
use Imi\Bean\Annotation\Inherit;
use Imi\Model\ModelRelationManager;
use Imi\Model\Relation\Query;
use Imi\Model\Relation\Struct\OneToMany;
use Imi\Model\Relation\Struct\OneToOne;
use Imi\Util\Imi;

/**
 * @Inherit
 */
abstract class AbstractModel extends Model
{
    use \ImiApp\ImiServer\Traits\Model;

    /**
     * 查找所有孩子主键
     * @param mixed $data
     * @param string $parent_pk
     * @param string|null $pk
     * @param array $array
     * @return mixed
     */
    public static function getChildPk(mixed $data, string $parent_pk = 'pid', ?string $pk = null, array $array = []): mixed
    {
        !$pk && $pk = static::__getMeta()->getFirstId();
        !is_array($data) && $data = [$data];
        foreach ($data as $v) {
            $child = self::query()->where($parent_pk, '=', $v)->field($pk)->select()->getColumn();
            if ($child) $array = array_merge($array, self::getChildPk($child, $parent_pk, $pk, $child));
        }
        return $array;
    }

    /**
     * 取主键
     * @return string|null
     */
    public static function getPk(): ?string
    {
        return static::__getMeta()->getFirstId();
    }

    /**
     * 取表名
     * @return string|null
     */
    public static function getTable(): ?string
    {
        return static::__getMeta()->getTableName();
    }

    /**
     * 取关联模型查询join条件
     * 暂时只支持一对一，一对多
     * @return array
     */
    public static function getJoin(): array
    {
        $join = [];
        $className = static::class;
        $row = AnnotationManager::getPropertiesAnnotations($className, RelationBase::class);
        $model = new static;
        foreach ($row as $propertyName => $annotations) {
            foreach ($annotations as $annotation) {
                if (class_exists($annotation->model)) {
                    $modelClass = $annotation->model;
                } else {
                    $modelClass = Imi::getClassNamespace($className) . '\\' . $annotation->model;
                }
                $table = $modelClass::getTable();
                $rowTable = static::getTable();
                if ($annotation instanceof \Imi\Model\Annotation\Relation\OneToOne) {
                    $struct = new OneToOne($className, $propertyName, $annotation);
                    $leftField = $struct->getLeftField();
                    $rightField = $struct->getRightField();
                } elseif ($annotation instanceof \Imi\Model\Annotation\Relation\OneToMany) {
                    $struct = new OneToMany($className, $propertyName, $annotation);
                    $leftField = $struct->getLeftField();
                    $rightField = $struct->getRightField();
                } else {
                    continue;
                }
                $join[$propertyName] = [
                    'joinTable' => $table,
                    'table' => $rowTable,
                    'leftField' => $leftField,
                    'rightField' => $rightField,
                ];
            }
        }
        return $join;
    }

    /**
     * 获取字段
     * @return array
     */
    public static function getColumnNames(): array
    {
        $fields = static::__getMeta()->getDbFields();
        $columns = [];
        foreach ($fields as $k => $item) {
            $columns[] = $k;
        }
        return $columns;
    }

    /**
     * 获取getDbFields
     * @return array
     */
    public static function getColumns(): array
    {
        return static::__getMeta()->getDbFields();
    }

    /**
     * 默认模糊搜索字段
     * @return array
     */
    public static function getSearchColumns(): array
    {
        return ['id', 'username', 'name', 'title'];
    }

    /**
     * 默认时间戳字段
     * @return array
     */
    public static function getTimestampsColumns(): array
    {
        return [
            'create_time',
            'update_time'
        ];
    }

    /**
     * 拖拽排序规则
     * @return string
     */
    public static function getSortBy(): string
    {
        return 'desc';
    }

    /**
     * 拖拽排序字段
     * 设为主键字段名等于关闭自动设置排序
     * @return string
     */
    public static function getSortPk(): string
    {
        return 'id';
    }

    /**
     * 支持的写法：
     * 1. id desc, age asc
     * 2. ['id'=>'desc', 'age'] // 缺省asc.
     * @return mixed
     */
    public static function getOrderRaw(): mixed
    {
        return 'id desc';
    }

    /**
     * 关联模型字段
     * @return array
     */
    public static function getWithAttribute(): array
    {
        return [];
    }

    /**
     * 获取可操作字段
     * @return array
     */
    public static function getOperates(): array
    {
        return ['status'];
    }

    /**
     * 查询分隔符
     * @return string
     */
    public static function getSearchBreak(): string
    {
        return '|||||';
    }

    /**
     * 上级字段
     * @return string
     */
    public static function getParentPk(): string
    {
        return 'pid';
    }
}