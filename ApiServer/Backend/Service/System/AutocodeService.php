<?php

declare(strict_types=1);

namespace ImiApp\ApiServer\Backend\Service\System;

use Imi\App;
use Imi\AppContexts;
use Imi\Bean\Annotation\Inherit;
use Imi\Config;
use Imi\Db\Db;
use Imi\Log\Log;
use Imi\Util\ClassObject;
use Imi\Util\File;
use Imi\Util\Imi;
use ImiApp\ApiServer\Backend\Model\SoAuthRule;
use ImiApp\ImiServer\AbstractModel;
use ImiApp\ImiServer\AbstractService;
use Imi\Bean\Annotation\Bean;
use ImiApp\ImiServer\Exception\ServiceException;

/**
 * @Inherit
 * @Bean("SystemAutocodeService")
 */
class AutocodeService extends AbstractService
{
    /**
     * @var string
     */
    public $model = null;

    public function exec($data)
    {
        return $this->execute($data->command);
    }

    protected function execute($cmd, $workdir = null): array
    {
        if (is_null($workdir)) {
            $workdir = File::path(App::get(AppContexts::APP_PATH), '/');
        }
        $descriptorspec = array(
            0 => array("pipe", "r"),  // stdin
            1 => array("pipe", "w"),  // stdout
            2 => array("pipe", "w"),  // stderr
        );
        $process = proc_open($cmd, $descriptorspec, $pipes, $workdir, null);
        $stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);
        return [
            'code' => proc_close($process),
            'out' => str_replace("\n", "<br>", trim($stdout)),
            'err' => trim($stderr),
        ];
    }

    public function build($data): bool|array
    {
        $column = $data->column; // 字段列表
        $path = $data->path; // 路径配置
        $path['name'] = trim($path['name'], '/');
        $relation = $data->relation; // 关联模型
        $other = $data->other; // 其他配置
        $model = str_replace('\\\\', '\\', $data->model); // 模型
        $download = $data->type == 'download';// 下载
        $del = $data->type == 'delete';// 删除
        $code = $data->type == 'code';// 预览
        if (!class_exists($model)) {
            $this->setError('模型不存在');
            return false;
        }
        $controllerNamespace = $this->getNamesapce($path['controller']);
        $serviceNamespace = $this->getNamesapce($path['service']);
        $validateNamespace = $this->getNamesapce($path['validate']);
        $vueAuth = trim(str_replace('/', '.', $other['route']), '.');
        $apiPath = $path['name'];
        $controller = ['namespace' => $controllerNamespace, 'controller' => $other['controller'], 'auth' => $other['auth'] ?? false, 'route' => $other['route'], 'class' => $this->getClassName($path['controller']), 'service' => $this->getClassName($path['service']), 'operate' => false, 'sort' => false];
        $service = ['namespace' => $serviceNamespace, 'model' => $model, 'service' => $this->getClassName($path['service']), 'class' => $this->getClassName($path['service'])];
        $validate = ['namespace' => $validateNamespace, 'class' => $this->getClassName($path['validate']), 'sort' => false, 'columns' => [], 'pri' => $model::getPk()];
        $index = ['sort' => false, 'auth' => $vueAuth, 'columns' => [], 'filter' => [], 'api' => $apiPath, 'pri' => $model::getPk()];
        $api = ['route' => $other['route'], 'sort' => false, 'operate' => false];
        $save = ['columns' => [], 'api' => $apiPath, 'pri' => $model::getPk()];
        $getSearchColumns = '';
        $getSortPk = '';
        $getOperates = '';
        foreach ($column as $k => $v) {
            $v['operate'] && $controller['operate'] = $api['operate'] = true;
            $v['sort'] && $validate['sort'] = $controller['sort'] = $api['sort'] = $index['sort'] = true;
            $v['require'] && $validate['columns'][$v['key']] = 'require';
            $v['table'] && $index['columns'][] = ['key' => $v['key'], 'name' => $v['name'], 'type' => $v['table_type']];
            $v['save'] && $save['columns'][] = ['key' => $v['key'], 'name' => $v['name'], 'type' => $v['save_type'], 'option' => $v['save_option']];
            $v['filter'] && $index['filter'][] = ['key' => $v['key'], 'name' => $v['name'], 'type' => $v['filter_type'], 'operator' => $v['filter_operator'], 'data' => $v['filter_data']];
            $v['search'] && $getSearchColumns .= '"' . $v['key'] . '",';
            $v['sort'] && $getSortPk = '"' . $v['key'] . '"';
            $v['operate'] && $getOperates .= '"' . $v['key'] . '",';
        }
        $modelPath = Imi::getNamespacePath($model) . '.php';
        $modelContent = file_get_contents($modelPath);
        if ($getSortPk) {
            $modelContent = $this->modelReplace($modelContent, 'getSortPk', $getSortPk);
        }
        if ($getOperates) {
            $getOperates = '[' . trim($getOperates, ',') . ']';
            $modelContent = $this->modelReplace($modelContent, 'getOperates', $getOperates);
        }
        if ($getSearchColumns) {
            $getSearchColumns = '[' . trim($getSearchColumns, ',') . ']';
            $modelContent = $this->modelReplace($modelContent, 'getSearchColumns', $getSearchColumns);
        }
        if ($relation) {
            $relationStr = "";
            foreach (array_filter(explode(',', $relation)) as $v) {
                $relationStr .= "'" . $v . "',";
            }
            $relationStr = '[' . trim($relationStr, ',') . ']';
            $modelContent = $this->modelReplace($modelContent, 'getWithAttribute', $relationStr);
        }
        $controllerClass = $controllerNamespace . '\\' . $this->getClassName($path['controller']) . '::';
        $sql = $this->getSql($controllerClass, $path['name'], $vueAuth, $controller['operate'], $controller['sort']);
        if ($code) {
            return [
                'controller' => $this->renderTemplate('Controller', $controller),
                'model' => $modelContent,
                'validate' => $this->renderTemplate('Validate', $validate),
                'service' => $this->renderTemplate('Service', $service),
                'index' => $this->renderTemplate('vue/index', $index),
                'save' => $this->renderTemplate('vue/save', $save),
                'api' => $this->renderTemplate('vue/api', $api),
                'auth_rule' => $sql,
            ];
        }
        if ($download) {
            $rootPath = File::path(App::get(AppContexts::APP_PATH), '/.runtime') . '/' . mt_rand(11111, 99999);
        } else {
            $rootPath = rtrim(File::path(App::get(AppContexts::APP_PATH), '/'), '/');
        }
        if ($del) {
            $rootPath = rtrim(File::path(App::get(AppContexts::APP_PATH), '/'), '/');
        }
        $controllerPath = $rootPath . $path['controller'];
        $modelPath = $rootPath . str_replace(File::path(App::get(AppContexts::APP_PATH), '/'), '/', $modelPath);
        $validatePath = $rootPath . $path['validate'];
        $servicePath = $rootPath . $path['service'];
        $indexPath = $rootPath . '/' . ltrim($path['vue'], '/') . 'views/' . $path['name'] . '/index.vue';
        $savePath = $rootPath . '/' . ltrim($path['vue'], '/') . 'views/' . $path['name'] . '/save.vue';
        $apiPath = $rootPath . '/' . ltrim($path['vue'], '/') . 'api/model/' . $path['name'] . '.js';
        $sqlPath = $rootPath . '/auth_rule.sql';
        if ($del) {
            @unlink($controllerPath);
            @unlink($validatePath);
            @unlink($servicePath);
            @unlink($indexPath);
            @unlink($savePath);
            @unlink($apiPath);
            return true;
        }
        if (!$download) {
            if (file_exists($controllerPath) || file_exists($validatePath) || file_exists($servicePath) || file_exists($indexPath) || file_exists($savePath) || file_exists($apiPath)) {
                $this->setError('已有文件存在，请先删除再生成');
                return false;
            }
        }
        File::putContents($controllerPath, $this->renderTemplate('Controller', $controller));
        File::putContents($modelPath, $modelContent);
        File::putContents($validatePath, $this->renderTemplate('Validate', $validate));
        File::putContents($servicePath, $this->renderTemplate('Service', $service));
        File::putContents($indexPath, $this->renderTemplate('vue/index', $index));
        File::putContents($savePath, $this->renderTemplate('vue/save', $save));
        File::putContents($apiPath, $this->renderTemplate('vue/api', $api));
        if ($download) {
            File::putContents($sqlPath, $sql);
            $zipFile = File::path(App::get(AppContexts::APP_PATH), '/.runtime') . '/build.zip';
            try {
                $zip = new \ZipArchive();
                if ($zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
                    $this->addFileToZip($rootPath, $zip, $rootPath);
                    $zip->close();
                } else {
                    File::deleteDir($rootPath);
                    $this->setError('创建文件失败，请检查runtime是否有写入权限');
                    return false;
                }
            } catch (\Exception $e) {
                File::deleteDir($rootPath);
                $this->setError('创建文件失败:' . $e->getMessage());
                return false;
            }
            File::deleteDir($rootPath);
        } else {
            Db::getNewInstance()->batchExec($sql);
        }
        return true;
    }

    protected function getSql($class, $name, $alias, $operate, $sort): string
    {
        $pid = SoAuthRule::find(['name' => 'Autocode'])?->getId() ?: false;
        $sql = 'SET @id = (SELECT max(id) from `so_auth_rule`) + 1;' . "\n";
        !$pid && $sql .= 'insert into `so_auth_rule`(`id`,`sort`,`status`,`pid`,`name`,`icon`,`alias`,`rule`,`type`,`path`,`create_time`) values(@id,0,1,0,"Autocode","sc-icon-code",null,null,"menu","/autocode",' . time() . ');' . "\n";
        $sql .= 'insert into `so_auth_rule`(`id`,`sort`,`status`,`pid`,`name`,`icon`,`alias`,`rule`,`type`,`path`,`create_time`) values((@id+1),(@id+1),1,' . ($pid ?: '@id') . ',"' . $name . '","sc-icon-code",null,null,"menu","' . ('/' . $name . '/index') . '",' . time() . ');' . "\n";
        $sql .= 'insert into `so_auth_rule`(`id`,`sort`,`status`,`pid`,`name`,`alias`,`rule`,`type`,`create_time`) values((@id+2),(@id+2),1,(@id+1),"创建","' . ($alias . '.create') . '","' . ($class . 'create') . '","button",' . time() . ');' . "\n";
        $sql .= 'insert into `so_auth_rule`(`id`,`sort`,`status`,`pid`,`name`,`alias`,`rule`,`type`,`create_time`) values((@id+3),(@id+3),1,(@id+1),"编辑","' . ($alias . '.update') . '","' . ($class . 'update') . '","button",' . time() . ');' . "\n";
        $sql .= 'insert into `so_auth_rule`(`id`,`sort`,`status`,`pid`,`name`,`alias`,`rule`,`type`,`create_time`) values((@id+4),(@id+4),1,(@id+1),"读取","' . ($alias . '.read') . '","' . ($class . 'read') . '","button",' . time() . ');' . "\n";
        $sql .= 'insert into `so_auth_rule`(`id`,`sort`,`status`,`pid`,`name`,`alias`,`rule`,`type`,`create_time`) values((@id+5),(@id+5),1,(@id+1),"删除","' . ($alias . '.delete') . '","' . ($class . 'delete') . '","button",' . time() . ');' . "\n";
        $operate && $sql .= 'insert into `so_auth_rule`(`id`,`sort`,`status`,`pid`,`name`,`alias`,`rule`,`type`,`create_time`) values((@id+6),(@id+6),1,(@id+1),"操作","' . ($alias . '.operate') . '","' . ($class . 'operate') . '","button",' . time() . ');' . "\n";
        $sort && $sql .= 'insert into `so_auth_rule`(`id`,`sort`,`status`,`pid`,`name`,`alias`,`rule`,`type`,`create_time`) values((@id+' . ($operate ? 7 : 6) . '),(@id+' . ($operate ? 7 : 6) . '),1,(@id+1),"排序","' . ($alias . '.sort') . '","' . ($class . 'sort') . '","button",' . time() . ');' . "\n";
        return $sql;
    }

    protected function addFileToZip($path, $zip, $root)
    {
        $handler = opendir($path);
        while (($filename = readdir($handler)) !== false) {
            if ($filename != "." && $filename != "..") {
                if (is_dir($path . "/" . $filename)) {
                    $this->addFileToZip($path . "/" . $filename, $zip, $root);
                } else {
                    $zip->addFile($path . '/' . $filename, str_replace($root, '', $path) . "/" . $filename);
                }
            }
        }
        closedir($handler);
    }

    protected function modelReplace($content, $key, $value): array|string
    {
        $type = in_array($key, ['getSortPk', 'getSortBy']) ? "string" : "array";
        preg_match('!' . $key . '(.*?)}!ms', $content, $yes);
        if ($yes[0] ?? false) {
            $getWithAttribute = $key . "(): " . $type . "\n\t{\n\t\treturn " . $value . ";\n\t}";
            $content = str_replace($yes[0], $getWithAttribute, $content);
        } else {
            $content = trim(trim(trim(trim($content), "\n"), '?>'), '}');
            $content .= "\n\tpublic static function " . $key . "(): " . $type . "\n\t{\n\t\treturn " . $value . ";\n\t}\n}";
        }
        return $content;
    }

    protected function getNamesapce($path): string
    {
        $namespace = Config::get("@app.namespace");
        $path = str_replace(basename($path), '', $path);
        $path = trim($path, '/');
        return $namespace . '\\' . str_replace('/', '\\', $path);
    }

    protected function getClassName($path): string
    {
        return str_replace('.php', '', basename($path));
    }

    public function getInfo($model): array
    {
        $model = str_replace("\\\\", "\\", $model);
        if (!$model || !class_exists($model)) {
            return [];
        }
        $columns = (array)$model::query()->bindValues(['table_name' => $model::getTable(), 'table_schema' => Config::get("@app.pools.maindb.resource.database")])->execute("SELECT * FROM information_schema.columns where TABLE_SCHEMA = :table_schema AND table_name = :table_name ORDER BY ORDINAL_POSITION")->getArray();
        $info = [
            'key' => 'id',
            'name' => '',
            'table' => true,
            'save' => true,
            'search' => true,
            'filter' => true,
            'filter_type' => 'text',
            'filter_data' => 'json',
            'filter_operator' => '=',
            'table_type' => 'sort/text/tag',
            'save_type' => 'input/select/radio/switch',
            'save_option' => 'json',
            'operate' => true,
            'sort' => true,
            'require' => true,
        ];
        $infos = [];
        $require = ['create_time', 'update_time', $model::getPk(), 'delete_time'];
        foreach ($columns as $k => $column) {
            $row = $info;
            $row['key'] = $column['COLUMN_NAME'];
            $row['name'] = $column['COLUMN_COMMENT'] ?: $row['key'];
            $row['table'] = (bool)$this->getTableType($column);
            $row['table_type'] = $this->getTableType($column);
            $row['save'] = (bool)$this->getSaveType($column);
            $row['save_type'] = $this->getSaveType($column);
            $row['save_option'] = $this->getSaveOption($column);
            $row['search'] = $column['COLUMN_KEY'] == 'PRI';
            !$row['save'] && $require[] = $column['COLUMN_NAME'];
            $row['require'] = !in_array($column['COLUMN_NAME'], $require);
            $filter = $this->getFilter($column);
            if ($filter) {
                $row['filter'] = true;
                list($operate, $type, $data) = $filter;
                $row['filter_type'] = $type;
                $row['filter_data'] = $data;
                $row['filter_operator'] = $operate;
            } else {
                $row['filter'] = false;
                $row['filter_type'] = '';
                $row['filter_data'] = '';
                $row['filter_operator'] = '';
            }
            $row['sort'] = in_array($column['COLUMN_NAME'], ['sort', 'weigh']);
            $row['operate'] = in_array($column['COLUMN_NAME'], ['status', 'state']);
            $infos[] = $row;
        }
        return $infos;
    }

    public function getModels(): array
    {
        $namespaces = (array)Config::get("@app.subServers");
        $namespaces[] = Config::get("@app.mainServer");
        $files = [];
        foreach ($namespaces as $item) {
            $namespace = $item['namespace'];
            $path = Imi::getNamespacePath($namespace);
            $path && getModelFiles($path, $files);
        }
        return $files;
    }

    protected function getSaveType($v)
    {
        $inputType = 'text';
        if ($v['COLUMN_KEY'] == 'PRI') {
            return '';
        }
        if (in_array($v['COLUMN_NAME'], ['sort', 'weigh', 'create_time', 'update_time'])) {
            return '';
        }
        switch ($v['DATA_TYPE']) {
            case 'bigint':
            case 'int':
            case 'mediumint':
            case 'smallint':
            case 'tinyint':
                $inputType = 'number';
                break;
            case 'enum':
            case 'set':
                $inputType = 'select';
                break;
            case 'decimal':
            case 'double':
            case 'float':
                $inputType = 'number';
                break;
            case 'longtext':
            case 'text':
            case 'mediumtext':
            case 'smalltext':
            case 'tinytext':
                $inputType = 'textarea';
                break;
            case 'year':
            case 'date':
            case 'time':
            case 'datetime':
            case 'timestamp':
                $inputType = 'datetime';
                break;
            default:
                break;
        }
        $fieldsName = $v['COLUMN_NAME'];
        // 指定后缀说明也是个时间字段
        if ($this->isMatchSuffix($fieldsName, ['time'])) {
            $inputType = 'datetime';
        }
        // 指定后缀结尾且类型为enum,说明是个单选框
        if ($this->isMatchSuffix($fieldsName, ['type', 'action', 'status', 'state']) && $v['DATA_TYPE'] == 'enum') {
            $inputType = "radio";
        }
        // 指定后缀结尾且类型为set,说明是个复选框
        if ($this->isMatchSuffix($fieldsName, ['data', 'checkbox']) && $v['DATA_TYPE'] == 'set') {
            $inputType = "checkbox";
        }
        // 指定后缀结尾且类型为char或tinyint且长度为1,说明是个Switch复选框
        if ($this->isMatchSuffix($fieldsName, ['status', 'type', 'state']) && (str_contains($v['COLUMN_TYPE'], 'int') || str_contains($v['COLUMN_TYPE'], 'char'))) {
            $inputType = "switch";
        }
        if ($this->isMatchSuffix($fieldsName, ['image', 'thumb', 'avatar', 'img'])) {
            $inputType = "image";
        }
        if ($this->isMatchSuffix($fieldsName, ['images', 'thumbs', 'avatars', 'imgs'])) {
            $inputType = "images";
        }
        if ($this->isMatchSuffix($fieldsName, ['color', 'rgb'])) {
            $inputType = "color";
        }
        if ($this->isMatchSuffix($fieldsName, ['slider'])) {
            $inputType = "slider";
        }
        return $inputType;
    }

    protected function getSaveOption($v): bool|string
    {
        $type = $this->getSaveType($v);
        if ($type == 'radio') {
            if (str_contains($v['COLUMN_TYPE'], 'enum(')) {
                $enum = str_replace(["enum(", ")", '"', "'"], '', $v['COLUMN_TYPE']);
                $enum = explode(',', $enum);
                $_enum = [];
                foreach ($enum as $en) {
                    $_enum[$en] = $en;
                }
                $option = json_encode($_enum, 256 | 64);
            } else {
                $option = '["关闭","开启"]';
            }
        } elseif ($type == 'checkbox') {
            if (str_contains($v['COLUMN_TYPE'], 'set(')) {
                $enum = str_replace(["set(", ")", '"', "'"], '', $v['COLUMN_TYPE']);
                $enum = explode(',', $enum);
                $_enum = [];
                foreach ($enum as $en) {
                    $_enum[$en] = $en;
                }
                $option = json_encode($_enum, 256 | 64);
            } else {
                $option = '{"test":"复选测试"}';
            }
        } elseif ($type == 'switch') {
            return '["关闭","开启"]';
        } else {
            return "";
        }
        return $option;
    }

    protected function getFilter($v): array|bool
    {
        $type = $this->getTableType($v);
        if ($type == 'datetime') {
            return ['between', 'datetimerange', ''];
        }
        if ($type == 'switch') {
            return ['=', 'select', '[{label:"开启",value:1},{label:"关闭",value:0}]'];
        }
        if ($type == 'text') {
            return ['=', 'text', ''];
        }
        return false;
    }

    protected function getTableType($v): string
    {
        $inputType = 'text';
        if (in_array($v['DATA_TYPE'], ['longtext', 'text', 'mediumtext', 'smalltext', 'tinytext'])) {
            return '';
        }
        $fieldsName = $v['COLUMN_NAME'];
        if ($this->isMatchSuffix($fieldsName, ['time'])) {
            $inputType = 'datetime';
        }
        if ($this->isMatchSuffix($fieldsName, ['state', 'status']) && str_contains($v['DATA_TYPE'], 'int')) {
            $inputType = "switch";
        }
        if ($this->isMatchSuffix($fieldsName, ['sort', 'weigh', 'paixu'])) {
            $inputType = "sort";
        }
        if ($this->isMatchSuffix($fieldsName, ['image', 'thumb', 'img', 'avatar'])) {
            $inputType = "image";
        }
        return $inputType;
    }

    protected function isMatchSuffix($field, $suffixArr): bool
    {
        $suffixArr = is_array($suffixArr) ? $suffixArr : explode(',', $suffixArr);
        foreach ($suffixArr as $k => $v) {
            if (preg_match("/{$v}$/i", $field)) {
                return true;
            }
        }
        return false;
    }

    private function renderTemplate(string $template, array $data): string
    {
        $path = File::path(App::get(AppContexts::APP_PATH), '/ImiServer/Tpl/');
        extract($data);
        ob_start();
        include $path . $template . '.tpl';
        return ob_get_clean();
    }
}
