<?php

use Imi\Log\LogLevel;

$rootPath = dirname(__DIR__) . '/';

return [
    'ModuleRoute' => [
        'backend' => 'super',
    ],
    'AuthConfig' => [
        // 是否开启
        'status' => true,
        // 配置名称-默认配置
        'default' => [
            // 鉴权方式 Session稍后支持
            'auth' => \Phpben\Imi\Auth\Jwt::class,
            // IMI-缓存配置名称
            'cache' => "redis",
            // 一个账号只能一个人登陆
            'unique' => true,
            // 是否判断权限规则
            'check' => true,
            // JWT配置 结合IMI-JWT组件使用
            'jwt' => [
                // IMI-JWT名称
                'name' => 'default',
                // JWT Header名称
                'header_name' => 'Authorization',
                // JWT 前缀
                'prefix' => 'Bearer ',
            ],
            // 错误配置
            'error' => [
                // 错误Code值
                'code' => 401,
                // 错误http状态码
                'status_code' => 401,
                // 错误消息
                'message' => 'auth error',
            ],
            // 模型配置
            'model' => [
                // 用户表模型
                'user' => \ImiApp\ApiServer\Backend\Model\SoAdmin::class,
                // 登陆日志表模型
                'login_log' => \ImiApp\ApiServer\Backend\Model\SoAdminLoginLog::class,
                // 操作日志表模型
                'operate_log' => \ImiApp\ApiServer\Backend\Model\SoAdminOperateLog::class,
                // 权限组模型
                'auth_group' => \ImiApp\ApiServer\Backend\Model\SoAuthGroup::class,
                // 权限组关系表模型
                'auth_group_access' => \ImiApp\ApiServer\Backend\Model\SoAuthGroupAccess::class,
                // 权限规则表模型
                'auth_rule' => \ImiApp\ApiServer\Backend\Model\SoAuthRule::class,
            ],
            // 设置
            'settings' => [
                // 登陆日志
                'login_log' => true,
                // 操作日志
                'operate_log' => true,
                // Hash密码类
                'hash' => \Phpben\Imi\Auth\Hasher\Md5Salt::class,
                // Hash类配置
                'hash_option' => [

                ],
                // 用户表字段
                'user_keys' => [
                    // username唯一用户名
                    'username' => 'username',
                    // password 密码
                    'password' => 'password',
                    // salt 密码盐，非必需
                    'salt' => 'salt',
                    // token 存入字段
                    'token' => 'token'
                ],
                // 规则表字段
                'auth_rule_keys' => [
                    // 规则表字段 内容例： ImiApp\ApiServer\Controller\TestController::login
                    'rule' => 'rule',
                    // 规则所属分组字段
                    'pid' => 'pid',
                ],
                'auth_group_keys' => [
                    // 规则Ids字段 内容例：1,3,5,7,9 支持*
                    'ids' => 'rules',
                    // 开关字段 1/0判断
                    'status' => 'status',
                    // 所属user字段id
                    'pid' => 'pid'
                ],
                'auth_group_access_keys' => [
                    // 用户id
                    'user_id' => 'uid',
                    // auth_group组id
                    'group_id' => 'gid'
                ]
            ]
        ],
        // 后端
        'backend' => [
            // 鉴权方式 Session稍后支持
            'auth' => \Phpben\Imi\Auth\Jwt::class,
            // IMI-缓存配置名称
            'cache' => "redis",
            // 一个账号只能一个人登陆
            'unique' => true,
            // 是否判断权限规则
            'check' => true,
            // JWT配置 结合IMI-JWT组件使用
            'jwt' => [
                // IMI-JWT名称
                'name' => 'default',
                // JWT Header名称
                'header_name' => 'Authorization',
                // JWT 前缀
                'prefix' => 'Bearer ',
            ],
            // 错误配置
            'error' => [
                // 错误Code值
                'code' => 401,
                // 错误http状态码
                'status_code' => 401,
                // 错误消息
                'message' => 'auth error',
            ],
            // 模型配置
            'model' => [
                // 用户表模型
                'user' => \ImiApp\ApiServer\Backend\Model\SoAdmin::class,
                // 登陆日志表模型
                'login_log' => \ImiApp\ApiServer\Backend\Model\SoAdminLoginLog::class,
                // 操作日志表模型
                'operate_log' => \ImiApp\ApiServer\Backend\Model\SoAdminOperateLog::class,
                // 权限组模型
                'auth_group' => \ImiApp\ApiServer\Backend\Model\SoAuthGroup::class,
                // 权限组关系表模型
                'auth_group_access' => \ImiApp\ApiServer\Backend\Model\SoAuthGroupAccess::class,
                // 权限规则表模型
                'auth_rule' => \ImiApp\ApiServer\Backend\Model\SoAuthRule::class,
            ],
            // 设置
            'settings' => [
                // 登陆日志
                'login_log' => true,
                // 操作日志
                'operate_log' => true,
                // Hash密码类
                'hash' => \Phpben\Imi\Auth\Hasher\Md5Salt::class,
                // Hash类配置
                'hash_option' => [

                ],
                // 用户表字段
                'user_keys' => [
                    // username唯一用户名
                    'username' => 'username',
                    // password 密码
                    'password' => 'password',
                    // salt 密码盐，非必需
                    'salt' => 'salt',
                    // token 存入字段
                    'token' => 'token'
                ],
                // 规则表字段
                'auth_rule_keys' => [
                    // 规则表字段 内容例： ImiApp\ApiServer\Controller\TestController::login
                    'rule' => 'rule',
                    // 规则所属分组字段
                    'pid' => 'pid',
                ],
                'auth_group_keys' => [
                    // 规则Ids字段 内容例：1,3,5,7,9 支持*
                    'ids' => 'rules',
                    // 开关字段 1/0判断
                    'status' => 'status',
                    // 所属user字段id
                    'pid' => 'pid'
                ],
                'auth_group_access_keys' => [
                    // 用户id
                    'user_id' => 'uid',
                    // auth_group组id
                    'group_id' => 'gid'
                ]
            ]
        ],
    ],
    'hotUpdate' => [
        // 'status'    =>    false, // 关闭热更新去除注释，不设置即为开启，建议生产环境关闭

        // --- 文件修改时间监控 ---
        // 'monitorClass'    =>    \Imi\HotUpdate\Monitor\FileMTime::class,
        'timespan' => 1, // 检测时间间隔，单位：秒

        // --- Inotify 扩展监控 ---
        'monitorClass' => extension_loaded('inotify') ? \Imi\HotUpdate\Monitor\Inotify::class : \Imi\HotUpdate\Monitor\FileMTime::class,
        // 'timespan'    =>    1, // 检测时间间隔，单位：秒，使用扩展建议设为0性能更佳

        // 'includePaths'    =>    [], // 要包含的路径数组
        'excludePaths' => [
            $rootPath . '.git',
            $rootPath . '.idea',
            $rootPath . '.vscode',
            $rootPath . 'vendor',
        ], // 要排除的路径数组，支持通配符*
    ],
    'JWT' => [
        'list' => [
            'default' => [
                'signer' => 'Rsa',
                'algo' => 'Sha256',
                'id' => 'default',
                'expires' => 86400,
                'privateKey' => '-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQDPYjpnWby7X2fCtwLZ78B4Quc9L7t1QTChRq5E9TanTuf9t3xL
mzCfJyNCA2U22kdfT5OBcAAwcyDaF5RxeSajXucl+rUDPTvuqqhqgAdw0NChsDrp
BZ+wGH4sNYfFyQZeQQtCr4p3lerveCHhzik51ie9c0f8gacvKTH7yj18DwIDAQAB
AoGAd6udPCpiaFWDkK7+7DgXfs5MldhHekAmCcq5oX1HDoDQCm6pQQ/KnOx+wgcn
juGisfM/kT/KPCsTWAanWFuq2SzS+J+iVaLvSOEDulvvP3WO+6tOnO+otQlafFO5
VFmBw785edX6iCtcxTqGCKrsr+35EvudCN7JCPMvfHKBzgECQQD2Zp9U0YwiCEiB
TRlZv4z+ypHDXLwsuiAZsBRX5WVFrHreUt7MsQJ6Youni2OWyHllZ6pL7OijqRMC
o4Fg6v6PAkEA13Z771eTnBv/n0J26SgzST2vBy9SzrRixrfaAb5tp0EojBlp4ywA
N3TWFbGI8iVyeysMvs+nkt4zkh4AqNRqgQJBAO5HpZNvpXWPzxYDih1piR8opDdp
6avTPpG43qN1ei8bsiJnv3/xObVCsU0QFfnN2t++lUghTYRfT7wAhHBGMG8CQHhb
jlWfhSxCE6PiG8yYkTWLiHcp/0bKSxcYYmZw+o3gfwbrt1OYI7LWyDQsDQS+2Fln
LeJ02vXWu9YWfmXQ6oECQQCtiBGLdlNo/Ec06/kdGMcyVMoOQHlnL4oajmxJTogV
UGYay7dhUs3Lei0vw0iz+N9h+l4ohrSV24OkgYUkgSzn
-----END RSA PRIVATE KEY-----',// 私钥
                'publicKey' => '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDPYjpnWby7X2fCtwLZ78B4Quc9
L7t1QTChRq5E9TanTuf9t3xLmzCfJyNCA2U22kdfT5OBcAAwcyDaF5RxeSajXucl
+rUDPTvuqqhqgAdw0NChsDrpBZ+wGH4sNYfFyQZeQQtCr4p3lerveCHhzik51ie9
c0f8gacvKTH7yj18DwIDAQAB
-----END PUBLIC KEY-----',// 公钥
            ],
        ],
    ],

];
