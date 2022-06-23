<?php

declare(strict_types=1);

namespace ImiApp\ImiServer\Traits;

use Imi\Log\Log;
use Imi\Model\Annotation\Relation\RelationBase;
use Imi\Model\Contract\IModelQuery;
use ImiApp\ImiServer\Exception\ServiceException;
use Imi\Db\Db;
use Exception;

trait Service
{
    public $model;

    /**
     * 读取
     * @param bool $isPage
     * @return mixed
     */
    public function read(bool $isPage = true)
    {
        try {
            $pageSize = (int)$this->request->request('pageSize', 20);
            $page = (int)$this->request->request('page', 1);
            $order = method_exists($this->model, 'getOrderRaw') ? $this->model::getOrderRaw() : $this->model::getPk() . ' desc';
            $query = $this->where();
            if (method_exists($this, '_before_read')) {
                $this->_before_read($query);
            }
            $data = $isPage ? $query->orderRaw($order)->paginate($page, $pageSize) : $query->orderRaw($order)->select();
            $data = [
                'list' => $isPage ? $data->getList() : $data->getArray(), // 列表数据
                'total' => $isPage ? $data->getTotal() : $data->getRowCount(), // 总记录数
                'pageSize' => $isPage ? $data->getLimit() : $data->getRowCount(), // 数量
                'currentPage' => $isPage ? $data->getPageCount() : 1 // 总页数
            ];
            if (method_exists($this, '_after_read')) {
                $this->_after_read($data);
            }
        } catch (ServiceException $e) {
            $this->setError($e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error($e);
            return false;
        }
        return $data;
    }

    /**
     * 拖拽排序
     * @param $data
     * @return bool
     * @throws \Imi\Db\Exception\DbException
     */
    public function draggable($data): bool
    {
        $ids = $data['ids'];
        $changeid = $data['changeid'];
        $pid = $data['pid'] ?? 0;
        $changepid = $data['changepid'] ?? 0;
        Db::getInstance()->beginTransaction();
        try {
            $pidKey = $this->model::getParentPk();
            $pk = $prikey = $this->model::getPk();
            $orderway = $this->model::getSortBy();
            $sour = $weighdata = [];
            is_string($ids) && $ids = array_filter(explode(',', $ids));
            $field = $this->model::getSortPk();
            if ($pid) {
                $hasids = [];
                $list = $this->model::query()->whereIn($prikey, $ids)->where($pidKey, '=', $pid)->field($prikey, $pidKey)->select()->getArray();
                foreach ($list as $k => $v) {
                    $hasids[] = $v[$prikey];
                }
                $ids = array_values(array_intersect($ids, $hasids));
            }
            $list = $this->model::query()->field($prikey, $field)->whereIn($prikey, $ids)->order($field, $orderway)->select()->getArray();
            foreach ($list as $k => $v) {
                $sour[] = $v[$prikey];
                $weighdata[$v[$prikey]] = $v[$field];
            }
            $position = array_search($changeid, $ids);
            $desc_id = $sour[$position] ?? end($sour);
            $sour_id = $changeid;
            $temp = array_values(array_diff_assoc($ids, $sour));
            foreach ($temp as $m => $n) {
                if ($n == $sour_id) {
                    $offset = $desc_id;
                } else {
                    if ($sour_id == $temp[0]) {
                        $offset = $temp[$m + 1] ?? $sour_id;
                    } else {
                        $offset = $temp[$m - 1] ?? $sour_id;
                    }
                }
                if (!isset($weighdata[$offset])) {
                    continue;
                }
                $this->model::query()->where($prikey, '=', $n)->update([$field => $weighdata[$offset]]);
            }
            $changepid . '' > '0' && $this->model::query()->where($prikey, '=', $changeid)->update([$pidKey => $changepid]);
            Db::getInstance()->commit();
        } catch (ServiceException $e) {
            Db::getInstance()->rollBack();
            $this->setError($e->getMessage());
            return false;
        } catch (Exception $e) {
            Db::getInstance()->rollBack();
            Log::error($e);
            return false;
        }
        return true;
    }

    /**
     * 创建
     * @param $data
     * @return mixed
     * @throws \Imi\Db\Exception\DbException
     */
    public function create($data)
    {
        Db::getInstance()->beginTransaction();
        try {
            $pk = $this->model::getPk();
            if (method_exists($this, '_before_create')) {
                $this->_before_create($data);
            }
            $model = $this->model::newInstance();
            $create = $model->insert($data);
            if (!$create->isSuccess()) {
                throw new ServiceException('创建失败');
            }
            $method = 'get' . ucfirst(camelize($pk));
            $key = $model->{$method}() ?: false;
            if (method_exists($this, '_after_create')) {
                $this->_after_create($key, $create);
            }
            Db::getInstance()->commit();
        } catch (ServiceException $e) {
            Db::getInstance()->rollBack();
            $this->setError($e->getMessage());
            return false;
        } catch (Exception $e) {
            Db::getInstance()->rollBack();
            Log::error($e);
            return false;
        }
        return $key;
    }

    /**
     * 编辑
     * @param $data
     * @return mixed
     * @throws \Imi\Db\Exception\DbException
     */
    public function update($data)
    {
        Db::getInstance()->beginTransaction();
        try {
            $pk = $this->model::getPk();
            $pk_value = $data[$pk] ?? false;
            if (!$pk_value) {
                throw new ServiceException('未传入主键');
            }
            $res = $this->model::find($pk_value);
            if (!$res) {
                throw new ServiceException('数据不存在');
            }
            if (method_exists($this, '_before_update')) {
                $this->_before_update($data);
            }
            $key = $data[$pk];
            unset($data[$pk]);
            $res->update($data);
            if (method_exists($this, '_after_update')) {
                $this->_after_update($key, $res);
            }
            Db::getInstance()->commit();
        } catch (ServiceException $e) {
            Db::getInstance()->rollBack();
            $this->setError($e->getMessage());
            return false;
        } catch (Exception $e) {
            Db::getInstance()->rollBack();
            Log::error($e);
            return false;
        }
        return true;
    }

    /**
     * 删除
     * @param mixed|null $ids
     * @return mixed
     * @throws \Imi\Db\Exception\DbException
     */
    public function delete($ids = null)
    {
        $ids = $ids ?? ($this->request->getParsedBody()['ids'] ?? []);
        if (!$ids) {
            $this->setError('未传入ID');
            return false;
        }
        !is_array($ids) && $ids = explode(',', (string)$ids);
        $ids = array_filter($ids);
        if (!$ids) {
            $this->setError('未传入ID');
            return false;
        }
        $pk = $this->model::getPk();
        Db::getInstance()->beginTransaction();
        try {
            if (method_exists($this, '_before_delete')) {
                $this->_before_delete($ids);
            }
            $this->model::query()->whereIn($pk, $ids)->delete();
            if (method_exists($this, '_after_delete')) {
                $this->_after_delete($ids);
            }
            Db::getInstance()->commit();
        } catch (ServiceException $e) {
            Db::getInstance()->rollBack();
            $this->setError($e->getMessage());
            return false;
        } catch (Exception $e) {
            Db::getInstance()->rollBack();
            Log::error($e);
            return false;
        }
        return true;
    }

    /**
     * 获取where后查询器
     * @param string|null $filter
     * @param string|null $search
     * @return mixed
     */
    public function where(?string $filter = null, ?string $search = null)
    {
        $filter = $filter ?? json_decode((string)$this->request->request('filter', '{}'), true); // 高级搜索内容
        $search = $search ?? (string)$this->request->request('search', ''); // 模糊搜索内容
        $withFilter = []; // 关联模型查询数据
        $whereEx = []; // 当前表查询条件
        $whereBetween = []; // between条件
        $withArray = []; // 关联模型查询条件
        $operatorList = ['=', '!=', '>', '>=', '<', '<=', 'like', 'not like', 'between', 'not between'];
        $columns = $this->model::getColumnNames(); // 当前表字段
        $dbColumns = $this->model::getColumns();
        $timestampsColumns = $this->model::getTimestampsColumns(); // 时间戳字段
        $getValue = function ($column, $value) use ($timestampsColumns, $dbColumns) {
            if (in_array($column, $timestampsColumns)) {
                if (is_array($value)) {
                    foreach ($value as &$v) $v = strtotime($v);
                } else {
                    $value = strtotime((string)$value);
                }
            }
            if (is_array($value)) {
                foreach ($value as &$v) {
                    $dbType = $dbColumns[$column]['column']->type ?? "int";
                    $v = str_contains($dbType, 'int') ? intval($v) : (string)$v;
                }
            }
            return $value;
        };
        foreach ($filter as $k => $v) {
            $content = explode($this->model::getSearchBreak(), $v);
            // 格式错误
            if (count($content) !== 2) {
                continue;
            }
            // 处理
            $column = (string)$k;
            $value = (string)$content[0];
            $operator = (string)$content[1];
            if ($value == "" || $value == null) {
                continue;
            }
            if (!in_array($operator, $operatorList)) {
                continue;
            }
            if (in_array($operator, ['like', 'not like'])) {
                $value = '%' . $value . '%';
            }
            // 关联模型查询
            if (str_contains($column, '.')) {
                $column = explode('.', $column);
                if (isset($column[1])) {
                    !isset($withFilter[$column[0]]) && $withFilter[$column[0]] = [];
                    $withFilter[$column[0]][$column[1]] = [$operator, $value];
                }
                continue;
            }
            // 当前表查询
            if (in_array($column, $columns) && in_array($operator, ['between', 'not between'])) {
                $value = explode(',', $value);
                if (count($value) !== 2) {
                    continue;
                }
                $whereBetween[] = [
                    'column' => $column,
                    'operator' => $operator,
                    'value' => $value,
                ];
                continue;
            }
            in_array($column, $columns) && $whereEx[$column] = [$operator, $value];
        }
        // 关联模型条件
        if ($withAttribute = $this->model::getWithAttribute()) {
            foreach ($withFilter as $attr => $_where) {
                in_array($attr, $withAttribute) && $withArray[$attr] = function (IModelQuery $query, RelationBase $annotation) use ($_where) {
                    $query->whereEx($_where);
                };
            }

        }
        // 查询
        $query = $this->model::query();
        $whereEx && $query = $query->whereEx($whereEx);
        if ($whereBetween) {
            foreach ($whereBetween as $item) $query = $query->where($item['column'], $item['operator'], $getValue($item['column'], $item['value']));
        }
        $withArray && $query = $query->with($withArray);
        if (!$withArray && $withAttribute) {
            $query = $query->with($withAttribute);
        }
        // 模糊搜索
        if ($search) {
            $searchCloumn = method_exists($this->model, 'getSearchColumns') ? $this->model::getSearchColumns() : [];
            $orWhere = [];
            foreach ($searchCloumn as $k => $column) {
                if (!in_array($column, $columns)) {
                    continue;
                }
                if ($k == 0) {
                    $orWhere[$column] = ['like', '%' . $search . '%'];
                } else {
                    !isset($orWhere['or']) && $orWhere['or'] = [];
                    $orWhere['or'][$column] = ['like', '%' . $search . '%'];
                }
            }
            $orWhere && $query = $query->whereEx($orWhere);
        }
        // 关联模型join查询，因imi暂不支持where查询关联数据
        if ($withAttribute) {
            $joinData = $this->model::getJoin();
            foreach ($withFilter as $attr => $_where) {
                if (in_array($attr, $withAttribute) && isset($joinData[$attr])) {
                    $join = $joinData[$attr];
                    $query = $query->join($join['joinTable'], $join['table'] . '.' . $join['leftField'], '=', $join['joinTable'] . '.' . $join['rightField']);
                    foreach ($_where as $key => $item) {
                        $query = $query->where($join['joinTable'] . '.' . $key, $item[0], $item[1]);
                    }
                }
            }
        }
        return $query;
    }

    /**
     * 快捷操作
     * @return mixed
     */
    public function operate()
    {
        $ids = $ids ?? ($this->request->getParsedBody()['ids'] ?? []);
        if (!$ids) {
            $this->setError('未传入ID');
            return false;
        }
        !is_array($ids) && $ids = explode(',', (string)$ids);
        $ids = array_filter($ids);
        if (!$ids) {
            $this->setError('未传入ID');
            return false;
        }
        $params = $this->request->getParsedBody() ?: $this->request->request();
        unset($params['ids']);
        $operates = method_exists($this->model, 'getOperates') ? $this->model::getOperates() : [];
        if (!$operates) {
            $this->setError("没有可操作字段");
            return false;
        }
        foreach ($params as $k => $v) {
            if (!in_array($k, $operates)) {
                $this->setError('没有权限该选项进行操作');
                return false;
            }
        }
        if (!$params){
            $this->setError('没有传入修改信息');
            return false;
        }
        Db::getInstance()->beginTransaction();
        try {
            $pk = $this->model::getPk();
            $list = $this->model::query()->whereIn($pk, $ids)->select();
            $total = 0;
            if ($list->getRowCount() <= 0) {
                $this->setError('选择项不存在');
                return false;
            }
            foreach ($list->getArray() as $row) {
                $update = $row->update($params);
                $update->isSuccess() && $total += 1;
            }
            Db::getInstance()->commit();
        } catch (ServiceException $e) {
            Db::getInstance()->rollBack();
            Log::error($e);
            $this->setError($e->getMessage());
            return false;
        } catch (Exception $e) {
            Db::getInstance()->rollBack();
            Log::error($e);
            return false;
        }
        return $total;
    }
}