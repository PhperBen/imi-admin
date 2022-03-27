<?php

declare(strict_types=1);

namespace ImiApp\ImiServer\Command;

use Composer\Script\Event;
use Composer\Factory;

if (!function_exists('str_starts_with')) {
    function str_starts_with($haystack, $needle): bool
    {
        $len = mb_strlen($needle);
        return mb_substr($haystack, 0, $len) === $needle;
    }
}

class Install
{
    /**
     * 安装imi-admin
     * @param Event $event
     * @return void
     */
    public static function run(Event $event)
    {
        $io = $event->getIO();
        $composer = $event->getComposer();
        $mysql_driver = 'Mysql';
        $mysql_host = $io->askAndValidate(
            $mysql_driver . "地址\n默认 [127.0.0.1]：",
            function ($value) {
                return $value;
            },
            null,
            '127.0.0.1'
        );
        $mysql_port = $io->askAndValidate(
            $mysql_driver . "端口\n默认 [3306]：",
            function ($value) {
                return $value;
            },
            null,
            '3306'
        );
        $mysql_database = $io->askAndValidate(
            $mysql_driver . "库名：",
            function ($value) {
                if (!$value) {
                    throw new \InvalidArgumentException('数据库库名不能为空');
                }
                return $value;
            },
            null,
            null
        );
        $mysql_username = $io->askAndValidate(
            $mysql_driver . "账号：",
            function ($value) {
                if (!$value) {
                    throw new \InvalidArgumentException('数据库账号不能为空');
                }
                return $value;
            },
            null,
            null
        );
        $mysql_password = $io->askAndValidate(
            $mysql_driver . "密码：",
            function ($value) {
                if (!$value) {
                    $value = '';
                }
                return $value;
            },
            null,
            null
        );
        $redis_host = $io->askAndValidate(
            "Redis地址\n默认 [localhost]：",
            function ($value) {
                return $value;
            },
            null,
            'localhost'
        );
        $redis_auth = $io->askAndValidate(
            "Redis密码\n默认 [null]：",
            function ($value) {
                return $value;
            },
            null,
            'null'
        );
        $redis_port = $io->askAndValidate(
            "Redis端口\n默认 [6379]：",
            function ($value) {
                return $value;
            },
            null,
            '6379'
        );
        $confirm = $io->askAndValidate(
            "即将覆盖env与mysql\n是否继续（请确保目录权限与库是否存在） 默认[Y]：",
            function ($value) {
                return $value;
            },
            null,
            'y'
        );
        if (!in_array($confirm, ['y', 'yes', 'Y'])) {
            throw new \InvalidArgumentException('不允许覆盖！close');
        }
        echo '安装中......' . "\n" . "\n";
        $env = file_get_contents(dirname(__DIR__) . '/Tpl/env.tpl');
        $sql = file_get_contents(dirname(__DIR__) . '/Sql/install.sql');
        $env = str_replace(['{mysql_host}', '{mysql_port}', '{mysql_database}', '{mysql_username}', '{mysql_password}', '{redis_host}', '{redis_port}', '{redis_password}'], [$mysql_host, $mysql_port, $mysql_database, $mysql_username, $mysql_password, $redis_host, $redis_port, $redis_auth], $env);
        $composerFile = Factory::getComposerFile();
        $projectRoot = realpath(dirname($composerFile));
        $projectRoot = rtrim($projectRoot, '/\\') . '/';
        try {
            file_put_contents($projectRoot . '/.env', $env);
        } catch (\Throwable $e) {
            throw new \InvalidArgumentException('写入env失败');
        }
        try {
            $pdo = new \PDO(strtolower($mysql_driver) . ":host={$mysql_host}" . ($mysql_port ? ";port={$mysql_port}" : ''), $mysql_username, $mysql_password);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $pdo->query("CREATE DATABASE IF NOT EXISTS `{$mysql_database}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            $pdo->exec("USE `{$mysql_database}`");
            $pdo->exec($sql);
            $updateSqls = scandir(dirname(__DIR__) . '/Sql/');
            foreach ($updateSqls as $file) {
                if (str_starts_with($file, 'update')) {
                    $sqlContent = file_get_contents(dirname(__DIR__) . '/Sql/' . $file);
                    $pdo->exec($sqlContent);
                }
            }
        } catch (\PDOException $e) {
            throw new \InvalidArgumentException($e->getMessage());
        }
        echo '安装完成，后端默认账号admin密码123456' . "\n";
    }
}